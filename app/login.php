<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");

	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		
	session_start();
	if(isset($_SESSION["logged"])) {
		if($_SESSION["logged"] == 1) {
			header('Location: /app/index.php');
		}
	}
	
	
?>

<html lang="pl-PL">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>
		
		<form action="#" id="forma">
			 <table class="creds">
			  <tr>
				<td colspan="2">
					<h3>Logowanie</h3>
				</td>
			  </tr>
			  
			  <tr>
				<td colspan="2">
					<label for="email">Adres email:</label>
				</td>
			  </tr>
			  <tr>
				<td colspan="2">
					<input type="text" id="email" name="email" placeholder="Email">
				</td>
			  </tr>
			  
			  <tr>
				<td colspan="2">
					<label for="pass">Hasło:</label>
				</td>
			  </tr>
			  <tr>
				<td colspan="2">
					<input type="password" id="pass" name="pass" placeholder="Hasło">
				</td>
			  </tr>
			  
			  <tr>
				<td colspan="2">
					<span class="error" id="userErrorHandler"></span>
				</td>
			  </tr>
			  
			  <tr>
				<td colspan="2">
					<button type="button" class="btn-green" id="send">Zaloguj</button>
				</td>
			  </tr>

			  <tr>
				<td colspan="2">
					<button id="powrot" class="btn-blue">Powróć do strony głównej</button>
				</td>
			  </tr>
			   
			</table> 
		</form>
		
		<script>
		
		document.querySelector("#powrot").addEventListener('click', (e) => {
			e.preventDefault();
			document.location.href="index.php";
		});
		
		document.querySelector("#send").addEventListener('click', () => {
			let obj = createCredentials();
			let jsonData = JSON.stringify(obj); 
			console.log(jsonData);
			sendData(jsonData);
		});

		function updateFormErrors(errors) {
			document.querySelector("#userErrorHandler").textContent = errors["userError"];
		}
			
		function createCredentials() {
			let email = document.querySelector("#email").value;
		    let haslo = document.querySelector("#pass").value;
			let obj = {'email': email, 'haslo': haslo};
			return obj;
		}
		
		function sendData(data) {
			let req = new XMLHttpRequest();
			req.open('POST', 'login.php', true); 
			req.setRequestHeader('Content-type','application/json');
		
			req.onreadystatechange = function () {
			  if (req.readyState == 4) {
				 if(req.status == 200) {
					 console.log(req.responseText);
					let jsonRes = JSON.parse(req.responseText);
					if(jsonRes["errors"] == 1) {
						updateFormErrors(jsonRes);
					} else {
						console.log("Udalo sie zalogować na konto");
						document.querySelector("#userErrorHandler").textContent = "";
						window.location.reload(true);
					}
				 } else
				  console.log("Błąd podczas ładowania strony\n");
			  }
			};
			
			req.send(data);
			
		}
		
		</script>
	</body>
</html>

<?php 
	} else if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$root = realpath($_SERVER["DOCUMENT_ROOT"]);
		require_once("$root/app/utils/userImports.php");
		
		session_start();
		if(isset($_SESSION["logged"])) {
			if($_SESSION["logged"] == 1) {
				header('Location: /app/index.php');
			}
		}
		
		require_once("$root/app/utils/validator.php");
		
		
		$str_json = file_get_contents('php://input');
		$json = json_decode($str_json, true);
		
		header('Content-type: application/json');
		
		require_once("$root/app/repository/accessData.php");
		$accessData = new AccessData();

		$user = $accessData->pobierzUzytkownikaEmailPassword($json["email"], $json["haslo"]);
		
		if($user == NULL) {
			$response["errors"] = 1;
			$response["userError"] = "Wprowadzono błędne dane.";
			echo json_encode($response);
			return;
		} else {
			$response["errors"] = 0;

			//operator danych nie posiada jeszcze żadnej funkcjonalności
			//Wybór odpowiedniej klasy użytkownika przy logowaniu do systemu
			switch($user->getRole()->getRoleName()) {
				case "KL":
					$user = Klient::createUserWithCredentials($user->getUserId(), $user->getEmail(), $user->getPhone(), $user->getPassword(), $user->getFirstName(), $user->getLastName(), $user->getDateOfBirth(), $user->getCity(), $user->getPostalCode(), $user->getAddress(), $user->getRole());
					break;
				case "PI":
					$user = Pilot::createUserWithCredentials($user->getUserId(), $user->getEmail(), $user->getPhone(), $user->getPassword(), $user->getFirstName(), $user->getLastName(), $user->getDateOfBirth(), $user->getCity(), $user->getPostalCode(), $user->getAddress(), $user->getRole());
					break;
				case "OD":
					$user = OperatorDanych::createUserWithCredentials($user->getUserId(), $user->getEmail(), $user->getPhone(), $user->getPassword(), $user->getFirstName(), $user->getLastName(), $user->getDateOfBirth(), $user->getCity(), $user->getPostalCode(), $user->getAddress(), $user->getRole());
					break;
				case "OL":
					$user = OperatorLotow::createUserWithCredentials($user->getUserId(), $user->getEmail(), $user->getPhone(), $user->getPassword(), $user->getFirstName(), $user->getLastName(), $user->getDateOfBirth(), $user->getCity(), $user->getPostalCode(), $user->getAddress(), $user->getRole());
					break;
				case "OS":
					$user = OperatorSystemu::createUserWithCredentials($user->getUserId(), $user->getEmail(), $user->getPhone(), $user->getPassword(), $user->getFirstName(), $user->getLastName(), $user->getDateOfBirth(), $user->getCity(), $user->getPostalCode(), $user->getAddress(), $user->getRole());
					break;
				case "OZ":
					$user = OperatorZamowien::createUserWithCredentials($user->getUserId(), $user->getEmail(), $user->getPhone(), $user->getPassword(), $user->getFirstName(), $user->getLastName(), $user->getDateOfBirth(), $user->getCity(), $user->getPostalCode(), $user->getAddress(), $user->getRole());
					break;
			}
			
			//Przypisanie użytkownika do sesji
			$_SESSION["user"] = $user;
			$_SESSION["logged"] = 1;
			
			echo json_encode($response);
		}
	}
?>
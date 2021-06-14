<?php

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
					<h3>Rejestracja</h3>
				</td>
			  </tr>

			  <tr>
				<td>
					<label for="imie">Imię:</label>
				</td>
				<td>
					<label for="nazwisko">Nazwisko:</label>
				</td>
			  </tr>
			  <tr>
				<td>
					<input type="text" id="imie" name="imie" placeholder="Imie">
				</td>
				<td>
					<input type="text" id="nazwisko" name="nazwisko" placeholder="Nazwisko">
				</td>
				
			  </tr>
			  <tr>
				<td>
					<span class="error" id="imieErrorHandler"></span>
				</td>
				<td>
					<span class="error" id="nazwiskoErrorHandler"></span>
				</td>
			  </tr>
			  
			  <tr>
				<td>
					<label for="telefon">Telefon:</label>
				</td>
				<td>
					<label for="dataUrodzenia">Data urodzenia:</label>
				</td>
			  </tr>
			  <tr>
				<td>
					<input type="text" id="telefon" name="telefon" placeholder="Telefon (XXX-XXX-XXX)">
				</td>
				<td>
					<input type="date" id="dataUrodzenia" name="dataUrodzenia">
				</td>
			  </tr>
			  <tr>
				<td>
					<span class="error" id="telefonErrorHandler"></span>
				</td>
				<td>
					<span class="error" id="dataUrodzeniaErrorHandler"></span>
				</td>
			  </tr>
		
			  <tr>
				<td>
					<label for="kodPocztowy">Kod pocztowy:</label>
				</td>
				<td>
					<label for="miasto">Miasto:</label>
				</td>
			  </tr>
			  <tr>
				<td>
					<input type="text" id="kodPocztowy" name="kodPocztowy" placeholder="Kod pocztowy (XX-XXX)">
				</td>
				<td>
					<input type="text" id="miasto" name="miasto" placeholder="Miasto">
				</td>
			  </tr>
			  <tr>
				<td>
					<span class="error" id="kodPocztowyErrorHandler"></span>
				</td>
				<td>
					<span class="error" id="miastoErrorHandler"></span>
				</td>
			  </tr>
			  
			  <tr>
				<td colspan="2">
					<label for="adres">Adres zamieszkania:</label>
				</td>
			  </tr>
			  <tr>
				<td colspan="2">
					<input type="text" id="adres" name="adres" placeholder="Adres Zamieszkania">
				</td>
			  </tr>
			  <tr>
				<td colspan="2">
					<span class="error" id="adresErrorHandler"></span>
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
					<span class="error" id="emailErrorHandler"></span>
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
					<span class="error" id="passErrorHandler"></span>
				</td>
			  </tr>
			  
			  <tr>
				<td colspan="2">
					<label for="rePass">Powtórz hasło:</label>
				</td>
			  </tr>
			  <tr>
				<td colspan="2">
					<input type="password" id="rePass" name="rePass" placeholder="Powtórz hasło">
				</td>
			  </tr>
			   <tr>
				<td colspan="2">
					<span class="error" id="rePassErrorHandler"></span>
				</td>
			  </tr>
			  
			  <tr>
				<td>
					<button type="reset" class="btn-red">Zresetuj formularz</button>
				</td>
				<td>
					<button type="button" class="btn-green" id="send">Wyślij</button>
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
			document.querySelector("#imieErrorHandler").textContent = errors["imieError"];
		    document.querySelector("#nazwiskoErrorHandler").textContent = errors["nazwiskoError"];
			document.querySelector("#telefonErrorHandler").textContent  = errors["telefonError"];;
			document.querySelector("#dataUrodzeniaErrorHandler").textContent = errors["dataUrodzeniaError"];
			document.querySelector("#kodPocztowyErrorHandler").textContent = errors["kodPocztowyError"];
			document.querySelector("#miastoErrorHandler").textContent = errors["miastoError"];
			document.querySelector("#adresErrorHandler").textContent = errors["adresError"];
			document.querySelector("#emailErrorHandler").textContent = errors["emailError"];
			document.querySelector("#passErrorHandler").textContent = errors["passError"];
			document.querySelector("#rePassErrorHandler").textContent = errors["rePassError"];
		}
			
		function createCredentials() {
			let imie = document.querySelector("#imie").value;
		    let nazwisko = document.querySelector("#nazwisko").value;
			let telefon = document.querySelector("#telefon").value;
			let dataUrodzenia = document.querySelector("#dataUrodzenia").value;
			let kodPocztowy = document.querySelector("#kodPocztowy").value;
			let miasto = document.querySelector("#miasto").value;
			let adresZamieszkania = document.querySelector("#adres").value;
			let adresEmail = document.querySelector("#email").value;
			let haslo = document.querySelector("#pass").value;
			let reHaslo = document.querySelector("#rePass").value;
			
			let obj = {'imie': imie, 'nazwisko': nazwisko, 'telefon': telefon, 'dataUrodzenia': dataUrodzenia, 'kodPocztowy': kodPocztowy, 'miasto': miasto, 'adresZamieszkania': adresZamieszkania, 'adresEmail': adresEmail, 'haslo': haslo, 'reHaslo': reHaslo};
			
			return obj;
		}
		
		function sendData(data) {
			let req = new XMLHttpRequest();
			req.open('POST', 'register.php', true); 
			req.setRequestHeader('Content-type','application/json');
		
			req.onreadystatechange = function () {
			  if (req.readyState == 4) {
				 if(req.status == 200) {
					console.log(req.responseText);
					let jsonRes = JSON.parse(req.responseText);
					if(jsonRes["errors"] == 1) {
						updateFormErrors(jsonRes);
					} else {
						document.querySelector("#emailErrorHandler").textContent = "";
						alert("Udalo sie zalozyc konto");
						window.location.href = "index.php";
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
		
		session_start();
		if(isset($_SESSION["logged"])) {
			if($_SESSION["logged"] == 1) {
				header('Location: /app/index.php');
			}
		}
		
		$root = realpath($_SERVER["DOCUMENT_ROOT"]);
		require_once("$root/app/utils/validator.php");
		require_once("$root/app/utils/userImports.php");
		
		$str_json = file_get_contents('php://input');
		$json = json_decode($str_json, true);
		
		$json["imie"] = ucfirst($json["imie"]);
		$json["nazwisko"] = ucfirst($json["nazwisko"]);
		$json["miasto"] = ucfirst($json["miasto"]);
		$json["adresZamieszkania"] = ucfirst($json["adresZamieszkania"]);
		
		$response["imieError"] = validator::validateFirstName($json["imie"]);
		$response["nazwiskoError"] = validator::validateLastName($json["nazwisko"]);
		$response["telefonError"] = validator::validatePhone($json["telefon"]);
		$response["dataUrodzeniaError"] = validator::validateDateOfBirth($json["dataUrodzenia"]);
		$response["kodPocztowyError"] = validator::validatePostalCode($json["kodPocztowy"]);
		$response["miastoError"] = validator::validateCity($json["miasto"]);
		$response["adresError"] = validator::validateAddress($json["adresZamieszkania"]);
		$response["emailError"] = validator::validateEmail($json["adresEmail"]);
		$response["passError"] = validator::validatePassword($json["haslo"]);
		$response["rePassError"] = validator::validateRePassword($json["haslo"], $json["reHaslo"]);
		
		header('Content-type: application/json');
		
		foreach ($response as $key => $value) {
			if($value != "") {
				$response["errors"] = 1;
				echo json_encode($response);
				return;
			}
		}
		
		require_once("$root/app/utils/databaseConnection.php");
		require_once("$root/app/repository/accessData.php");
		$accessData = new AccessData();

		$user = $accessData->wyszukajUzytkownikaPoEmail($json["adresEmail"]);
				
		if($user != NULL) {
			$response["errors"] = 1;
			$response["emailError"] = "Taki adres email już istnieje w bazie danych.";
			echo json_encode($response);
			return;
		} else {
			$user = User::createUserWithCredentials(NULL, $json["adresEmail"], $json["telefon"], $json["haslo"], $json["imie"], $json["nazwisko"], $json["dataUrodzenia"], $json["miasto"], $json["kodPocztowy"], $json["adresZamieszkania"], 1);
			$accessData->zarejestrujUzytkownika($user);
			
			$error["errors"] = 0;
			echo json_encode($error);
		}
	}
?>
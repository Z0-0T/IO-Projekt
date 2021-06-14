<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/utils/functions.php");
	require_once("$root/app/utils/databaseConnection.php");
	require_once("$root/app/repository/accessData.php");
	require_once("$root/app/modele/role.php");
	$accessData = new AccessData();
	
	session_start();
	
	if(isset($_SESSION["user"])) {

		$roleName = $_SESSION["user"]->getRole()->getRoleName();

		if($roleName != "OS") {
			header('Location: /app/index.php');
		}
	} else {
		header('Location: /app/index.php');
	}
	
	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		
		if(isset($_GET["id"])) {
			
			$user = $accessData->pobierzUseraPoId($_GET["id"]);
			
			if($user == NULL) {
				die("Użytkownik o takim id nie istnieje w bazie danych.");
			} else {
				
				$role = $accessData->pobierzRole();
			
			?>

				
				<html lang="pl-PL">
					<head>
						<meta charset="UTF-8">
						<link rel="stylesheet" href="../style.css" type="text/css" />
					</head>
					<body>
						
						<?php navBar("os", $roleName); ?>
						
						<form action="#" id="forma">
							 <table class="creds">

							  <tr>
								<td colspan="2">
									<h3>Edycja danych użytkownika o id: <?php print($user->getUserId()) ?></h3>
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
									<input type="text" id="imie" name="imie" placeholder="Imie" value="<?php print($user->getFirstName()) ?>">
								</td>
								<td>
									<input type="text" id="nazwisko" name="nazwisko" placeholder="Nazwisko" value="<?php print($user->getLastName()) ?>">
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
									<input type="text" id="telefon" name="telefon" placeholder="Telefon (XXX-XXX-XXX)" value="<?php print($user->getPhone()) ?>">
								</td>
								<td>
									<input type="date" id="dataUrodzenia" name="dataUrodzenia" value="<?php print($user->getDateOfBirth()) ?>">
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
									<input type="text" id="kodPocztowy" name="kodPocztowy" placeholder="Kod pocztowy (XX-XXX)" value="<?php print($user->getPostalCode()) ?>">
								</td>
								<td>
									<input type="text" id="miasto" name="miasto" placeholder="Miasto" value="<?php print($user->getCity()) ?>">
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
									<input type="text" id="adres" name="adres" placeholder="Adres Zamieszkania" value="<?php print($user->getAddress()) ?>">
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
									<input type="text" id="email" name="email" placeholder="Email" value="<?php print($user->getEmail()) ?>">
								</td>
							  </tr>
							  <tr>
								<td colspan="2">
									<span class="error" id="emailErrorHandler"></span>
								</td>
							  </tr>
							  
							  <tr>
								<td colspan="2">
									<label for="email">Rola:</label>
								</td>
							  </tr>
							  <tr>
								<td colspan="2">
									<select name="role" id="role">
									<?php for($i = 0; $i < count($role); $i++) { ?>
										<option value="<?php print($role[$i]->getRoleId())?>" <?php if($role[$i]->getRoleId() == $user->getRole()) print("selected=\"selected\"")?>><?php print($role[$i]->roleShortcutToFull()) ?></option>
									<?php } ?>
									</select>
								</td>
							  </tr>
							  <tr>
								<td colspan="2">
									<span class="error" id="emailErrorHandler"></span>
								</td>
							  </tr>
							  
							  <tr>
								<td colspan="2">
									<button type="button" class="btn-green" id="send">Edytuj</button>
								</td>
							  </tr>

							  <tr>
								<td colspan="2">
									<button id="powrot" class="btn-blue">Powróć do listy użytkowników</button>
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
						}
							
						function createCredentials() {
							
							const queryString = window.location.search;
							const urlParams = new URLSearchParams(queryString);
							const idz = urlParams.get('id');
							let imie = document.querySelector("#imie").value;
							let nazwisko = document.querySelector("#nazwisko").value;
							let telefon = document.querySelector("#telefon").value;
							let dataUrodzenia = document.querySelector("#dataUrodzenia").value;
							let kodPocztowy = document.querySelector("#kodPocztowy").value;
							let miasto = document.querySelector("#miasto").value;
							let adresZamieszkania = document.querySelector("#adres").value;
							let adresEmail = document.querySelector("#email").value;
							let roleId = document.querySelector("#role").value;
							
							let obj = {'id': idz, 'imie': imie, 'nazwisko': nazwisko, 'telefon': telefon, 'dataUrodzenia': dataUrodzenia, 'kodPocztowy': kodPocztowy, 'miasto': miasto, 'adresZamieszkania': adresZamieszkania, 'adresEmail': adresEmail, 'roleId': roleId};
							
							return obj;
						}
						
						function sendData(data) {
							let req = new XMLHttpRequest();
							req.open('POST', 'edit.php', true); 
							req.setRequestHeader('Content-type','application/json');
						
							req.onreadystatechange = function () {
							  if (req.readyState == 4) {
								 if(req.status == 200) {
									console.log(req.responseText);
									let jsonRes = JSON.parse(req.responseText);
									if(jsonRes["errors"] == 1) {
										updateFormErrors(jsonRes);
									} else {
										console.log("Udalo sie zalozyc konto");
										document.querySelector("#emailErrorHandler").textContent = "";
										location.href = 'index.php';
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
			}
		}
	} elseif($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		require_once("$root/app/utils/validator.php");
		
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
		
		header('Content-type: application/json');
		
		foreach ($response as $key => $value) {
			if($value != "") {
				$response["errors"] = 1;
				echo json_encode($response);
				return;
			}
		}
		
		$user = $accessData->pobierzUseraPoId($json["id"]);

		if($user == NULL) {
			$response["errors"] = 1;
			$response["emailError"] = "Użytkownik o takim id nie istnieje.";
			echo json_encode($response);
			return;
		} else {

			$user = User::createUserWithCredentials($json["id"], $json["adresEmail"], $json["telefon"], NULL, $json["imie"], $json["nazwisko"], $json["dataUrodzenia"], $json["miasto"], $json["kodPocztowy"], $json["adresZamieszkania"], $json["roleId"]);
			$_SESSION["user"]->edytujPracownika($user);
			
			$error["errors"] = 0;
			echo json_encode($error);
		}
	}
?>
<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/modele/role.php");

	session_start();
	
	if(!isset($_SESSION["logged"])) {
		header('Location: /app/index.php');
	} else {
		if($_SESSION["logged"] != 1) {
			header('Location: /app/index.php');
		}
	}
	
	$user = $_SESSION["user"];
	$role = $user->getRole();
	$roleName = $role->getRoleName();
?>

<html lang="pl-PL">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>
		<?php navBar("profile", $roleName); ?>
		<h2>Profil</h2>
		<hr />
		<p><b>Imie: </b><?php print($user->getFirstName()); ?></p>
		<p><b>Nazwisko: </b><?php print($user->getLastName()); ?></p>
		<p><b>Telefon: </b><?php print($user->getPhone()); ?></p>
		<p><b>Adres email: </b><?php print($user->getEmail()); ?></p>
		<p><b>Data urodzenia: </b><?php print($user->getDateOfBirth()); ?></p>
		<p><b>Kod pocztowy: </b><?php print($user->getPostalCode()); ?></p>
		<p><b>Miasto: </b><?php print($user->getCity()); ?></p>
		<p><b>Adres zamieszkania: </b><?php print($user->getAddress()); ?></p>
		<p><b>Rola: </b><?php print($role->roleShortcutToFull()); ?></p>
		
		<form action="logout.php" method="POST">
		<button type="submit" class="btn-red">Wyloguj</button>
		</form>
		
	</body>
</html>
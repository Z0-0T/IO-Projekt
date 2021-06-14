<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/utils/functions.php");
	require_once("$root/app/repository/accessData.php");
	require_once("$root/app/modele/role.php");

	session_start();
	
	if(isset($_SESSION["user"])) {

		$roleName = $_SESSION["user"]->getRole()->getRoleName();

		if($roleName != "OS") {
			header('Location: /app/index.php');
		}
	} else {
		header('Location: /app/index.php');
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<?php navBar("os", $roleName); ?>
	
	<h2>OPERATOR SYSTEMU</h2>
	
	<h2>Witaj operatorze systemu :3</h2>
	<p>Tutaj panel do zarządzania użytkownikami</p>
	
	<table border="1">
		<tr>
			<th>Email</th>
			<th>Telefon</th>
			<th>Imie</th>
			<th>Nazwisko</th>
			<th>Data Urodzenia</th>
			<th>Miasto</th>
			<th>Kod Pocztowy</th>
			<th>Adress</th>
			<th>Rola</th>
			<th colspan="2">Operacje</th>
		</tr>
	<?php 
	
	$users = $_SESSION["user"]->wyswietlPracownikow();

	for($i = 0; $i < count($users); $i++) {
	?>
		<tr>
			<td><?php print($users[$i]->getEmail()) ?></td>
			<td><?php print($users[$i]->getPhone()) ?></td>
			<td><?php print($users[$i]->getFirstName()) ?></td>
			<td><?php print($users[$i]->getLastName()) ?></td>
			<td><?php print($users[$i]->getDateOfBirth()) ?></td>
			<td><?php print($users[$i]->getCity()) ?></td>
			<td><?php print($users[$i]->getPostalCode()) ?></td>
			<td><?php print($users[$i]->getAddress()) ?></td>
			<td><?php print($users[$i]->getRole()->roleShortcutToFull()) ?></td>
			<td><a href="edit.php?id=<?php print($users[$i]->getUserId()) ?>">Edytuj</td>
			<td><a href="delete.php?id=<?php print($users[$i]->getUserId()) ?>">Usuń</td>
		</tr>
	<?php
	}
	?>
		<tr>
			<td colspan="9"></td>
			<td colspan="2"><a href="add.php">Dodaj pracownika</a></td>
		</td>
	</table>
	
	
</html>
<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/modele/role.php");
	
	session_start();
	
	if(isset($_SESSION["user"])) {

		$roleName = $_SESSION["user"]->getRole()->getRoleName();

		if($roleName != "OZ") {
			header('Location: /app/index.php');
		}
	} else {
		header('Location: /app/index.php');
	}

	$klienci = $_SESSION["user"]->wyswietlZamowienia();

?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<?php navBar("oz", $roleName); ?>
	
	<h2>OPERATOR ZAMÓWIEŃ</h2>	
	<h2>Witaj operatorze zamówień :3</h2>
	
	<table border="1">
		<tr>
			<th>Data zamówienia</th>
			<th>Czy Opłacono</th>
			<th>Cena Zamówienia</th>
			<th>Imie</th>
			<th>Nazwisko</th>
			<th>Email</th>
			<th>Telefon</th>
		</tr>
	<?php 
	
	for($i = 0; $i < count($klienci); $i++) {
	?>
		<tr>
			<td><?php print($klienci[$i]->getZamowienie()->getDataZamowienia()) ?></td>
			<td><?php print($klienci[$i]->getZamowienie()->getCzyOplaconoString()) ?></td>
			<td><?php print($klienci[$i]->getZamowienie()->getCenaZamowienia()) ?></td>
			<td><?php print($klienci[$i]->getFirstName()) ?></td>
			<td><?php print($klienci[$i]->getLastName()) ?></td>
			<td><?php print($klienci[$i]->getEmail()) ?></td>
			<td><?php print($klienci[$i]->getPhone()) ?></td>
		</tr>
	<?php
	} 
	?>
	</table>


</html>
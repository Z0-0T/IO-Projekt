<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/repository/accessData.php");
	require_once("$root/app/modele/role.php");
	$accessData = new AccessData();
	
	session_start();
	
	if(isset($_SESSION["user"])) {
		
		$roleName = $_SESSION["user"]->getRole()->getRoleName();

		if($roleName != "PI") {
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
	<?php navBar("pi", $roleName); ?>
	
	<h2>PILOT</h2>	
	<h2>Witaj pilocie :3</h2>
	<h3>dziura w samolocie</h3>
	<p>Tutaj panel z przypisanymi do pilota lotami</p>
	
	<table border="1">
		<tr>
			<th>Skąd</th>
			<th>Dokąd</th>
			<th>Data Odlotu</th>
			<th>Data Przylotu</th>
			<th>Godzina odlotu</th>
			<th>Godzina przylotu</th>
			<th>Samolot</th>
		</tr>
	<?php 
	
	$loty = $_SESSION["user"]->wyswietlLoty();

	for($i = 0; $i < count($loty); $i++) {
	?>
		<tr>
			<td><?php print($loty[$i]->getMiastoWylotu()) ?></td>
			<td><?php print($loty[$i]->getMiastoPrzylotu()) ?></td>
			<td><?php print($loty[$i]->getDataWylotu()) ?></td>
			<td><?php print($loty[$i]->getDataPrzylotu()) ?></td>
			<td><?php print($loty[$i]->getGodzinaWylotu()) ?></td>
			<td><?php print($loty[$i]->getGodzinaPrzylotu()) ?></td>
			<td><?php print($loty[$i]->getSamolot()) ?></td>
		</tr>
	<?php
	} 
	?>
	</table>
	
</html>
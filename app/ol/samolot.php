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

		if($roleName != "OL") {
			header('Location: /app/index.php');
		}
	} else {
		header('Location: /app/index.php');
	}
	
	if($_SERVER['REQUEST_METHOD'] == 'GET') {

		$samoloty = $accessData->pobierzSamoloty();
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<?php navBar("ol", $roleName); ?>
	
	<h2>OPERATOR LOTÓW</h2>	
	<h2>Witaj operatorze lotów :3</h2>
	<p>Tutaj panel do zarządzania lotami</p>
	
	<a href="miasto.php">Dodaj miasto</a>
	<a href="index.php">Dodaj loty</a>
	
	<table border="1">
		<tr>
			<th>Id</th>
			<th>Nazwa Samolotu</th>
		</tr>
	<?php 
	
	for($i = 0; $i < count($samoloty); $i++) { ?>
	<tr>
		<td><?php print($samoloty[$i]->getSamolotId()) ?></td>
		<td><?php print($samoloty[$i]->getNazwaSamolotu()) ?></td>
	</tr>

	<?php } ?>
	
	</table>
	
	<br />
	
	<form method="POST" action="">
		<table>
			<tr>
				<td>Nazwa samolotu:</td>
				<td><input type="text" placeholder="Nazwa samolotu" name="samolot" /></td>
			</tr>
			<tr>
				<td>Ilość osób:</td>
				<td><input type="number" name="liczbaMiejsc" value="10"/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Dodaj samolot" /></td>
			</tr>
		</table>
	</form>
	
</html>

	<?php } elseif($_SERVER['REQUEST_METHOD'] == 'POST') { 
		
		if(isset($_POST["samolot"]) && isset($_POST["liczbaMiejsc"])) {
			if($_POST["samolot"] != "" && $_POST["liczbaMiejsc"] != "") {
				$samolot = new Samolot();
				$samolot->setNazwaSamolotu($_POST["samolot"]);
			
				$_SESSION["user"]->dodajSamolot($samolot, $_POST["liczbaMiejsc"]);

				header('Location: samolot.php');
			}
		}

	}
	?>
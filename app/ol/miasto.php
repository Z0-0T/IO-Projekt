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

		$miasta = $accessData->pobierzMiasta();
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
	
	<a href="samolot.php">Dodaj samolot</a>
	<a href="index.php">Dodaj loty</a>
	
	<table border="1">
		<tr>
			<th>Id</th>
			<th>Nazwa Miasta</th>
		</tr>
		<?php for($i = 0; $i < count($miasta); $i++) { ?>
		<tr>
			<td><?php print($miasta[$i]->getMiastoId()) ?></td>
			<td><?php print($miasta[$i]->getNazwaMiasta()) ?></td>
		</tr>
		<?php } ?>
	</table>
	
	<br />
	<form method="POST" action="">
		<table>
			<tr>
				<td>Nazwa miasta:</td>
				<td><input type="text" placeholder="Nazwa miasta" name="miasto" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Dodaj miasto" /></td>
			</tr>
		</table>
	</form>
	
</html>

	<?php } elseif($_SERVER['REQUEST_METHOD'] == 'POST') { 
		
		if(isset($_POST["miasto"])) {
			if($_POST["miasto"] != "") {
				
				$miasto = new Miasto();
				$miasto->setNazwaMiasta($_POST["miasto"]);
				$_SESSION["user"]->dodajMiasto($miasto);
				
				header('Location: miasto.php');
				
			}
		}
	}
	?>
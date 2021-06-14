<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/modele/role.php");

	session_start();
	
	if(isset($_SESSION["user"])) {

		$roleName = $_SESSION["user"]->getRole()->getRoleName();

		if($roleName != "OD") {
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
	<?php navBar("od", $roleName); ?>
	
	<h2>OPERATOR Danych</h2>	
	<h2>Witaj operatorze danych :3</h2>
	<p>Tutaj panel do zarządzania użytkownikami</p>
</html>
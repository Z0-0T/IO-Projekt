<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/repository/accessData.php");
	$accessData = new AccessData();

	session_start();
	
	if(isset($_SESSION["user"])) {
		if($_SESSION["user"]->getRole() != "KL") {
			header('Location: /app/index.php');
		}
	} else {
		header('Location: /app/index.php');
	}

	require_once("$root/app/utils/databaseConnection.php");
	
	$userId = $_SESSION["user"]->getUserId();
	
	$_SESSION["user"]->oplacZamowienie($userId, $_GET["id"]);
	
    header('Location: /app/zamowienia.php');
?>
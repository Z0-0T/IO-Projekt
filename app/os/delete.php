<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/utils/databaseConnection.php");
	require_once("$root/app/repository/accessData.php");
	$accessData = new AccessData();

	session_start();
	
	if(isset($_SESSION["user"])) {
		if($_SESSION["user"]->getRole() != "OS") {
			header('Location: /app/index.php');
		}
	} else {
		header('Location: /app/index.php');
	}
	
	if(isset($_GET["id"])) {
		
		$_SESSION["user"]->usunPracownika($_GET["id"]);

		header('Location: /app/os/index.php');
	}
?>
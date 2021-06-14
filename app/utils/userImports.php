<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/modele/pilot.php");
	require_once("$root/app/modele/klient.php");
	require_once("$root/app/modele/operatorDanych.php");
	require_once("$root/app/modele/operatorLotow.php");
	require_once("$root/app/modele/operatorSystemu.php");
	require_once("$root/app/modele/operatorZamowien.php");
?>

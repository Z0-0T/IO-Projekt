<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/app/utils/userImports.php");
require_once("$root/app/modele/role.php");

session_start();

if(isset($_SESSION["user"])) {

    $roleName = $_SESSION["user"]->getRole()->getRoleName();

    if($roleName != "KL") {
        header('Location: /app/index.php');
    }
} else {
    header('Location: /app/index.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $str_json = file_get_contents('php://input');
	$json = json_decode($str_json, true);
	
	require_once("$root/app/utils/databaseConnection.php");
    require_once("$root/app/repository/accessData.php");
	$accessData = new AccessData();

	$lotId = $json["lotId"];
	$response = $accessData->pobierzRezerwacjeMiejscPrzypisanychDoLotu($lotId);
	
	echo json_encode($response);
}
?>
<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/app/utils/userImports.php");
require_once("$root/app/modele/role.php");
require_once("$root/app/repository/accessData.php");

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

    $loty = $_SESSION["user"]-> wyswietlLotyLimit10($json["skad"], $json["dokad"], $json["data"]);

	echo json_encode($loty);
}
?>
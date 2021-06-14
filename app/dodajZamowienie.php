<?php

    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once("$root/app/utils/userImports.php");
    require_once("$root/app/modele/role.php");

    session_start();

    if(!isset($_SESSION["user"])) {
            header('Location: /app/index.php');
	} else {
		if($_SESSION["user"]->getRole()->getRoleName() != "KL") {
            header('Location: /app/index.php');
		}
	}

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //trzeba dodać walidację

        if(!isset($_POST["iloscOsob"]) && !isset($_POST["bagaze"]) && !isset($_POST["platnosc"]) && !isset($_POST["miejsca"]) && !isset($_POST["znizka"]) && !isset($_POST["lotId"])) {
            die("Nie wprowadzono wszystkich wymaganych danych.");
        }

        if(!is_numeric($_POST["iloscOsob"])) {
            die("Ilość osób musi być liczbą");
        }

        if($_POST["iloscOsob"] <= 0) {
            die("Ilość osób musi być większa niż zero.");
        }

        if(!is_numeric($_POST["bagaze"])) {
            die("Ilość bagaży musi być liczbą.");
        }

        if(!is_numeric($_POST["lotId"])) {
            die("Lot musi być identyfikatorem typu liczbowego.");
        }

        $miejsca = $_POST["miejsca"];
        $znizki = $_POST["znizka"];

        if(count($miejsca) != count(array_unique($miejsca))) {
            die("Wybrano więcej niż jeden raz to samo miejsce.");
        }

        if(count($miejsca) != count($znizki)) {
            die("Bledne dane.");
        }

        $userId = $_SESSION["user"]->getUserId();

        $_SESSION["user"]->zlozZamowienie($_POST["iloscOsob"], $_POST["bagaze"], $_POST["platnosc"], $_POST["znizka"], $_POST["miejsca"], $_POST["lotId"], $userId);

        header("location: /app/zamowienia.php");
    }
?>
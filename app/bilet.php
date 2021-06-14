<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
    require_once("$root/app/modele/role.php");
    require_once("$root/app/modele/bilet.php");
    require_once("$root/app/modele/zamowienie.php");
    require_once("$root/app/modele/lot.php");
    require_once("$root/app/modele/miasto.php");
    require_once("$root/app/modele/rezerwacja.php");
    require_once("$root/app/modele/samolot.php");
	
	session_start();
	
	if(isset($_SESSION["user"])) {
        $roleName = $_SESSION["user"]->getRole()->getRoleName();
		if($roleName != "KL") {
			header('Location: /app/index.php');
		}
	} else {
		header('Location: /app/index.php');
	}

    require_once("$root/app/utils/databaseConnection.php");
    require_once("$root/app/repository/accessData.php");

    $accessData = new AccessData();

	$userId = $_SESSION["user"]->getUserId();
    $zamowienieId = $_GET["id"];
	
    $zamowienie = $_SESSION["user"]->wyswietlBilet($userId, $zamowienieId);
	
    if($zamowienie == NULL) {
        die("Takie zamówienie nie istnieje.");
    }

	require_once("$root/app/phpqrcode/qrlib.php");
    
    $qrCodeContent = "Imię: " . $_SESSION["user"]->getFirstName() . "\n" .
                    "Nazwisko: " . $_SESSION["user"]->getLastName() . "\n" .
                    "Kod biletu: " . $zamowienie->getBilet()->getKodBiletu() . "\n" . 
                    "Skąd: " . $zamowienie->getBilet()->getLot()->getMiastoWylotu()->getNazwaMiasta() . "\n" .
                    "Dokąd: " . $zamowienie->getBilet()->getLot()->getMiastoPrzylotu()->getNazwaMiasta() . "\n" .
                    "Ilość osób: " . $zamowienie->getBIlet()->getIloscOsob() . "\n" .
                    "Bagaże: " . $zamowienie->getBilet()->getBagaze() . "\n" .
                    "Data wylotu: " . $zamowienie->getBilet()->getLot()->getDataWylotu() . "\n" .
                    "Data przylotu: " . $zamowienie->getBilet()->getLot()->getDataPrzylotu() . "\n" .
                    "Godzina wylotu: " . $zamowienie->getBilet()->getLot()->getGodzinaWylotu() . "\n" .
                    "Godzina przylotu: " . $zamowienie->getBilet()->getLot()->getGodzinaPrzylotu() . "\n" .
                    "Samolot: " . $zamowienie->getBilet()->getLot()->getSamolot()->getNazwaSamolotu() . "\n" . 
                    "Miejsce - zniżka:" . "\n";
    
    $rezerwacje = $zamowienie->getBilet()->getRezerwacja();
    for($i = 0; $i < count($rezerwacje); $i++) { 
        $qrCodeContent = $qrCodeContent . $rezerwacje[$i]->toString() . "\n";
    } 
    
    ob_start();
    QRcode::png($qrCodeContent);
    $qrCodePNG = ob_get_contents();
    ob_end_clean();

    header("Content-type: text/html");
    $qrCodeBase64 = base64_encode($qrCodePNG);
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	
    <body>
    <?php navBar("zamowienia", $roleName); ?>
	
	<h2>Bilet</h2>	
    <hr />
	<?php 

    if($zamowienie != NULL) {
	?>
        <div style="float: left;">
		<p><b>Skąd: </b><?php print($zamowienie->getBilet()->getLot()->getMiastoWylotu()->getNazwaMiasta()); ?></p>
		<p><b>Dokąd: </b><?php print($zamowienie->getBilet()->getLot()->getMiastoPrzylotu()->getNazwaMiasta()); ?></p>
		<p><b>Ilość osób: </b><?php print($zamowienie->getBIlet()->getIloscOsob()); ?></p>
		<p><b>Bagaże: </b><?php print($zamowienie->getBilet()->getBagaze()); ?></p>
		<p><b>Data wylotu: </b><?php print($zamowienie->getBilet()->getLot()->getDataWylotu()); ?></p>
		<p><b>Data przylotu: </b><?php print($zamowienie->getBilet()->getLot()->getDataPrzylotu()); ?></p>
		<p><b>Godzina wylotu: </b><?php print($zamowienie->getBilet()->getLot()->getGodzinaWylotu()); ?></p>
		<p><b>Godzina przylotu: </b><?php print($zamowienie->getBilet()->getLot()->getGodzinaPrzylotu()); ?></p>
		<p><b>Samolot: </b><?php print($zamowienie->getBilet()->getLot()->getSamolot()->getNazwaSamolotu());?></p>
		
        <p><b>Miejsce - zniżka:</b></p>
        <?php
        for($i = 0; $i < count($rezerwacje); $i++) { ?>
            <p><?php print($rezerwacje[$i]->toString()) ?></p>
        <?php } ?>
        </div>

        <div id="bilet" style="float: left;">
            <img src="data:image/png;base64,<?php print($qrCodeBase64); ?>" />
        </div>
        <div style="clear: both;"></div>
        <?php } ?>
    </body>
</html>
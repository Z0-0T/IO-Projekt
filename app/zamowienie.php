<?php 

	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
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
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	
    <body>
    <?php navBar("zamowienia", $roleName); ?>

	<h2>Zamówienie</h2>	
    <hr />
	<?php 

	require_once("$root/app/utils/databaseConnection.php");
	require_once("$root/app/repository/accessData.php");
	
	$accessData = new AccessData();

	$userId = $_SESSION["user"]->getUserId();
	$zamowienieId = $_GET["id"];

	$zamowienie = $_SESSION["user"]->wyswietlZamowienie($userId, $zamowienieId);

	if($zamowienie != NULL) {

	?>
		<p><b>Skąd: </b><?php print($zamowienie->getBilet()->getLot()->getMiastoWylotu()->getNazwaMiasta()) ?></p>
		<p><b>Dokąd: </b><?php print($zamowienie->getBilet()->getLot()->getMiastoPrzylotu()->getNazwaMiasta()) ?></p>
		<p><b>Ilość osób: </b><?php print($zamowienie->getBilet()->getIloscOsob()) ?></p>
		<p><b>Bagaże: </b><?php print($zamowienie->getBilet()->getBagaze()) ?></p>
		<p><b>Data wylotu: </b><?php print($zamowienie->getBilet()->getLot()->getDataWylotu()) ?></p>
		<p><b>Data przylotu: </b><?php print($zamowienie->getBilet()->getLot()->getDataPrzylotu()) ?></p>
		<p><b>Godzina wylotu: </b><?php print($zamowienie->getBilet()->getLot()->getGodzinaWylotu()) ?></p>
		<p><b>Godzina przylotu: </b><?php print($zamowienie->getBilet()->getLot()->getGodzinaPrzylotu()) ?></p>
		<p><b>Samolot: </b><?php print($zamowienie->getBilet()->getLot()->getSamolot()->getNazwaSamolotu()) ?></p>
		
        <p><b>Miejsce - zniżka: </b></p>
	
        <?php 
			$rezerwacje = $zamowienie->getBilet()->getRezerwacja();
			for($i = 0; $i < count($rezerwacje); $i++) { 
			?>
            <p><?php print($rezerwacje[$i]->toString()) ?></p>
        <?php } ?>

        <p><b>Cena zamówienia: </b><?php print($zamowienie->getCenaZamowienia() . "zł") ?></p>

		<form action="oplac.php" method="GET">
        <input type="hidden" name="id" value="<?php print($zamowienieId) ?>" />
		<button type="submit" class="btn-blue">Opłać</button>
		</form>	
        
        <?php } ?>
    
        </body>
</html>
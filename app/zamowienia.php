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
	
	$userId = $_SESSION["user"]->getUserId();
	$zamowienia = $_SESSION["user"]->wyswietlZamowienia($userId);
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
    <body>
	<?php navBar("zamowienia", $roleName); ?>
	
	<h2>Zamówienia</h2>	
    	
	<table border="1">
		<tr>
			<th>Data Zamowienia</th>
			<th>Czy opłacono</th>
			<th>Cena zamówienia</th>
			<th>Operacja</th>
		</tr>

	
	<?php for($i = 0; $i < count($zamowienia); $i++) { ?>
	<tr>
		<td><?php print($zamowienia[$i]->getDataZamowienia()) ?></td>
		<td><?php print($zamowienia[$i]->getCzyOplaconoString()) ?></td>
		<td><?php print($zamowienia[$i]->getCenaZamowienia() . "zł") ?></td>
		<?php if($zamowienia[$i]->getCzyOplacono() == 0) { ?>
		<td><a href="zamowienie.php?id=<?php print($zamowienia[$i]->getZamowienieId()) ?>">Wyświetl zamówienie</a></td>
		<?php } else { ?>
		<td><a href="bilet.php?id=<?php print($zamowienia[$i]->getZamowienieId()) ?>">Wyświetl bilet</a></td>
		<?php } ?>
	</tr>
	<?php } ?>

	
	</table>
    </body>
</html>
<?php 
	
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/repository/accessData.php");
	require_once("$root/app/modele/role.php");
	$accessData = new AccessData();

	session_start();
	
	if(isset($_SESSION["user"])) {

		$roleName = $_SESSION["user"]->getRole()->getRoleName();

		if($roleName != "OL") {
			header('Location: /app/index.php');
		}
	} else {
		header('Location: /app/index.php');
	}
	
	if($_SERVER['REQUEST_METHOD'] == 'GET') {

		$piloci = $accessData->pobierzSkrotPilotow();
		$miasta = $accessData->pobierzMiasta();
		$loty = $_SESSION["user"]->wyswietlLoty();
		$samoloty = $accessData->pobierzSamoloty();
	
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../style.css" type="text/css" />
	</head>
	<?php navBar("ol", $roleName); ?>
	
	<h2>OPERATOR LOTÓW</h2>	
	<h2>Witaj operatorze lotów :3</h2>
	<p>Tutaj panel do zarządzania lotami</p>
	
	<a href="miasto.php">Dodaj miasto</a>
	<a href="samolot.php">Dodaj samolot</a>
	
	<table border="1">
		<tr>
			<th>Skąd</th>
			<th>Dokąd</th>
			<th>Data Odlotu</th>
			<th>Data Przylotu</th>
			<th>Godzina odlotu</th>
			<th>Godzina przylotu</th>
			<th>Cena</th>
		</tr>

		<?php for($i = 0; $i < count($loty); $i++) { ?>
		<tr>
			<td><?php print($loty[$i]->getMiastoWylotu()->getNazwaMiasta()) ?></td>
			<td><?php print($loty[$i]->getMiastoPrzylotu()->getNazwaMiasta()) ?></td>
			<td><?php print($loty[$i]->getDataWylotu()) ?></td>
			<td><?php print($loty[$i]->getDataPrzylotu()) ?></td>
			<td><?php print($loty[$i]->getGodzinaWylotu()) ?></td>
			<td><?php print($loty[$i]->getGodzinaPrzylotu()) ?></td>
			<td><?php print($loty[$i]->getCena() . "zł") ?></td>
		</tr>
		<?php } ?>
	</table>
	
	
	<br />
	
	<form method="POST" action="">
		<table>
			<tr>
				<td>Skąd:</td>
				<td>
					<select name="skad">
					<?php for($i = 0; $i < count($miasta); $i++) {?>
						<option value="<?php print($miasta[$i]->getMiastoId())?>"><?php print($miasta[$i]->getNazwaMiasta())?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Dokąd:</td>
				<td>
					<select name="dokad">
					<?php for($i = 0; $i < count($miasta); $i++) {?>
						<option value="<?php print($miasta[$i]->getMiastoId())?>"><?php print($miasta[$i]->getNazwaMiasta())?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Godzina Wylotu:</td>
				<td><input type="time" name="godzinaWylotu" /></td>
			</tr>
			<tr>
				<td>Godzina Przylotu:</td>
				<td><input type="time" name="godzinaPrzylotu" /></td>
			</tr>
			
			<tr>
				<td>Data Odlotu:</td>
				<td><input type="date" name="dataOdlotu" /></td>
			</tr>
			
			<tr>
				<td>Data Przylotu:</td>
				<td><input type="date" name="dataPrzylotu" /></td>
			</tr>
			
			<tr>
				<td>Cena:</td>
				<td><input type="number" name="cena" min="0" /></td>
			</tr>
			
			<tr>
				<td>Samolot:</td>
				<td>
					<select name="samolot">
						<?php for($i = 0; $i < count($samoloty); $i++) { ?>
							<option value="<?php print($samoloty[$i]->getSamolotId()) ?>"><?php print($samoloty[$i]->getNazwaSamolotu())?></option>
						<?php } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td>Pilot:</td>
				<td>
					<select name="pilot">
					<?php for($i = 0; $i < count($piloci); $i++) { ?>
						<option value="<?php print($piloci[$i]->getUserId()) ?>"><?php print($piloci[$i]->getShortName())?></option>
					<?php } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td></td>
				<td><input type="submit" value="Dodaj lot" /></td>
			</tr>
		</table>
	</form>
	
</html>
<?php
	} elseif($_SERVER['REQUEST_METHOD'] == 'POST') { 
		
		if(isset($_POST["skad"]) && isset($_POST["dokad"]) && isset($_POST["godzinaWylotu"]) && isset($_POST["godzinaPrzylotu"]) &&
				isset($_POST["dataOdlotu"]) && isset($_POST["dataPrzylotu"]) && isset($_POST["cena"]) && isset($_POST["samolot"]) && isset($_POST["pilot"])) {
				
				if(!empty($_POST["skad"]) && !empty($_POST["dokad"]) && !empty($_POST["godzinaWylotu"]) && !empty($_POST["godzinaPrzylotu"]) &&
				!empty($_POST["dataOdlotu"]) && !empty($_POST["dataPrzylotu"]) && !empty($_POST["cena"]) && !empty($_POST["samolot"]) && !empty($_POST["pilot"])) {

					$lot = new Lot();
					$miastoWylotu = new Miasto();
					$miastoWylotu->setMiastoId($_POST["skad"]);
					$miastoPrzylotu = new Miasto();
					$miastoPrzylotu->setMiastoId($_POST["dokad"]);
					$lot->setMiastoWylotu($miastoWylotu);
					$lot->setMiastoPrzylotu($miastoPrzylotu);
					$lot->setDataWylotu($_POST["dataOdlotu"]);
					$lot->setDataPrzylotu($_POST["dataPrzylotu"]);
					$lot->setGodzinaWylotu($_POST["godzinaWylotu"]);
					$lot->setGodzinaPrzylotu($_POST["godzinaPrzylotu"]);
					$lot->setCena($_POST["cena"]);
					$pilot = new Pilot();
					$pilot->setUserId($_POST["pilot"]);
					$samolot = new Samolot();
					$samolot->setSamolotId($_POST["samolot"]);
					$lot->setPilot($pilot);
					$lot->setSamolot($samolot);
					
					$_SESSION["user"]->dodajLot($lot);

				header('Location: index.php');
			}
		}
		
	}
?>
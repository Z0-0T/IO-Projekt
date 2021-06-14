<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/app/utils/validator.php");
	require_once("$root/app/utils/userImports.php");
	require_once("$root/app/utils/functions.php");
	require_once("$root/app/repository/accessData.php");
	require_once("$root/app/parts/header.php");
	require_once("$root/app/modele/role.php");
	$accessData = new AccessData();

	session_start();
	if(!isset($_SESSION["user"])) {
		$roleName = "NO";
	} else {
		$roleName = $_SESSION["user"]->getRole()->getRoleName();
	}

	$miasta = $accessData->pobierzMiasta();
	$platnosci = $accessData->pobierzPlatnosci();

?>

<html lang="pl-PL">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>
	
		<?php
			navBar("home", $roleName);
		?>
	
		<h2>Home</h2>
		<hr/>
		<h3>Tutaj jeśli zalogowano na klienta będzie możliwość złożenia zamówienia.</h3>

		<?php
			if($roleName == "KL") {
				?>

				<label for="skad">Skąd: </label>
				<select name="skad" id="skad">
					<?php for($i = 0; $i < count($miasta); $i++) { ?>
						<option value="<?php print($miasta[$i]->getMiastoId())?>"><?php print($miasta[$i]->getNazwaMiasta())?></option>
					<?php } ?>
				</select>
				
				<label for="skad">Dokąd: </label>
				<select name="dokad" id="dokad">
					<?php for($i = 0; $i < count($miasta); $i++) {  ?>
						<option value="<?php print($miasta[$i]->getMiastoId())?>"><?php print($miasta[$i]->getNazwaMiasta())?></option>
					<?php } ?>
				</select>
				
				<label for="data">Data: </label>
				<input type="date" name="data" id="data" />

				<input type="submit" id="szukaj" value="Szukaj"/>
				
				<br /><br />

				<div id="listaLotow"></div>
				
				<br /><br />

				<div id="siedzenia" style="float: left;"></div>

				<div id="formularz" style="float: left; display: none;">
					<form action="dodajZamowienie.php" method="POST">
						<div id="hiddenValue"></div>
						<table class="order-table">
							<tr>
								<td>Ilość osób</td>
								<td></td>
							</tr>

							<tr>
								<td><input type="number" name="iloscOsob" id="iloscOsob" min="0" value="0" /></td>
								<td></td>
							</tr>

							<tr>
								<td>Bagaże</td>
								<td></td>
							</tr>

							<tr>
								<td><input type="number" name="bagaze" id="bagaze" min="0" value="0" /></td>
								<td></td>
							</tr>

							<tr>
								<td>Metoda płatności</td>
								<td></td>
							</tr>

							<tr>
								<td>
									<select name="platnosc">
										<?php for($i = 0; $i < count($platnosci); $i++) {  ?>
											<option value="<?php print($platnosci[$i]->getPlatnoscId())?>"><?php print($platnosci[$i]->getRodzajPlatnosci())?></option>
										<?php } ?>
									</select>
								</td>
								<td></td>
							</tr>

							<tr>
								<td>Miejsca</td>
								<td>Zniżki</td>
							</tr>

							<table class="order-table" id="tabelkaMiejsca">
				
							</table>

							<table class="order-table">
							<tr>
								<td></td>
								<td>Cena: <span id="cena"></span></td>
							</tr>

							<tr>
								<td></td>
								<td><input type="submit" value="Zatwierdź"/></td>
							</tr>

						</table>
					</form>
				</div>

				<div style="clear: both;"></div>

				<script>

					let cenaPodstawowa;
					let cenaZaOsoby = 0;
					let cenaZaBagaze = 0;
					let miejsca;
					let listaMiejsc;
					let znizkiWszystkie = [0];

					document.querySelector("#iloscOsob").addEventListener('change', () => {
						let iloscOsob = document.querySelector("#iloscOsob").value;
						cenaZaOsoby = iloscOsob*cenaPodstawowa;

						znizkiWszystkie = [0];

						let html =`
							<tr>
								<td>
									<select name="miejsca[]">
									</select>
								</td>
								<td>
									<select name="znizka[]">
										<option value="1">Brak</option>
										<option value="2">30%</option>
										<option value="3">50%</option>
										<option value="4">100%</option>
									</select>
								</td>
							</tr>
						`;

						let output = html.repeat(iloscOsob);
						document.querySelector("#tabelkaMiejsca").innerHTML = output;

						let znizkaElementy = document.querySelectorAll("select[name=\"znizka[]\"]");

						for(let i = 0; i < znizkaElementy.length; i++) {
							znizkaElementy[i].addEventListener('change', (e) => {
								let znizk = e.target.value;
								
								let cena;
								console.log(znizk);
								console.log(cenaPodstawowa);

								switch(znizk) {
									case "1":
										cena = 0;
										break;
									case "2":
										cena = cenaPodstawowa*0.3;
										break;
									case "3":
										cena = cenaPodstawowa*0.5;
										break;
									case "4":
										cena = cenaPodstawowa*1;
										break;
								}

								znizkiWszystkie[i] = cena;
								
								let cenaZnizek = znizkiWszystkie.reduce((a, b) => a + b);
								console.log(znizkiWszystkie);
								console.log(cenaZnizek);

								document.querySelector("#cena").textContent = cenaZaOsoby*1+cenaZaBagaze*1-cenaZnizek*1 + "zł";

							});
						}

						miejsca = document.querySelectorAll("select[name=\"miejsca[]\"]");
						for(let i = 0; i < miejsca.length; i++) {
							miejsca[i].innerHTML = listaMiejsc;
						}

						let cenaZnizek = znizkiWszystkie.reduce((a, b) => a + b);

						document.querySelector("#cena").textContent = cenaZaOsoby*1+cenaZaBagaze*1-cenaZnizek*1 + "zł";
					});

					document.querySelector("#bagaze").addEventListener('change', () => {
						let iloscBagazy = document.querySelector("#bagaze").value;
						cenaZaBagaze = iloscBagazy*20;

						let cenaZnizek = znizkiWszystkie.reduce((a, b) => a + b);

						document.querySelector("#cena").textContent = cenaZaOsoby*1+cenaZaBagaze*1-cenaZnizek*1 + "zł";
					});

					document.querySelector("#szukaj").addEventListener('click', () => {
						let obj = obiektWyszukiwania();
						console.log(obj);
						let objJson = JSON.stringify(obj);
						let loty = wyszukajLoty(objJson);
						console.log(loty);
					});

					

					function obiektWyszukiwania() {
						let skad = document.querySelector("#skad").value;
						let dokad = document.querySelector("#dokad").value;
						let data = document.querySelector("#data").value;
						
						let obj = {"skad": skad, "dokad": dokad, "data": data};
						return obj;
					}
					
					function wyszukajLoty(data) {
						fetch('szukajLotow.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
						},
						body: data,
						})
						.then(response => response.json())
						.then(data => {
							console.log(data);
							let htmlTable = wygenerujTabeleLotow(data);
							document.querySelector("#listaLotow").innerHTML = htmlTable;
							let wyboryLotow = document.querySelectorAll(".wyborLotu");
							
							wyboryLotow.forEach((item) => {
								item.addEventListener('click', (e) => {
									let lot = {"lotId": e.target.dataset.lot};
									
									let row = data.filter(function(item){
										return item.lotId == e.target.dataset.lot;         
									});

									cenaPodstawowa = row[0]["cena"];

									wybierzLot(lot);
								});
							});
						})
						.catch((error) => {
						console.error('Error:', error);
						});
					}

					function wybierzLot(lot) {	
						fetch('szukajRezerwacje.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
						},
						body: JSON.stringify(lot),
						})
						.then(response => response.json())
						.then(data => {
							console.log(data);
							let tabelaMiejsca = wygenerujTabeleMiejsc(data);
							document.querySelector("#siedzenia").innerHTML = tabelaMiejsca;
							document.querySelector("#formularz").style.display = "block";
							listaMiejsc = wygenerujListeMiejsc(data);
							

							document.querySelector("#tabelkaMiejsca").innerHTML = "";
							document.querySelector("#hiddenValue").innerHTML = `<input type="hidden" name="lotId" value="${lot["lotId"]}"/>`;
							znizkiWszystkie = [0];

							document.querySelector("#cena").textContent = 0 + "zł";

							miejsca = document.querySelectorAll("select[name=\"miejsca\"]");
							for(let i = 0; i < miejsca.length; i++) {
								miejsca[i].innerHTML = listaMiejsc;
							}

						})
						.catch((error) => {
						console.error('Error:', error);
						});
					}
					
					function zwrocNazweKlasyMiejsca(miejsce) {
						if(miejsce == 0) {
							return "miejsce-wolne";
						} else {
							return "miejsce-zajete";
						}
					}


					function wygenerujListeMiejsc(miejsca) {
						let html = "";
						for(let i = 0; i < miejsca.length; i++) {
							if(miejsca[i]["czyZajete"] == 0) {
								html += `<option value="${miejsca[i]["rezerwacjaId"]}">${miejsca[i]["kodMiejsca"]}</option>`
							}
						}
						return html;
					}

					function wygenerujTabeleMiejsc(miejsca) {
						let html = "<table id=\"tt\" border=\"1\">";

						let reszta = miejsca.length % 4;

						for(let i = 0; i < miejsca.length-reszta; i += 4) {

							let className1 = zwrocNazweKlasyMiejsca(miejsca[i]["czyZajete"]);
							let className2 = zwrocNazweKlasyMiejsca(miejsca[i+1]["czyZajete"]);
							let className3 = zwrocNazweKlasyMiejsca(miejsca[i+2]["czyZajete"]);
							let className4 = zwrocNazweKlasyMiejsca(miejsca[i+3]["czyZajete"]);

							html += "<tr>";
							html += `<td><div class="miejsce ${className1}">${miejsca[i]["kodMiejsca"]}</div></td>`;
							html += `<td><div class="miejsce ${className2}">${miejsca[i+1]["kodMiejsca"]}</div></td>`;
							html += `<td><div class="miejsce"></div></td>`;
							html += `<td><div class="miejsce ${className3}">${miejsca[i+2]["kodMiejsca"]}</div></td>`;
							html += `<td><div class="miejsce ${className4}">${miejsca[i+3]["kodMiejsca"]}</div></td>`;
							html += "</tr>";
						}
						
						let cont = miejsca.length-reszta;

						if(reszta == 1) {
							let className1 = zwrocNazweKlasyMiejsca(miejsca[cont]["czyZajete"]);

							html += "<tr>";
							html += `<td><div class="miejsce ${className1}">${miejsca[cont]["kodMiejsca"]}</div></td>`;
							html += `<td></td>`;
							html += `<td><div class="miejsce"></div></td>`;
							html += `<td></td>`;
							html += `<td></td>`;
							html += "</tr>";
						} else if(reszta == 2) {
							let className1 = zwrocNazweKlasyMiejsca(miejsca[cont]["czyZajete"]);
							let className2 = zwrocNazweKlasyMiejsca(miejsca[cont+1]["czyZajete"]);

							html += "<tr>";
							html += `<td><div class="miejsce ${className1}">${miejsca[cont]["kodMiejsca"]}</td>`;
							html += `<td><div class="miejsce ${className2}">${miejsca[cont+1]["kodMiejsca"]}</td>`;
							html += `<td><div class="miejsce"></div></td>`;
							html += `<td></td>`;
							html += `<td></td>`;
							html += "</tr>";
						} else if(reszta == 3) {
							let className1 = zwrocNazweKlasyMiejsca(miejsca[cont]["czyZajete"]);
							let className2 = zwrocNazweKlasyMiejsca(miejsca[cont+1]["czyZajete"]);
							let className3 = zwrocNazweKlasyMiejsca(miejsca[cont+2]["czyZajete"]);

							html += "<tr>";
							html += `<td><div class="miejsce ${className1}">${miejsca[cont]["kodMiejsca"]}</td>`;
							html += `<td><div class="miejsce ${className2}">${miejsca[cont+1]["kodMiejsca"]}</td>`;
							html += `<td><div class="miejsce"></div></td>`;
							html += `<td><div class="miejsce ${className3}">${miejsca[cont+2]["kodMiejsca"]}</td>`;
							html += `<td></td>`;
							html += "</tr>";
						}
						
						html += "</table>";
						return html;
					}


					function wygenerujTabeleLotow(loty) {
						let html = "<table id=\"loty\" border=\"1\">";

						html += `
						<tr>
							<th>Skąd</th>
							<th>Dokąd</th>
							<th>Data Wylotu</th>
							<th>Data Przylotu</th>
							<th>Godzina Wylotu</th>
							<th>Godzina Przylotu</th>
							<th>Cena</th>
							<th>Samolot</th>
							<th>Wybierz</th>
						</tr>
						`

						for(let i = 0; i < loty.length; i++) {
							html += "<tr>";
							html += `<td>${loty[i]["wylot"]}</td>`;
							html += `<td>${loty[i]["przylot"]}</td>`;
							html += `<td>${loty[i]["dataWylotu"]}</td>`;
							html += `<td>${loty[i]["dataPrzylotu"]}</td>`;
							html += `<td>${loty[i]["godzinaWylotu"]}</td>`;
							html += `<td>${loty[i]["godzinaPrzylotu"]}</td>`;
							html += `<td>${loty[i]["cena"]}zł</td>`;
							html += `<td>${loty[i]["nazwaSamolotu"]}</td>`;
							html += `<td><a href="#" class="wyborLotu" data-lot="${loty[i]["lotId"]}">Wybierz</a></td>`;
							html += "</tr>";
						}
						html += "</table>"
						return html;
					}
				</script>

			<?php
			} 
			?>
		</body>
</html>
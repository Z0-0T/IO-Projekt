<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/app/modele/lot.php");
require_once("$root/app/modele/miasto.php");
require_once("$root/app/modele/miejsce.php");
require_once("$root/app/modele/platnosc.php");
require_once("$root/app/modele/samolot.php");
require_once("$root/app/modele/role.php");
require_once("$root/app/modele/rezerwacja.php");
require_once("$root/app/modele/bilet.php");
require_once("$root/app/modele/klient.php");
require_once("$root/app/modele/zamowienie.php");
require_once("$root/app/utils/databaseConnection.php");
require_once("$root/app/utils/functions.php");

class AccessData {

    private $db; 
    private $conn;

    function __construct() {
        $this->db = new DatabaseConnection();
        $this->conn = $this->db->connect();
    }

    function __destruct() {
        $this->conn->close();
    }

    public function pobierzSkrotPilotow() {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE roleId=2");
        $stmt->execute();
        $result = $stmt->get_result();
    
        $piloci = array();
        while($data = $result->fetch_assoc()) {
            $pilot = Pilot::createUserWithCredentials($data["userId"], $data["email"], $data["phone"], $data["password"], $data["firstName"], $data["lastName"], $data["dateOfBirth"], $data["city"], $data["postalCode"], $data["address"], $data["roleId"]);
            array_push($piloci, $pilot);
        }
        $stmt->close();
        return $piloci;
    }
    
    public function pobierzLoty() {
        $stmt = $this->conn->prepare("SELECT dataWylotu, dataPrzylotu, godzinaWylotu, godzinaPrzylotu, cena, m1.nazwaMiasta AS wylot, m2.nazwaMiasta AS przylot FROM lot INNER JOIN miasto m1 ON lot.miastoWylotu = m1.miastoId INNER JOIN miasto m2 ON lot.miastoPrzylotu = m2.miastoId ORDER BY dataWylotu");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $loty = array();
        while($data = $result->fetch_assoc()) {
            $lot = new Lot();
            $miastoWylotu = new Miasto();
            $miastoWylotu->setNazwaMiasta($data["wylot"]);
            $miastoPrzylotu = new Miasto();
            $miastoPrzylotu->setNazwaMiasta($data["przylot"]);
            $lot->setMiastoWylotu($miastoWylotu);
            $lot->setMiastoPrzylotu($miastoPrzylotu);
            $lot->setDataWylotu($data["dataWylotu"]);
            $lot->setDataPrzylotu($data["dataPrzylotu"]);
            $lot->setGodzinaWylotu($data["godzinaWylotu"]);
            $lot->setGodzinaPrzylotu($data["godzinaPrzylotu"]);
            $lot->setCena($data["cena"]);
            array_push($loty, $lot);
        }
        $stmt->close();
        return $loty;
    }
    
    public function pobierzSamoloty() {
        $stmt = $this->conn->prepare("SELECT * FROM samolot ORDER BY samolotId");
        $stmt->execute();
        $result = $stmt->get_result();
    
        $samoloty = array();
        while($data = $result->fetch_assoc()) {
            $samolot = new Samolot();
            $samolot->setSamolotId($data["samolotId"]);
            $samolot->setNazwaSamolotu($data["nazwaSamolotu"]);
            array_push($samoloty, $samolot);
        }
        $stmt->close();
        return $samoloty;
    }
    
    public function pobierzMiasta() {
        $stmt = $this->conn->prepare("SELECT * FROM miasto ORDER BY miastoId");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $miasta = array();
        while($data = $result->fetch_assoc()) {
            $miasto = new Miasto();
            $miasto->setMiastoId($data["miastoId"]);
            $miasto->setNazwaMiasta($data["nazwaMiasta"]);
            array_push($miasta, $miasto);
        }
        $stmt->close();
        return $miasta;
    }
    
    public function dodajLotDoBazyDanych($lot) {
	    $stmt = $this->conn->prepare("INSERT INTO lot VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssssss", $lot->getDataWylotu(), $lot->getDataPrzylotu(), $lot->getGodzinaWylotu(), $lot->getGodzinaPrzylotu(), $lot->getCena(), $lot->getMiastoWylotu()->getMiastoId(), $lot->getMiastoPrzylotu()->getMiastoId(), $lot->getPilot()->getUserId(), $lot->getSamolot()->getSamolotId());
		$stmt->execute();			
		$lotId = $stmt->insert_id;
		$stmt->close();
	
		$stmt = $this->conn->prepare("INSERT INTO rezerwacja SELECT NULL, FALSE, miejsceId, ? FROM miejsce WHERE samolotId=?");
		$stmt->bind_param("ss", $lotId, $lot->getSamolot()->getSamolotId());
		$stmt->execute();		
		$stmt->close();
    }

    public function dodajMiastoDoBazyDanych($miasto) {
	    $stmt = $this->conn->prepare("INSERT INTO miasto VALUES (NULL, ?)");
		$stmt->bind_param("s", $miasto->getNazwaMiasta());
		$stmt->execute();
		$stmt->close();
    }

    public function dodajSamolotDoBazyDanychPlusSiedzenia($samolot, $liczbaMiejsc) {
		$stmt = $this->conn->prepare("INSERT INTO samolot VALUES (NULL, ?)");
		$stmt->bind_param("s", $samolot->getNazwaSamolotu());
		$stmt->execute();
		$samolotId = $stmt->insert_id;
		$stmt->close();
				
		for($i = 1; $i <= $liczbaMiejsc; $i++) {
			$nazwaMiejsca = "M-" . $i;
			$stmt = $this->conn->prepare("INSERT INTO miejsce VALUES (NULL, ?, ?)");
			$stmt->bind_param("ss", $nazwaMiejsca, $samolotId);
			$stmt->execute();
			$stmt->close();
    	}
    }

    public function pobierzPlatnosci() {
	    $stmt = $this->conn->prepare("SELECT * FROM platnosc ORDER BY platnoscId");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $platnosci = array();
        while($data = $result->fetch_assoc()) {
            $platnosc = new Platnosc();
            $platnosc->setPlatnoscId($data["platnoscId"]);
            $platnosc->setRodzajPlatnosci($data["rodzajPlatnosci"]);
            array_push($platnosci, $platnosc);
        }
        $stmt->close();
        return $platnosci;
    }

    public function pobierzRole() {
		$stmt = $this->conn->prepare("SELECT * FROM role");
		$stmt->execute();
		$result = $stmt->get_result();		

		$role = array();
		while($data = $result->fetch_assoc()) {
			$rola = new Role();
			$rola->setRoleId($data["roleId"]);
			$rola->setRoleName($data["roleName"]);
			array_push($role, $rola);
		}
		$stmt->close();
        return $role;
    }

    public function wyszukajUzytkownikaPoEmail($email) {
		$stmt = $this->conn->prepare("SELECT * FROM user WHERE email=?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		
        $data = $result->fetch_assoc();

        if($data == NULL) {
            return NULL;
        }

        $role = new Role();
        $role->setRoleId($data["roleId"]);
        $user = User::createUserWithCredentials($data["userId"], $data["email"], $data["phone"], $data["password"], $data["firstName"], $data["lastName"], $data["dateOfBirth"], $data["city"], $data["postalCode"], $data["address"], $role);
		$stmt->close();

        return $user;
    }

    public function zarejestrujUzytkownika($user) {
        $stmt = $this->conn->prepare("INSERT INTO user VALUES (NULL, ?, ?, MD5(?), ?, ?, ?, ?, ?, ?, ?)");

        $email = $user->getEmail();
        $phone = $user->getPhone();
        $password = $user->getPassword();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $dateOfBirth = $user->getDateOfBirth();
        $city = $user->getCity();
        $postalCode = $user->getPostalCode();
        $address = $user->getAddress();
        $role = $user->getRole();

		$stmt->bind_param("sssssssssi", $email, $phone, $password, $firstName, $lastName, $dateOfBirth, $city, $postalCode, $address, $role);
		$stmt->execute();
		$stmt->close();
    }

    public function usunUzytkownikaPoId($id) {
		$stmt = $this->conn->prepare("DELETE FROM user WHERE userId=?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->close();
    }

    public function pobierzUseraPoId($id) {
		$stmt = $this->conn->prepare("SELECT * FROM user WHERE userId=?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$result = $stmt->get_result();

		$data = $result->fetch_assoc(); 

        if($data == NULL) {
            return NULL;
        }

        $user = User::createUserWithCredentials($data["userId"], $data["email"], $data["phone"], $data["password"], $data["firstName"], $data["lastName"], $data["dateOfBirth"], $data["city"], $data["postalCode"], $data["address"], $data["roleId"]);

        return $user;
    }

    public function updateUser($user) {
        $userId = $user->getUserId();
        $email = $user->getEmail();
        $phone = $user->getPhone();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $dateOfBirth = $user->getDateOfBirth();
        $city = $user->getCity();
        $postalCode = $user->getPostalCode();
        $address = $user->getAddress();
        $role = $user->getRole();

        $stmt = $this->conn->prepare("UPDATE user SET email=?, phone=?, firstName=?, lastName=?, dateOfBirth=?, city=?, postalCode=?, address=?, roleId=? WHERE userId=?");
		$stmt->bind_param("ssssssssii", $email, $phone, $firstName, $lastName, $dateOfBirth, $city, $postalCode, $address, $role, $userId);
		$stmt->execute();
		$stmt->close();
    }

    public function pobierzWszystkichUzytkownikow() {
        $stmt = $this->conn->prepare("SELECT userId, email, phone, firstName, lastName, dateOfBirth, city, postalCode, address, role.roleId, role.roleName FROM user INNER JOIN role ON user.roleId = role.roleId");
        $stmt->execute();
        $result = $stmt->get_result();

        $users = array();
        while($data = $result->fetch_assoc()) {
            $role = new Role();
            $role->setRoleId($data["roleId"]);
            $role->setRoleName($data["roleName"]);
            $user = User::createUserWithCredentials($data["userId"], $data["email"], $data["phone"], NULL, $data["firstName"], $data["lastName"], $data["dateOfBirth"], $data["city"], $data["postalCode"], $data["address"], $role);
			array_push($users, $user);
		}
        $stmt->close();
        return $users;
    }

    public function pobierzLotyPilotaPoId($pilotId) {
        $stmt = $this->conn->prepare("SELECT dataWylotu, dataPrzylotu, godzinaWylotu, godzinaPrzylotu, cena, m1.nazwaMiasta AS wylot, m2.nazwaMiasta AS przylot, nazwaSamolotu FROM lot INNER JOIN miasto m1 ON lot.miastoWylotu = m1.miastoId INNER JOIN miasto m2 ON lot.miastoPrzylotu = m2.miastoId INNER JOIN samolot ON lot.samolotId = samolot.samolotId WHERE pilotId=?");
        $stmt->bind_param("s", $pilotId);
        $stmt->execute();
        $result = $stmt->get_result();

        $loty = array();

        while($data = $result->fetch_assoc()) {
            $lot = new Lot();
            $lot->setMiastoWylotu($data["wylot"]);
            $lot->setMiastoPrzylotu($data["przylot"]);
            $lot->setDataWylotu($data["dataWylotu"]);
            $lot->setDataPrzylotu($data["dataPrzylotu"]);
            $lot->setGodzinaWylotu($data["godzinaWylotu"]);
            $lot->setGodzinaPrzylotu($data["godzinaPrzylotu"]);
            $lot->setSamolot($data["nazwaSamolotu"]);
            array_push($loty, $lot);
        }

        $stmt->close();
        return $loty;
    }

    public function pobierzUzytkownikaEmailPassword($email, $pass) {
        $stmt = $this->conn->prepare("SELECT * FROM user INNER JOIN role ON user.roleId = role.roleId WHERE email=? AND password=MD5(?)");

        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc(); 

        if($data == NULL) {
            return NULL;
        }

        $role = new Role();
        $role->setRoleId($data["roleId"]);
        $role->setRoleName($data["roleName"]);
        $user = User::createUserWithCredentials($data["userId"], $data["email"], $data["phone"], NULL, $data["firstName"], $data["lastName"], $data["dateOfBirth"], $data["city"], $data["postalCode"], $data["address"], $role);
        $stmt->close();

        return $user;
    }

    public function oplacZamowienie($userId, $zamowienieId) {
        $stmt = $this->conn->prepare("UPDATE zamowienie SET czyOplacono=1 WHERE userId=? AND zamowienieId=?");
        $stmt->bind_param("ss", $userId, $zamowienieId);
        $stmt->execute();
        $stmt->close();
    }

    public function wyszukajLotyPoMiejscuDacieLimit10($skad, $dokad, $data) {
        $stmt = $this->conn->prepare("SELECT lotId, dataWylotu, dataPrzylotu, godzinaWylotu, godzinaPrzylotu, cena, m1.nazwaMiasta AS wylot, m2.nazwaMiasta AS przylot, nazwaSamolotu FROM lot INNER JOIN miasto m1 ON lot.miastoWylotu = m1.miastoId INNER JOIN miasto m2 ON lot.miastoPrzylotu = m2.miastoId INNER JOIN samolot ON lot.samolotId = samolot.samolotId WHERE miastoWylotu=? AND miastoPrzylotu=? AND dataWylotu >= ? ORDER BY dataWylotu LIMIT 10");

        $stmt->bind_param("sss", $skad, $dokad, $data);
        $stmt->execute();
        $result = $stmt->get_result();

        $response = array();
        while($data = $result->fetch_assoc()) {
            array_push($response, $data);
        } 

        $stmt->close();
        
        return $response;
    }

    public function pobierzRezerwacjeMiejscPrzypisanychDoLotu($lotId) {
        $stmt = $this->conn->prepare("SELECT * FROM rezerwacja INNER JOIN miejsce ON rezerwacja.miejsceId = miejsce.miejsceId WHERE lotId=?");

        $stmt->bind_param("s", $lotId);
        $stmt->execute();
        $result = $stmt->get_result();

        $response = array();

        while($data = $result->fetch_assoc()) {
            array_push($response, $data);
        } 

        $stmt->close();

        return $response;
    }
    
    public function pobierzZamowieniaUsera($userId) {
        $stmt = $this->conn->prepare("SELECT zamowienieId, dataZamowienia, cenaZamowienia, czyOplacono FROM zamowienie WHERE userId=? ORDER BY dataZamowienia");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $zamowienia = array();
        while($data = $result->fetch_assoc()) {
            $zamowienie = new Zamowienie();
            $zamowienie->setZamowienieId($data["zamowienieId"]);
            $zamowienie->setDataZamowienia($data["dataZamowienia"]);
            $zamowienie->setCenaZamowienia($data["cenaZamowienia"]);
            $zamowienie->setCzyOplacono($data["czyOplacono"]);
            array_push($zamowienia, $zamowienie);
        } 
        
        $stmt->close();
        return $zamowienia;
    }

    public function pobierzSzczegolyZamowienia($userId, $zamowienieId) {
        $stmt = $this->conn->prepare("SELECT cenaZamowienia, kodBiletu, iloscOsob, bagaze, dataWylotu, dataPrzylotu, godzinaWylotu, godzinaPrzylotu, nazwaSamolotu, m1.nazwaMiasta AS skad, m2.nazwaMiasta AS dokad FROM zamowienie INNER JOIN bilet ON zamowienie.biletId=bilet.biletId INNER JOIN lot ON bilet.lotId=lot.lotId INNER JOIN miasto m1 ON lot.miastoWylotu=m1.miastoId INNER JOIN miasto m2 ON lot.miastoPrzylotu=m2.miastoId INNER JOIN samolot ON lot.samolotId=samolot.samolotId WHERE userId=? AND zamowienieId=?");
        $stmt->bind_param("ss", $userId, $zamowienieId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if($data == NULL) {
            return NULL;
        }

        $zamowienie = new Zamowienie();
        $zamowienie->setCenaZamowienia($data["cenaZamowienia"]);
        $bilet = new Bilet();
        $bilet->setIloscOsob($data["iloscOsob"]);
        $bilet->setBagaze($data["bagaze"]);
        $bilet->setKodBiletu($data["kodBiletu"]);
        $lot = new Lot();
        $lot->setDataWylotu($data["dataWylotu"]);
        $lot->setDataPrzylotu($data["dataPrzylotu"]);
        $lot->setGodzinaWylotu($data["godzinaWylotu"]);
        $lot->setGodzinaPrzylotu($data["godzinaPrzylotu"]);
        $samolot = new Samolot();
        $samolot->setNazwaSamolotu($data["nazwaSamolotu"]);
        $miastoWylotu = new Miasto();
        $miastoWylotu->setNazwaMiasta($data["skad"]);
        $miastoPrzylotu = new Miasto();
        $miastoPrzylotu->setNazwaMiasta($data["dokad"]);
        $lot->setSamolot($samolot);
        $lot->setMiastoWylotu($miastoWylotu);
        $lot->setMiastoPrzylotu($miastoPrzylotu);
        $bilet->setLot($lot);
       
        $stmt->close();

        $stmt = $this->conn->prepare("SELECT kodMiejsca, procentZnizka FROM zamowienie INNER JOIN bilet ON zamowienie.biletId=bilet.biletId INNER JOIN szczegolyBiletu ON bilet.biletId=szczegolyBiletu.biletId INNER JOIN rezerwacja ON szczegolyBiletu.rezerwacjaId=rezerwacja.rezerwacjaId INNER JOIN miejsce ON rezerwacja.miejsceId=miejsce.miejsceId INNER JOIN znizka ON szczegolyBiletu.znizkaId=znizka.znizkaId WHERE userId=? AND zamowienieId=?");
        $stmt->bind_param("ss", $userId, $zamowienieId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $rezerwacje = array();
        while($data = $result->fetch_assoc()) {
            $rezerwacja = new Rezerwacja();
            $rezerwacja->setKodMiejsca($data["kodMiejsca"]);
            $rezerwacja->setZnizka($data["procentZnizka"]);
            array_push($rezerwacje, $rezerwacja);
        }

        $bilet->setRezerwacja($rezerwacje);
        $zamowienie->setBilet($bilet);

        $stmt->close();

        return $zamowienie;
    }

    public function zlozZamowienieZeSzczegolami($iloscOsob, $bagaze, $platnosc, $znizki, $miejsca, $lotId, $userId) {
        $kodBiletu = guidv4();

		$stmt = $this->conn->prepare("INSERT INTO bilet VALUES (NULL, ?, ?, ?, ?)");
		$stmt->bind_param("ssss", $iloscOsob, $bagaze, $kodBiletu, $lotId);
		$stmt->execute();

        $biletId = $stmt->insert_id;

        $stmt->close();
        
        for($i = 0; $i < count($miejsca); $i++) {
            $stmt = $this->conn->prepare("INSERT INTO szczegolyBiletu VALUES (NULL, ?, ?, ?)");
		    $stmt->bind_param("sss", $znizki[$i], $miejsca[$i], $biletId);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->conn->prepare("UPDATE rezerwacja SET czyZajete=1 WHERE rezerwacjaId=?");
		    $stmt->bind_param("s", $miejsca[$i]);
            $stmt->execute();
            $stmt->close();
        }

        $stmt = $this->conn->prepare("SELECT cena FROM lot WHERE lotId=?");
		$stmt->bind_param("s", $lotId);
		$stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $cenaLotu = floatval($data["cena"]);
        $stmt->close();

        $dataZamowienia = date("Y-m-d");
    
        $laczneZnizki = 0;

        for($i = 0; $i < count($znizki); $i++) {
            $laczneZnizki += znizkaCena($znizki[$i], $cenaLotu);
        }

        $cenaCalosc = intval($iloscOsob)*$cenaLotu+intval($bagaze)*20-$laczneZnizki;

        $stmt = $this->conn->prepare("INSERT INTO zamowienie VALUES (NULL, ?, ?, 0, ?, ?, ?)");
		$stmt->bind_param("sssss", $dataZamowienia, $cenaCalosc, $userId, $biletId, $platnosc);
		$stmt->execute();
        $stmt->close();
    }

    public function pobierzWszystkichKlientowZamowienia() {
        $stmt = $this->conn->prepare("SELECT dataZamowienia, czyOplacono, cenaZamowienia, firstName, lastName, email, phone FROM zamowienie INNER JOIN user ON zamowienie.userId = user.userId");
        $stmt->execute();
        $result = $stmt->get_result();

        $klienci = array();
        while($data = $result->fetch_assoc()) {
            $zamowienie = new Zamowienie();
            $zamowienie->setDataZamowienia($data["dataZamowienia"]);
            $zamowienie->setCzyOplacono($data["czyOplacono"]);
            $zamowienie->setCenaZamowienia($data["cenaZamowienia"]);
            $klient = Klient::createClientDetails($data["firstName"], $data["lastName"], $data["email"], $data["phone"]);
            $klient->setZamowienie($zamowienie);
            array_push($klienci, $klient);
        }

        return $klienci;
    }

}
?>
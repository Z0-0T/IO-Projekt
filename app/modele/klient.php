<?php
require_once('user.php');

class Klient extends User {

	private $zamowienie;

    public static function createUserWithCredentials($userId, $email, $phone, $password, $firstName, $lastName, $dateOfBirth, $city, $postalCode, $address, $role) {
        $instance = new Klient();
        $instance->setUserId($userId);
        $instance->setEmail($email);
		$instance->setPhone($phone);
        $instance->setPassword($password);
		$instance->setFirstName($firstName);
		$instance->setLastName($lastName);
		$instance->setDateOfBirth($dateOfBirth);
		$instance->setCity($city);
		$instance->setPostalCode($postalCode);
		$instance->setAddress($address);
		$instance->setRole($role);
        return $instance;
    }

	public static function createClientDetails($firstName, $lastName, $email, $phone) {
		$instance = new Klient();
		$instance->setFirstName($firstName);
		$instance->setLastName($lastName);
		$instance->setEmail($email);
		$instance->setPhone($phone);
        return $instance;
	}

	public function setZamowienie($zamowienie) {
		$this->zamowienie = $zamowienie;
	}

	public function getZamowienie() {
		return $this->zamowienie;
	}

	public function zlozZamowienie($iloscOsob, $bagaze, $platnosc, $znizka, $miejsca, $lotId, $userId) {
		$accessData = new AccessData();
		$accessData->zlozZamowienieZeSzczegolami($iloscOsob, $bagaze, $platnosc, $znizka, $miejsca, $lotId, $userId);
	}

	public function wyswietlZamowienia($userId) {
		$accessData = new AccessData();
		$zamowienia = $accessData->pobierzZamowieniaUsera($userId);
		return $zamowienia;
	}

	public function wyswietlZamowienie($userId, $zamowienieId) {
		$accessData = new AccessData();
		$zamowienie = $accessData->pobierzSzczegolyZamowienia($userId, $zamowienieId);
		return $zamowienie;
	}

	public function wyswietlLotyLimit10($skad, $dokad, $data) {
		$accessData = new AccessData();
		$loty = $accessData->wyszukajLotyPoMiejscuDacieLimit10($skad, $dokad, $data);
		return $loty;
	}

	public function oplacZamowienie($userId, $zamowienieId) {
		$accessData = new AccessData();
		$accessData->oplacZamowienie($userId, $zamowienieId);
	}

	public function wyswietlBilet($userId, $zamowienieId) {
		$accessData = new AccessData();
		$dane = $accessData->pobierzSzczegolyZamowienia($userId, $zamowienieId);
		return $dane;
	}
}

?>
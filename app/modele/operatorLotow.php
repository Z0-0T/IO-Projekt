<?php
require_once('user.php');

class OperatorLotow extends User {
	
    public static function createUserWithCredentials($userId, $email, $phone, $password, $firstName, $lastName, $dateOfBirth, $city, $postalCode, $address, $role) {
        $instance = new OperatorLotow();
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

	public function dodajMiasto($miasto) {
		$accessData = new AccessData();
		$accessData->dodajMiastoDoBazyDanych($miasto);
	}

	public function dodajSamolot($samolot, $liczbaMiejsc) {
		$accessData = new AccessData();
		$accessData->dodajSamolotDoBazyDanychPlusSiedzenia($samolot, $liczbaMiejsc);
	}

	public function wyswietlLoty() {	
		$accessData = new AccessData();
		$loty = $accessData->pobierzLoty();
		return $loty;
	}

	public function dodajLot($lot) {
		$accessData = new AccessData();
		$accessData->dodajLotDoBazyDanych($lot);
	}
}

?>
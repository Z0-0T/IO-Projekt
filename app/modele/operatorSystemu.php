<?php
require_once('user.php');

class OperatorSystemu extends User {

	public static function createUserWithCredentials($userId, $email, $phone, $password, $firstName, $lastName, $dateOfBirth, $city, $postalCode, $address, $role) {
        $instance = new OperatorSystemu();
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

	public function dodajPracownika($user) {
		$accessData = new AccessData();
		$accessData->zarejestrujUzytkownika($user);
	}

	public function usunPracownika($id) {
		$accessData = new AccessData();
		$accessData->usunUzytkownikaPoId($id);
	}

	public function edytujPracownika($user) {
		$accessData = new AccessData();
		$accessData->updateUser($user);
	}

	public function wyswietlPracownikow() {
		$accessData = new AccessData();
		$pracownicy = $accessData->pobierzWszystkichUzytkownikow();
		return $pracownicy;
	}

}

?>
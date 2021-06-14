<?php
require_once('user.php');

class OperatorZamowien extends User {

	public static function createUserWithCredentials($userId, $email, $phone, $password, $firstName, $lastName, $dateOfBirth, $city, $postalCode, $address, $role) {
        $instance = new OperatorZamowien();
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

	public function wyswietlZamowienia() {
		$accessData = new AccessData();
		$klienciZamowienia = $accessData->pobierzWszystkichKlientowZamowienia();
		return $klienciZamowienia;
	}

}

?>
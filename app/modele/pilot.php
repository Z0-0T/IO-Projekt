<?php
require_once('user.php');

class Pilot extends User {

    public static function createUserWithCredentials($userId, $email, $phone, $password, $firstName, $lastName, $dateOfBirth, $city, $postalCode, $address, $role) {
        $instance = new Pilot();
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

	public function wyswietlLoty() {
		$accessData = new AccessData();
		$loty = $accessData->pobierzLotyPilotaPoId($this->getUserId());
		return $loty;
	}
    
}

?>
<?php 

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/app/repository/accessData.php");

Class User {
    private $userId;
    private $email;
    private $phone;
    private $password;
	private $firstName;
	private $lastName;
	private $dateOfBirth;
	private $city;
	private $postalCode;
	private $address;
	private $role;

    public function __construct() {

    }
	
    public static function createUserWithCredentials($userId, $email, $phone, $password, $firstName, $lastName, $dateOfBirth, $city, $postalCode, $address, $role) {
        $instance = new User();
        $instance->userId = $userId;
        $instance->email = $email;
		$instance->phone = $phone;
        $instance->password = $password;
		$instance->firstName = $firstName;
		$instance->lastName = $lastName;
		$instance->dateOfBirth = $dateOfBirth;
		$instance->city = $city;
		$instance->postalCode = $postalCode;
		$instance->address = $address;
		$instance->role = $role;
        return $instance;
    }

    public function getUserId() {
        return $this->userId;
    }
	
	public function getEmail() {
        return $this->email;
    }
	
	public function getPhone() {
        return $this->phone;
    }
	
	public function getFirstName() {
        return $this->firstName;
    }
	
	public function getLastName() {
        return $this->lastName;
    }
	
	public function getDateOfBirth() {
        return $this->dateOfBirth;
    }
	
	public function getCity() {
        return $this->city;
    }
	
	public function getPostalCode() {
        return $this->postalCode;
    }
	
	public function getAddress() {
        return $this->address;
    }
	
	public function getRole() {
        return $this->role;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }
	
	public function setEmail($email) {
        $this->email = $email;
    }
	
	public function setPhone($phone) {
        $this->phone = $phone;
    }
	
	public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
	
	public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
	
	public function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }
	
	public function setCity($city) {
        $this->city = $city;
    }
	
	public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }
	
	public function setAddress($address) {
        $this->address = $address;
    }
	
	public function setRole($role) {
        $this->role = $role;
    }

    public function getShortName() {
        return $this->firstName . " " . $this->lastName . " (" . $this->email . ")";
    }
}

?>

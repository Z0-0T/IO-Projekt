<?php

class validator {
	
	public static function validateEmail($email) {
		if(strlen($email) > 60) {
			return "Adres e-mail może posiadać maksymalnie 60 znaków.";
		}
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return "Adres e-mail nieprawidłowy.";
		}
		
		return "";
	}
	
	public static function validatePassword($password) {
		
		if($password == "") {
			return "Hasło nie może być puste.";
		}
		
		if(strlen($password) < 8) {
			return "Hasło musi mieć 8 lub więcej znaków.";
		}
		
		if(strlen($password) > 32) {
			return "Hasło musi mieć 32 lub mniej znaków.";
		}
		
		$upper = false;
		for ($i = 0; $i < strlen($password); $i++) {
			if(ctype_upper($password[$i])) {
				$upper = true;
				break;
			};
		}
		
		if(!$upper) {
			return "Hasło musi posiadać wielką literę.";
		}
		
		$digit = false;
		for ($i = 0; $i < strlen($password); $i++) {
			if(ctype_digit($password[$i])) {
				$digit = true;
				break;
			};
		}
		
		if(!$digit) {
			return "Hasło musi zawierać przynajmniej jedną cyfrę.";
		}
		
		if(strpos($password, " ") != false) {
			return "Hasło nie może zawierać znaków białych.";
		}
		
		$specialChar = preg_match('/\W/', $password);
		
		if(!$specialChar) {
			return "Hasło musi zawierać przynajmniej jeden znak specjalny.";
		}
		
		return "";		
	}
	
	public static function validateFirstName($firstName) {
		if($firstName == "") {
			return "Proszę wprowadzić imię.";
		}
		
		if(strlen($firstName) < 2) {
			return "Hasło musi posiadać przynajmniej 2 znaki.";
		}
		
		if(strlen($firstName) > 40) {
			return "Hasło może składać sie maksymalnie z 40 znaków.";
		}
		
		if(strpos($firstName, " ") != false) {
			return "Imie nie może zawierać znaków białych.";
		}
		
		return "";
	}
	
	public static function validateLastName($lastName) {
		if($lastName == "") {
			return "Proszę wprowadzić nazwisko.";
		}
		
		if(strlen($lastName) < 2) {
			return "Nazwisko musi posiadać co najmniej 2 znaki.";
		}
		
		if(strlen($lastName) > 40) {
			return "Nazwisko może składać sie maksymalnie z 40 znaków.";
		}
		
		if(strpos($lastName, " ") != false) {
			return "Nazwisko nie może zawierać znaków białych.";
		}
		
		return "";
	}
	
	public static function validateDateOfBirth($dateOfBirth) {
		
		$data = preg_match('/^\d\d\d\d-\d\d-\d\d$/', $dateOfBirth);
		if(!$data) {
			return "Wprowadzono datę w błędnym formacie.";
		}
		
		if($dateOfBirth > date("Y-m-d")) {
			return "Data urodzenia nie może być z przyszłości.";
		}
		
		return "";
	}
	
	public static function validateAddress($address) {
		if($address == "") {
			return "Proszę wprowadzić adres zamieszkania.";
		}
		
		if(strlen($address) < 6) {
			return "Adres zamieszkania musi posiadać co najmniej 6 znaków.";
		}
		
		if(strlen($address) > 40) {
			return "Adres zamieszkania może składać się maksymalnie z 40 znaków.";
		}
		
		return "";
	}
	
	public static function validatePostalCode($postalCode) {
		
		$valid = preg_match('/^\d\d-\d\d\d$/', $postalCode);
		
		if(!$valid) {
			return "Wprowadzony kod pocztowy nie jest prawidłowy.";
		}
		return "";
	}
	
	public static function validateCity($city) {
		
		if($city == "") {
			return "Proszę wprowadzić nazwę miasta.";
		}
		
		if(strlen($city) < 2) {
			return "Nazwa miasta musi posiadać co najmniej 2 znaki.";
		}
		
		if(strlen($city) > 40) {
			return "Nazwa miasta może składać sie maksymalnie z 40 znaków.";
		}
		
		return "";
	}
	
	public static function validateRePassword($pass1, $pass2) {
		
		if($pass1 != $pass2) {
			return "Hasła nie są identyczne.";
		}
		
		return "";
		
	}
	
	//Nie będzie wykorzystane w implementacji projektu
	public static function validateFile($fileName) {
		return "";
	}
	
	public static function validatePhone($phone) {
		
		$valid = preg_match('/^\d\d\d-\d\d\d-\d\d\d$/', $phone);
		
		if(!$valid) {
			return "Wprowadzony numer telefonu jest nieprawidłowy.";
		}
		
		return "";
	}
	
}

?>
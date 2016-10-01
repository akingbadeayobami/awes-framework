<?php
class Hash{

	public static function make($string, $salt = ''){

		return hash('sha256', $string . $salt);

	}

	public static function password($password){

		return password_hash($password, PASSWORD_DEFAULT);

	}

	public static function checkPassword($rawPassword, $hashedpassword){

		return password_verify($rawPassword, $hashedpassword);

	}

	public static function salt($length){

		return mcrypt_create_iv($length);

	}

	public static function unique(){

		return self::make(uniqid());

	}

}
?>

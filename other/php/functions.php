<?php
include_once("password.php");

function check_user() {
	global $pdo;

	if(isset($_SESSION['userid'])) {
    $statement = $pdo->prepare("SELECT * FROM userdata WHERE id = :id");
    $result = $statement->execute(array('id' => $_SESSION['userid']));
    $user = $statement->fetch();
    return $user;
	}
}

function is_checked_in() {
	return isset($_SESSION['userid']);
}

function is_administrator() {
	global $pdo;
	$statement = $pdo->prepare("SELECT * FROM userdata WHERE id = :id");
	$result = $statement->execute(array('id' => $_SESSION['userid']));
	$user = $statement->fetch();

	switch (strtolower($user['berechtigung'])) {
		case 'administrator':
			return true;
			break;

		default:
			return false;
			break;
	}
}


function random_string() {
	if(function_exists('openssl_random_pseudo_bytes')) {
		$bytes = openssl_random_pseudo_bytes(16);
		$str = bin2hex($bytes);
	} else if(function_exists('mcrypt_create_iv')) {
		$bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
		$str = bin2hex($bytes);
	} else {
		//Replace your_secret_string with a string of your choice (>12 characters)
		$str = md5(uniqid('your_secret_string', true));
	}
	return $str;
}
?>

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

function is_chargen() {
	global $pdo;
	$statement = $pdo->prepare("SELECT * FROM userdata WHERE id = :id");
	$result = $statement->execute(array('id' => $_SESSION['userid']));
	$user = $statement->fetch();

	switch (strtolower($user['berechtigung'])) {
		case 'administrator':
			return true;
			break;

		case 'chargen':
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

function is_dienstgrad($dienstgrad) {
	switch ($dienstgrad) {
		case "Probefeuerwehrmann":
		return true;
		break;
		case "Feuerwehrmann":
		return true;
		break;
		case "Oberfeuerwehrmann":
		return true;
		break;
		case "Hauptfeuerwehrmann":
		return true;
		break;
		case "Löschmeister":
		return true;
		break;
		case "Oberlöschmeister":
		return true;
		break;
		case "Hauptlöschmeister":
		return true;
		break;
		case "Brandmeister":
		return true;
		break;
		case "Oberbrandmeister":
		return true;
		break;
		case "Hauptbrandmeister":
		return true;
		break;
	  case "Brandinspektor":
		return true;
		break;
		case "Oberbrandinspektor":
		return true;
		break;
		case "Hauptbrandinspektor":
		return true;
		break;
		case "Abschnittsbrandinspektor":
		return true;
		break;
		case "Brandrat":
		return true;
		break;
		case "Oberbrandrat":
		return true;
		break;
		case "Landesfeuerwehrrat":
		return true;
		break;
		case "Verwaltungsmeister":
		return true;
		break;
		case "Oberverwaltungsmeister":
		return true;
		break;
		case "Hauptverwaltungsmeister":
		return true;
		break;
		case "Verwalter":
		return true;
		break;
		case "Oberverwalter":
		return true;
		break;
		case "Hauptverwalter":
		return true;
		break;
		case "Verwaltungsinspektor":
		return true;
		break;
		case "Verwaltungsrat":
		return true;
		break;
		case "Sachbearbeiter":
		return true;
		break;
		case "Abschnittssachbearbeiter":
		return true;
		break;
		case "Bezirkssachbearbeiter":
		return true;
		break;

		default:
		return false;
		break;
	}
}
?>

<?php
//rejestracja okej
define('REG_OK',0);
//puste pola
define('EMPTY_FIELDS',2);
//nieprawidłowa ilosc znaków
define('BAD_LEN_OF_PASS',1);
//nie prawidłowe znaki
define('WRONG_CHARACTERS',3);
//bład połączenia z bazą danych
define('CONNECT_ERROR_TO_DATABASE',4);
//bład zapytania
define('QUERY_ERROR',5);
//użytkownik już istnieje
define('USER_ALREADY_EXISTS',6);
define('NO_PROPER_QUERY_RESULTS',7);

$h = "mysql.cba.pl";
$u = "bartoszszmit";
$p = "muzykapowazna";
$db = "bartoszszmit_cba_pl";

function rejestruj($nazwa,$pass,$imie,$nazwisko,$email)
{
	global $h,$u,$p,$db;
	
	
	if ($imie == "" || $nazwisko == "" || $email == "")
	{
		return EMPTY_FIELDS;
	}
	$pass_len = strlen(utf8_decode($pass));
	if ($pass_len<6 || $pass_len>40)
	{
		return BAD_LEN_OF_PASS;
	}
	if (!preg_match("/^[a-zA-Z0-9_.]{3,20}$/",$nazwa))
	{
		return WRONG_CHARACTERS;
	}
	$db_connection = new mysqli($h,$u,$p,$db);
	//jeśli bład połączenia
	if ($db_connection->connect_errno)
	{
		return CONNECT_ERROR_TO_DATABASE;
	}
	//zabezpieczenie znaków specjalnych przed zapytaniem
	$nazwa = $db_connection->real_escape_string($nazwa);
	//$pass = $db_connection->real_escape_string($pass);
	$imie = $db_connection->real_escape_string($imie);
	$nazwisko = $db_connection->real_escape_string($nazwisko);
	$email = $db_connection->real_escape_string($email);
	$query = "select count(*) from 256_Users where Nazwa='$nazwa'";
	//jesli jest błąd w zapytaniu
	if (!$result = $db_connection->query($query))
	{
		$db_connection->close();
		return QUERY_ERROR;
	}
	if (!$row = $result->fetch_row())
	{
		return NO_PROPER_QUERY_RESULTS;
	}
	else 
	{
		if ($row[0]>0)
		{
			$db_connection->close();
			return USER_ALREADY_EXISTS;
		}
	}
	//kryptowanie hasla
	$pass=crypt($pass);
	$query = "insert into 256_Users values(NULL,'$nazwa','$pass','$imie','$nazwisko','$email')";
	if (!$result = $db_connection->query($query))
	{
		$db_connection->close();
		return QUERY_ERROR;
	}
	$count = $db_connection->affected_rows;
	if ($count<>1)
	{
		return NO_PROPER_QUERY_RESULTS;
	}
	else
	{
		return OK;
	}
}
session_start();
if (isset($_SESSION['zalogowany']))
{
	header('Location:jesien.php');
}
else if (!isset($_POST['nazwa']) || !isset($_POST['haslo']) || !isset($_POST['imie']) 
|| !isset($_POST['nazwisko']) || !isset($_POST['email']))
{
	$_SESSION['k'] = "Wypełnij wszystkie pola";
	include('nuf.php');
}
else
{
	$val = rejestruj($_POST['nazwa'],$_POST['haslo'],$_POST['imie'],$_POST['nazwisko'],$_POST['email']);
	if ($val == REG_OK)
	{
		$_SESSION['k'] = "Rejestracja się udała. Zaloguj się";
		include('login.php');
	}
	else if ($val == EMPTY_FIELDS)
	{
		$_SESSION['k'] = "Wypełnij wszystkie pola";
		include('nuf.php');
	}
	else if ($val == BAD_LEN_OF_PASS)
	{
		$_SESSION['k'] = "Hasło musi być > 6 i < 40";
		include('nuf.php');
	}
	else if ($val == WRONG_CHARACKTERS)
	{
		$_SESSION['k']="Nie dozwolone znaki w nazwie użytkownika";
		include('nuf.php');
	}
	else if ($val == USER_ALREADY_EXISTS)
	{
		$_SESSION['k']="Taki użytkownik już istnieje";
		include('nuf.php');
	}
	else if ($val == QUERY_ERROR)
	{
		$_SESSION['k']="Błąd w zapytaniu sql";
		include('nuf.php');
	}
	else 
	{
		$_SESSION['k']="Inny problem";
		include('nuf.php');
	}
}
?>
<?php
define('LOGIN_OK',0);
define('CONNECT_ERROR',1);
define('QUERY_ERROR',2);
define('PASS_OR_USER_WRONG_LEN',3);
define('NO_SUCH_USER',4);
define('PASS_DOES_NOT_FIT',5);
define('EMPTY_FIELDS',6);
define('OTHER_THING',7);
//ustalenie zmiennych bazy danych
$h = "mysql.cba.pl";
$u = "bartoszszmit";
$p = "muzykapowazna";
$db = "bartoszszmit_cba_pl";

function testLogin($user,$pass)
{
	global $h,$u,$p,$db;
	
	$user_len = strlen(utf8_decode($user));
	$pass_len = strlen(utf8_decode($pass));
	if ($user == "" || $pass == "")
	{
		return EMPTY_FIELDS;
	}
	if ($user_len<6 || $user_len>20 || $pass_len<3 || $pass_len>40)
	{
		return PASS_OR_USER_WRONG_LEN; 
	}
		
	$db_connect = new mysqli($h,$u,$p,$db);
	if ($db_connet->mysqli_errno)
	{
		$db_connect->close();
		return CONNECT_ERROR;
	}
	$user = $db_connect->real_escape_string($user);
	$pass = $db_connect->real_escape_string($pass);
	
	$query = "select Haslo from 256_Users where Nazwa = '$user'";
	if(!$result = $db_connect->query($query))
	{
		$db_connect->close();
		return QUERY_ERROR;
	}
	if ($result->num_rows<>1)
	{
		return NO_SUCH_USER;
	}
	else
	{
		$row = $result->fetch_row();
		$pass_db = $row[0];
		if (crypt($pass,$pass_db) != $pass_db)
		{
			return PASS_DOES_NOT_FIT;
		}
		else
		{
			return LOGIN_OK;
		}
	}
}
session_start();
if (isset($_SESSION['zalogowany']))
{
	header('Location:jesien.php');
}
else if(!isset($_POST['user']) || !isset($_POST['haslo']))
{
	if (!isset($_SESSION['k']))
	$_SESSION['k'] = "Wprowadź login i haslo";
	include('index.php');
}
else
{
	$val = testLogin($_POST['user'],$_POST['haslo']);
	if ($val == LOGIN_OK)
	{
		$_SESSION['zalogowany'] = $_POST['user'];
		header('Location:jesien.php');
	}
	else if ($val == CONNECT_ERROR)
	{
		if (!isset($_SESSION['k']))
		{
			$_SESSION['k']="Błąd połączenia";
			include('index.php');
		}
	}
	else if ($val == QUERY_ERROR)
	{
		$_SESSION['k']="Błąd w zapytaniu";
		include('index.php');
	}
	else if ($val == EMPTY_FIELDS)
	{
		$_SESSION['k']="Nie wprowadzono danych";
		include('index.php');
	}
	else if ($val == NO_SUCH_USER)
	{
		$_SESSION['k']="Nie ma takiego użytkownika";
		include('index.php');
	}
	else if ($val == PASS_DOES_NOT_FIT)
	{
		$_SESSION['k']="Złe hasło";
		include('index.php');
	}
	else if ($val == PASS_OR_USER_WRONG_LEN)
	{
		$_SESSION['k']="Zła długość znaków";
		include('index.php');
	}
	else
	{
		$_SESSION['k']="Inny błąd";
		include('index.php');
	}
}
?>
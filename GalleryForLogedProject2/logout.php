<?php
session_start();
if (!isset($_SESSION['zalogowany']))
{
	$k = "Nie jesteœ zalogowany";
}
else
{
	unset($_SESSION['zalogowany']);
	$k = "Wylogowanie prawid³owe";
}
session_destroy();
include('login.php');
?>
<?php
session_start();
if (!isset($_SESSION['zalogowany']))
{
	$k = "Nie jeste� zalogowany";
}
else
{
	unset($_SESSION['zalogowany']);
	$k = "Wylogowanie prawid�owe";
}
session_destroy();
include('login.php');
?>
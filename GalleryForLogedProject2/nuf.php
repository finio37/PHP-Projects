<?php
session_start();
if (isset($_SESSION['zalogowany']))
{
	header('Location:jesien.php');
}
if (isset($_SESSION['k']))
{
	
	$k = $_SESSION['k'];
}
else
{
	$k = "Zapraszamy do rejestracji";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Jesienna galeria</title>
<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="js/jquery-blink.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('small span#uwaga').blink();
});
</script>
</head>
<body>
	<div id="str1_glowny">
	<h2>Wspomnienia z dawnych spacerów - galeria jesieni</h2>
		<div id="lewy">
			<div id="lewy_gora">
			<p class="small"><small><span id="uwaga">Uwaga!!</span> Nie stosuj znaków z shiftem</small></p>
			</div>
			<div id="lewy_dol">
				<p>Witam serdecznie;-)<br>
				Galeria jesieni dostępna jest tylko dla użytkowników zalogowanych</p>
				<p class="komunikat"><?php echo $k; ?></p>
			</div>
		</div>
		<div id="prawy">
			<div id="nuf">
				<form action="rejestracja.php" method="post">
				<h2>Panel rejestracyjny</h2>
				<table>
				 <tr>
					<td>Nazwa użytkownika</td><td><input type="text" name="nazwa"></td>
				 </tr>
				 <tr>
					<td>Twoje hasło</td><td><input type="password" name="haslo"></td>
				 </tr>
				 <tr>
					<td>Powtórz hasło</td><td><input type="password" name="haslo2"></td>
				 </tr>
				 <tr>
					<td>Twoje imie</td><td><input type="text" name="imie"></td>
				 </tr>
				 <tr>
					<td>Twoje nazwisko</td><td><input type="text" name="nazwisko"></td>
				 </tr>
				 <tr>
					<td>E - mail</td><td><input type="text" name="email"></td>
				 </tr>
				 <tr>
					<td><a href="jesien.php">Strona główna</a></td><td><input type="submit" value="Rejestruj"></td>
				 </tr>
				</table>
				</form>
			</div>
			<div id="menu">
				<ul>
					<li class="menu">MENU: <a href="http://galeria.bartoszszmit.cba.pl/jesien.php">GALERIA</a></li>
				</ul>
			</div>
		
		</div>
		<div class="clear"></div>
	</div>
</body>
</html>
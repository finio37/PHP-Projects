<?php
session_start();
if (!isset($_SESSION['zalogowany']))
{
	$_SESSION['k'] = "Nie jesteś zalogowany";
	header('Location:login.php');
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Jesienna galeria</title>
<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
<!--[if lte IE 9]>
    <script src="js/jquery-1.3.2.min.js"></script>
<![endif]-->
<script type="text/javascript">
$(document).ready(function(){
	var $current_slider = $(this);
	var $full_gallery = $('.duze',$current_slider);
	$('#gallery a',this).click(function(evt){
		evt.preventDefault();
		var imgPath = $(this).attr('href');
	var oldImg = $('#gallery img.duze');
	var newImg = $('<img class="duze" src="' + imgPath + '"/>');
	newImg.hide();
	$('#gallery').prepend(newImg);
		newImg.fadeIn(2000);
		oldImg.fadeOut(2000,function(){$(this).remove();
		});
		
		//oldImg.fadeOut(2000).fadeIn(6000,function(){$(this).remove;});
		
	});
	var $lista = $('.min',$current_slider);
	var $zawartosc_listy = $lista.children('li');
	var odleglosc = $zawartosc_listy.eq(0).outerWidth() + parseInt($zawartosc_listy.eq(0).css('margin-top')) + parseInt($zawartosc_listy.eq(0).css('margin-bottom'));
	var max_odleglosc = odleglosc * $zawartosc_listy.length - 5*odleglosc;
	$('.trojkat_gora',$current_slider).click(function(){
		if ($lista.position().top > -max_odleglosc)
			{
			$($lista).not(':animated').animate({'top':'-='+odleglosc},500);
			}
		});
	$('.trojkat_dol',$current_slider).click(function(){
		if ($lista.position().top < 0)
			{
			$($lista).not(':animated').animate({'top':'+='+odleglosc},500);
			}
	});
	
	$('#miniaturki_kol1 ul.min li').hover(function(){ $(this).addClass('hovered');}, function(){$(this).removeClass('hovered');});
	$('#gallery a:first').click();
});
</script>

</head>
<body>
	<div id="str1_glowny">
	<h2>Wspomnienia z dawnych spacerów - galeria jesieni</h2>
		<div id="lewy">
			<div id="lewy_gora">
			<p class="small"><small>Uwaga!! Nie stosuj znaków z shiftem</small></p>
			</div>
			<div id="lewy_dol">
				<p>Witam serdecznie;-)<br>
				Galeria jesieni dostępna jest tylko dla użytkowników zalogowanych</p>
				
			</div>
			<div id="witaj">
			<p>Witaj <?php echo $_SESSION['zalogowany']; ?></p>
			<p><a href="logout.php" style="color:white;">Wyloguj się</a></p>
			</div>
		</div>
		
		<div id="prawy">
			<div id="gallery">
				<div id="miniaturki_kol1">
					
					<ul class="strzalka_gora">
						<li><img class="trojkat_gora" src="przyciski/do_gory.png" alt="przycisk"></li>
					</ul>
					<div id="wraper">
						<ul class="min">
						<li><a href="images/jesien_1b.png"><img class="link_img" src="przyciski/J1.png" alt="przycisk"></a></li>
						<li><a href="images/jesien_2.png"><img class="link_img" src="przyciski/J2.png" alt="przycisk"></a></li>
						<li><a href="images/jesien_3.png"><img class="link_img" src="przyciski/J3.png" alt="przycisk"></a></li>
						<li><a href="images/jesien_4.png"><img class="link_img" src="przyciski/J4.png" alt="przycisk"></a></li>
						<li><a href="images/jesien_5.png"><img class="link_img" src="przyciski/J5.png" alt="przycisk"></a></li>
						<li><a href="images/jesien_6.png"><img class="link_img" src="przyciski/J6.png" alt="przycisk"></a></li>
						</ul>
					</div>
					<ul class="strzalka_dol">
						<li><img class="trojkat_dol" src="przyciski/do_dolu.png" alt="przycisk"></li>
					</ul>
				</div>
				
			</div>
		</div>
		<div class="clear"></div>
	</div>
</body>
</html>
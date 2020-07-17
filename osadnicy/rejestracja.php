<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		// udana walidacja? 
		$wszystko_ok = true;
		
		// sprawdzamy nickname
		$nick = $_POST['nick']; 
	
		// sprawdzenie dlugosci nicka
		if ((strlen($nick)<3) || (strlen($nick)>30))
		{
			$wszystko_ok = false;
			$_SESSION['e_nick']='Nick musi posiadać od trzech do 30 znaków';		
			
		}
		
		if ($wszystko_ok ==true)
		{
			// Hura, wszystkie testy zaliczone, dodajemy gracza do bazy		
			echo 'Udana walidacja!'; 
			exit();
		}
		
		
	}
	
?>


<!DOCTYPE HTML>
<html lang = "pl">
<head>
	<meta charset = "utf_8"/>
	<meta http-equiv = "X-UA-Compatibile" content = "IE=edge, chrome = 1"/>
	<title>Osadnicy -załóż darmowe konto!</title>
	<script src = "https://www.google.com/recaptcha/api.js"></script>
	
	<style>
	.error
	{
		color: red;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	</style>
	
</head>

<body>
	<form method = "post">
	
		Nickname: <br/> <input type = "text" name = "nick"/><br/>
		
		<?php
		
			if (isset($_SESSION['e_nick']))
			{
				
				echo '<div class = "error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
				
			}
		
		?>
		
		E - mail: <br/> <input type = "text" name = "email"/><br/>
		Twoje hasło: <br/> <input type = "password" name = "haslo1"/><br/>
		Powtórz hasło: <br/> <input type = "password" name = "haslo2"/><br/>
		<label>
		<input type = "checkbox" name = "regulamin"/>Akceptuje regulamin<br/>
		</label>
		<div class = "g-recaptcha" data-sitekey="6LeWgrIZAAAAAJZ4XmWBeW4RpTSRFddiDQVwhKCM"></div>
		<br/>
		<input type = "submit" value = "Zarejestruj się"/>

	</form>



</body>
</html>
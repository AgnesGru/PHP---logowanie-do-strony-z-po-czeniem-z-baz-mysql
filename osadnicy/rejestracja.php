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
		
		if(ctype_alnum($nick)==false)
		{
			$wszystko_ok = false;
			$_SESSION['e_nick']='Nick może składać się tylko z liter (ang alfabet) i cyfr';
		}
		
		// sprawdz poprawność e-mail		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB!=$email))
		{
			$wszystko_ok = false;
			$_SESSION['e_email'] = 'Podaj poprawny adres email';
			
		}
			
		// Sprawdz poprawnoć hasła
		
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		# najpierw pobralismy hasło z formularza
		
		// sptawdzmy dlugosci hasło
		
		if ((strlen($haslo1) <8) || (strlen($haslo1)>20))
		{
			$wszystko_ok = false;
			$_SESSION['e_haslo'] = 'Hasło  musi mieć od 8 do 20 znaków';			
			
		}
		
		if ($haslo1 != $haslo2)
		{
			$wszystko_ok = false;
			$_SESSION['e_haslo'] = 'Hasła nie są identyczne';				
		}	
		
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		# to wyświetla nam shaszowane hasla
		# echo $haslo_hash; exit();		
		
		// cz regulamin został zaakceptowany?
		
		if (!isset($_POST['regulamin']))
		{
			$wszystko_ok = false;
			$_SESSION['e_regulamin'] = 'Zaakceptuj regulamin';				
		}
		
		// Sprawdz CAPTcha
		$sekret = '6LeWgrIZAAAAAFZDUbGBJJyk6OMcOfUwfFmmaIQt';
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_ok = false;
			$_SESSION['e_boot'] = 'Napewno nie jesteś robotem?';				
		}
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errno());
				# błąd połączenia, rzuć wyjątkiem
			}
			else
			{
				// czy email istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if ($ile_takich_maili>0)
				{
					$wszystko_ok = false;
					$_SESSION['e_email'] = 'Istnieje już konto przypisane do tego adresu emai!';				
				}	
				
			
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style = "color:red;">Błąd serwera</span>';
			// echo '<br/>Informacja developerska:'.$e;
			# zakomentowany kod jak w wersji produkcyjnej, żeby nie wyświetlać błędów 
		}
		
		if ($wszystko_ok == true)
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
		
		<?php
		
			if (isset($_SESSION['e_email']))
			{
				
				echo '<div class = "error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
				
			}
		
		?>
		
		Twoje hasło: <br/> <input type = "password" name = "haslo1"/><br/>
		
		<?php
		
			if (isset($_SESSION['e_haslo']))
			{
				
				echo '<div class = "error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
				
			}
		
		?>
		Powtórz hasło: <br/> <input type = "password" name = "haslo2"/><br/>
		
		<label>
		<input type = "checkbox" name = "regulamin"/>Akceptuje regulamin<br/>
		</label>
		<?php
		
			if (isset($_SESSION['e_regulamin']))
			{
				
				echo '<div class = "error">'.$_SESSION['e_regulamin'].'</div>';
				unset($_SESSION['e_regulamin']);
				
			}
		
		?>
		<div class = "g-recaptcha" data-sitekey="6LeWgrIZAAAAAJZ4XmWBeW4RpTSRFddiDQVwhKCM"></div>
		
		<?php
		
			if (isset($_SESSION['e_boot']))
			{
				
				echo '<div class = "error">'.$_SESSION['e_boot'].'</div>';
				unset($_SESSION['e_boot']);
				
			}
		
		?>
		<br/>
		<input type = "submit" value = "Zarejestruj się"/>

	</form>



</body>
</html>
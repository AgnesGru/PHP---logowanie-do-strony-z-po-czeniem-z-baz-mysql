<?php

	session_start();
	
	if (!isset($_SESSION['udanarejestracja']))
		// jeśli nie będzie ustawiona zmienna udana rejestracja to przekierowanie na strone index.php
	{
		header('Location: index.php');
		exit();		
	}
	else
	{
		unset($_SESSION['udanarejestracja']);		
	}
	
	// usuwamy zmienne pamiętające wpisanie do formularza
	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']));
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']));
	if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']));
	if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']));
	if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']));
	
	// Usuwanie zmiennych z błędami czyli e_
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']));
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']));
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']));
	if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']));
	if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']));
	
?>

<!DOCTYPE HTML>
<html lang = "pl">
<head>
	<meta charset = "utf_8"/>
	<meta http-equiv = "X-UA-Compatibile" content = "IE=edge, chrome = 1"/>
	<title>Osadnicy -gra przeglądarkowa</title>
	
</head>

<body>
	Dziękuję za rejestrację. Możesz już się zalogować. Życzę udanej zabawy
	<br/><br/>		
	
	<a href = "index.php">Zaloguj się na swoje konto!</a>	
	<br/><br/>
	
	<form action = "zaloguj.php" method = "post" >
	
		Login: <br/> <input type = "text" name = "login"/><br/>
		Hasło: <br/> <input type = "password" name = "haslo"/><br/><br/>
		<input type = "submit" value = "Zaloguj sie"/>
	
	</form>
	
<?php

	if(isset($_SESSION['blad'])) 	echo $_SESSION['blad'];
	
?>
</body>
</html>
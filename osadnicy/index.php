<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany'] == true))
	{
		header('Location: gra.php');
		exit();
		
	}

?>


<!DOCTYPE HTML>
<html lang = "pl">
<head>
	<meta charset = "utf_8"/>
	<meta http-equiv = "X-UA-Compatibile" content = "IE=edge, chrome = 1"/>
	<title>Osadnicy -gra przeglądarkowa</title>
	
</head>

<body>
	Dziękuję Mirosław Zelent za super kursy!!!
	<br/>
	<br/>
		
	<a href = "rejestracja.php">Rejestracja - załóż darmowe konto!</a>
	
	<br/>
	<br/>
	
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
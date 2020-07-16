<?php
	
	session_start(); 
	# jeśli chcemy korzystac z SESSION
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	# ten if zapobiega ręcznemu dostaniu się do strony gry  bez logowania
?>

<!DOCTYPE HTML>
<html lang = "pl">
<head>
	<meta charset = "utf_8"/>
	<meta http-equiv = "X-UA-Compatibile" content = "IE=edge, chrome = 1"/>
	<title>Osadnicy -gra przeglądarkowa</title>
	
</head>

<body>

<?php
	
	echo "<p>Witaj ".$_SESSION['user'].'! [<a href = "logout.php">Wyloguj się!</a>]</p>' ;
	# wyciąganie danych 
	echo"<p><b>Drewno</b>:".$_SESSION['drewno'];
	echo"|<b>Kamień</b>:".$_SESSION['kamien'];
	echo"|<b>Zboże</b>:".$_SESSION['zboze']."</p>";
	
	echo"<p><b>E-mail</b>:".$_SESSION['email'];
	echo"<br/><b>Dni Premium</b>:".$_SESSION['dnipremium']."</p>";


?>

</body>
</html>
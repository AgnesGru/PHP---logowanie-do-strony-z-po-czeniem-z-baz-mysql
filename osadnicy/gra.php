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
	echo"<br/><b>Data wygaśnięcia Premium</b>:".$_SESSION['dnipremium']."</p>";
	
	$dataczas = new DateTime('2020-01-06 22:30:15');
	// tworzecie obiektu
	
	echo "Data i czas serwera: ".$dataczas->format('Y-m-d H:i:s')."<br>";
	
	$koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);
	
	$roznica = $dataczas->diff($koniec);
	
	if ($dataczas<$koniec)
	echo 'Pozostało promium: '.$roznica->format('%y lat, %m mies, %d dni, %h godz, %i min, %s dek');
	else
	echo 'Premium nie aktywne od: '.$roznica->format('%y lat, %m mies, %d dni, %h godz, %i min, %s dek');
	
	
?>

</body>
</html>
<?php
	
	session_start(); 
	# jeśli chcemy korzystac z SESSION
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
		
		{
			header('Location: index.php');
			exit();
		}
		# w tym ifie nie pozwalamy aby dostać się do strony zaloguj.php bez wpisanie danych no na przykład wpisując w pasek
		
	require_once  "connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	# @ przed znakiem new ukrywa nam info np w której linii nastąpił błąd
	if ($polaczenie->connect_errno != 0)
	{
		echo "Error: ".$polaczenie->connect_errno ."Opis:". $polaczenie->connect_error;	
		# opis można usunąć bo to np pokazuje że nasz login to 'root'
	}	
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		
		# zapytnie które sprawdza czy uzytkownik istnieje
		# całe zapytanie w " " a zmienne w ' ' inaczej niż w echo
		
		# wysyłamy zapytanie do bazy danych i zabezpieczenie przed wstrzykiwaniem sql
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
		mysqli_real_escape_string($polaczenie, $login),
		mysqli_real_escape_string($polaczenie, $haslo))))
		{
			$ilu_userow = $rezultat->num_rows;
			if ($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				
				if (password_verify($haslo, $wiersz['pass']))
				{
					
					$_SESSION['zalogowany'] = true;
					
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['user'];		
					$_SESSION['drewno'] = $wiersz['drewno'];		
					$_SESSION['kamien'] = $wiersz['kamien'];		
					$_SESSION['zboze'] = $wiersz['zboze'];		
					$_SESSION['email'] = $wiersz['email'];		
					$_SESSION['dnipremium'] = $wiersz['dnipremium'];		

					unset($_SESSION['blad']);
					$rezultat->free_result();				
					header('Location: gra.php');	
					# przekierowanie z uzyciem naglowka HTTP
				}
				else 
				{				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
				}
				
			} else {
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
			}
		}
		
		$polaczenie->close();	
	}

	
?>
<?php
	
	session_start(); 
	# jeśli chcemy korzystac z SESSION
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
		
		{
			header('Location: index.php');
			exit();
		}
		# w tym ifie nie pozwalamy aby dostać się do strony zaloguj.php bez wpisanie danych no na przykład wpisując w pasek odrazu gra.php
		
	require_once  "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT); 
	// sprawdzamy czy dane do zalogowania sie zgadzają
	try
	{
		$polaczenie = new mysqli($host, $db_user, 'aga', $db_name);
	
		if ($polaczenie->connect_errno != 0)
		{
			throw new Exception(mysqli_connect_errno());
		}	
		else
		{
			// weź zmienne login i haslo z formularza
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
					
			//zapytnie które sprawdza czy uzytkownik istnieje (całe zapytanie w " " a zmienne w ' ' inaczej niż w echo)
			
			//wysyłamy zapytanie do bazy danych i zabezp. przed wstrzykiwaniem sql
			if ($rezultat = $polaczenie->query(
			sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
			mysqli_real_escape_string($polaczenie,$login))))
			{
				$ilu_userow = $rezultat->num_rows;
				if ($ilu_userow>0)
				{
					$wiersz = $rezultat->fetch_assoc();
					
					if (password_verify($haslo, $wiersz['pass']))
					{
						
						$_SESSION['zalogowany'] = true;
						# zmienne przechowujące dane w bazie
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
						# dobry login i złe hasło
						$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
						header('Location: index.php');
					}
					
				# nie znaleziono loginu
				} else {
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
				
			}
			
			else
			{
				throw new Exception($polaczenie->error);
			}
			
			$polaczenie->close();	
		}
	}
	catch(Exception $e)
	{
		echo '<div class = "error">Błąd serwera. Przepraszamy</div>';
		//echo '<br/>Informacja developerska:'.$e;
		
	}
	
?>
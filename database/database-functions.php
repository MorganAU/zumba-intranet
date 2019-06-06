<?php
	function loopTest($sText)
	{
		$answer = '';
		do {
			echo $sText . ' : ' . PHP_EOL;
			$answer = trim(fgets(STDIN));

			if ($answer === '') {
				echo 'Vous n\'avez rien saisie (CTRL+C pour quitter)' . PHP_EOL;
			}
		} while ($answer === '');

		return $answer;
	
	}



	function databaseConnect($sHost, $sLogin, $sPassword)
	{
		// Creation d'un DSN (Data Source Name)
		$dsn = 'mysql:host=' . $sHost . ';dbname=;port=3306;charset=utf8';
				
		try {
			// Instanciation d'un objet PDO
			$pdo = new PDO($dsn, $sLogin, $sPassword);
		}
				
		// Gestion des erreurs
		catch (PDOException $exception) {
			echo 'Erreur : ' . $exception->getMessage() . PHP_EOL;
			echo 'N° : ' . $exception->getCode() . PHP_EOL;
			die('Erreur de connexion à la base de données') . PHP_EOL;
		}
		
		return $pdo;
	
	}

<?php

	// Pour se connecter à la base de données
	function databaseConnect() 
	{
		include_once 'config.php';

		$dsn = 'mysql:host='. DB_HOST . ';dbname=' . DB_NAME . ';port=3306;charset=' . DB_CHARSET;
		try {
			$pdo = new PDO($dsn, DB_USER, DB_PASSWORD);

		}
		catch (PDOException $exception) {
			echo 'Error : ' . $exception->getMessage() . '<br />';
			echo 'N° : ' . $exception->getCode() . '<br/>';
			die('Error database');
		}

		return $pdo;
	}

	// Affiche les erreurs SQL
	function errorDatabase($sRequest)
	{
		echo "\nERREUR : Veuillez contacter un administrateur\n";
		echo "\nPDO::errorInfo():\n";
   		print_r($sRequest->errorInfo());
	}
	
	

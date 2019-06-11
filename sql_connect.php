<?php

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

	
	

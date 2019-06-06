<?php
	echo 'Création de la base de données' . PHP_EOL;

	$host = loopTest('host');
	$login = loopTest('phpMyAdmin login');
	$password = loopTest('password');

	echo 'Voulez-vous créer la base de données sur le serveur '  . $host . ' : o pour oui' . PHP_EOL;
	

	if (strtolower(trim(fgets(STDIN))) === 'o') {
		
		$pdo = databaseConnect($host, $login, $password);

		create_and_select_db_zumba_intranet($pdo);
		create_table_adherent($pdo);
		create_table_statut($pdo);
		create_table_appartient($pdo);
		create_index($pdo);		
		create_foreign_keys($pdo);
	} else {
		die('La base de données n\'a pas été créée');
	}

	

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

	
	// Fonction pour creer la bdd et la selectionner
	function create_and_select_db_zumba_intranet($sPdo)
	{
		$q = 'CREATE DATABASE IF NOT EXISTS `zumba_intranet`
		 	  CHARACTER SET utf8';

		// On execute la requete
		$rows_affected=$sPdo->exec($q);
			
		// Gestion si il y a des erreurs
		if ($rows_affected === FALSE) {
			print_r($sPdo->errorInfo());
		} else {
			print_r('Base de données créée' . PHP_EOL);
		}

		$q = 'USE zumba_intranet';
		$sPdo->query($q);

	}


	// Fonction pour creer la table adherent
	function create_table_adherent($sPdo)
	{
		$q = 'CREATE TABLE IF NOT EXISTS `adherent` (
					`id_adherent` INT UNSIGNED NOT NULL AUTO_INCREMENT,
					`nom_adherent` VARCHAR(20),
					`prenom_adherent` VARCHAR(20),
					`mdp_adherent` VARCHAR(250),
					`statut_adherent` INT UNSIGNED,
					`adresse_adherent` VARCHAR(250),
					`cp_adherent` INT(5) UNSIGNED,
					`ville_adherent` VARCHAR(80),
					`tel_adherent` VARCHAR(10),
					`mail_adherent` VARCHAR(80) NOT NULL,
					`photo_adherent` VARCHAR(250),
					`date_adherent` DATETIME,
					PRIMARY KEY (id_adherent)
				)
				ENGINE=InnoDB';
				
		// On execute la requete
		$rows_affected=$sPdo->exec($q);
				
		// Gestion si il y a des erreurs
		if ($rows_affected === FALSE) {
			print_r($sPdo->errorInfo());
		} else {
			print_r('Table adherent créée' . PHP_EOL);
		}

	}
	

	// Fonction pour creer la table statut
	function create_table_statut($sPdo)
	{
		$q = 'CREATE TABLE IF NOT EXISTS `statut` (
					`id_statut` INT UNSIGNED NOT NULL,
					`nom_statut` VARCHAR(40) NOT NULL,
					PRIMARY KEY (id_statut)
				)
				ENGINE=InnoDB';
		
		$rows_affected=$sPdo->exec($q);
				
		if ($rows_affected === FALSE) {
			print_r($sPdo->errorInfo());
		} else {
			print_r('Table statut créée' . PHP_EOL);
		}

	}
	

	// Fonction pour creer la table appartient	
	function create_table_appartient($sPdo)
	{
		$q = 'CREATE TABLE IF NOT EXISTS `appartient` (
				`id_statut` INT UNSIGNED NOT NULL,
				`id_adherent` INT UNSIGNED NOT NULL,
				PRIMARY KEY (id_statut, id_adherent)
			)
			ENGINE=InnoDB';
	
		$rows_affected=$sPdo->exec($q);
			
		if ($rows_affected === FALSE) {
			print_r($sPdo->errorInfo());
		} else {
			print_r('Table appartient créée' . PHP_EOL);
		}
	}
	

	// Les INDEX
	function create_index($sPdo)
	{
		$q = 'ALTER TABLE appartient ADD INDEX(id_adherent)';

		$rows_affected = $sPdo->exec($q);
				
		if ($rows_affected === FALSE) {
			print_r($sPdo->errorInfo());
		} else {
			print_r('Index sur id_adhrent de la table appartient créé' . PHP_EOL);
		}

		$q = 'ALTER TABLE appartient ADD INDEX(id_statut)';

		$rows_affected = $sPdo->exec($q);
					
		if ($rows_affected === FALSE) {
			print_r($sPdo->errorInfo());
		} else {
			print_r('Index sur id_statut de la table appartient créé' . PHP_EOL);
		}

	}

	
	// Les cles etrangeres
	function create_foreign_keys($sPdo)
	{
		
		$q = 'ALTER TABLE appartient
		 	  ADD CONSTRAINT fk_adherent
		  	  FOREIGN KEY (id_adherent)
		  	  REFERENCES adherent(id_adherent)';

		$rows_affected=$sPdo->exec($q);
			
		if ($rows_affected === FALSE) {
			print_r($sPdo->errorInfo());
		} else {
			print_r('Clé étrangère fk_adherent sur id_adherent' . PHP_EOL);
		}

		$q = 'ALTER TABLE appartient
			  ADD CONSTRAINT fk_statut
			  FOREIGN KEY (id_statut)
			  REFERENCES statut(id_statut)';

		$rows_affected=$sPdo->exec($q);
			
		if ($rows_affected === FALSE) {
			print_r($sPdo->errorInfo());
		} else {
			print_r('Clé étrangère fk_statut sur id_statut' . PHP_EOL);
		}
	}
	





	
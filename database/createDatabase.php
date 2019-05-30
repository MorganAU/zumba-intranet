<?php
	// Creation d'un DSN (Data Source Name)
	$dsn = 'mysql:host=localhost;dbname=;port=3306;charset=utf8';
			
	try {
		// Instanciation d'un objet PDO
		$pdo = new PDO($dsn, 'root', '');
	}
			
	//Gestion des erreurs
	catch (PDOException $exception) {
		echo 'Erreur : ' . $exception->getMessage() . '<br />';
		echo 'N° : ' . $exception->getCode() . '<br />';
		exit('Erreur de connexion à la base de données');
	}

	$q = 'CREATE DATABASE IF NOT EXISTS `zumba_intranet`
		  CHARACTER SET utf8';



	//On execute la requete
	$rows_affected=$pdo->exec($q);
			
	//Gestion si il y a des erreurs
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
	
		print_r($rows_affected);
	}

	$q = 'USE zumba_intranet';

	$pdo->query($q);

	//Requete pour creer la premiere table user 
	$q = 'CREATE TABLE IF NOT EXISTS `user` (
				`id_adherent` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`login_adherent` VARCHAR(20) NOT NULL,
				`nom_adherent` VARCHAR(20),
				`prenom_adherent` VARCHAR(20),
				`mdp_adherent` VARCHAR(250),
				`statut_adherent` INT UNSIGNED,
				`adresse_adherent` VARCHAR(250),
				`cp_adherent` INT(5) UNSIGNED,
				`ville_adherent` VARCHAR(80),
				`tel_adherent` VARCHAR(10),
				`mail_adherent` VARCHAR(80),
				`photo_adherent` VARCHAR(250),
				`date_adherent` DATETIME,
				PRIMARY KEY (id_adherent)
			)
			ENGINE=InnoDB';
			
	//On execute la requete
	$rows_affected=$pdo->exec($q);
			
	//Gestion si il y a des erreurs
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r($rows_affected);
	}

	//Requete pour creer la seconde table statut
	$q = 'CREATE TABLE IF NOT EXISTS `statut` (
				`id_statut` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`nom_statut` VARCHAR(40) NOT NULL,
				PRIMARY KEY (id_statut)
			)
			ENGINE=InnoDB';
	
	$rows_affected=$pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r($rows_affected);
	}


	$q = 'ALTER TABLE user
		  ADD CONSTRAINT fk_statut_adherent_id_statut
		  FOREIGN KEY (statut_adherent)
		  REFERENCES statut(id_statut)';

		$rows_affected=$pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r($rows_affected);
	}

	
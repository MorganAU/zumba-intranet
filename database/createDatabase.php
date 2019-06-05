<?php
	// Creation d'un DSN (Data Source Name)
	$dsn = 'mysql:host=localhost;dbname=;port=3306;charset=utf8';
			
	try {
		// Instanciation d'un objet PDO
		$pdo = new PDO($dsn, 'root', '');
	}
			
	// Gestion des erreurs
	catch (PDOException $exception) {
		echo 'Erreur : ' . $exception->getMessage() . '<br />';
		echo 'N° : ' . $exception->getCode() . '<br />';
		exit('Erreur de connexion à la base de données');
	}

	$q = 'CREATE DATABASE IF NOT EXISTS `zumba_intranet`
		  CHARACTER SET utf8';

	// On execute la requete
	$rows_affected=$pdo->exec($q);
			
	// Gestion si il y a des erreurs
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Base de données créée' . PHP_EOL);
	}

	$q = 'USE zumba_intranet';

	$pdo->query($q);

	// Requete pour creer la premiere table adherent 
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
	$rows_affected=$pdo->exec($q);
			
	// Gestion si il y a des erreurs
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Table adherent créée' . PHP_EOL);
	}

	// Requete pour creer la seconde table statut
	$q = 'CREATE TABLE IF NOT EXISTS `statut` (
				`id_statut` INT UNSIGNED NOT NULL,
				`nom_statut` VARCHAR(40) NOT NULL,
				PRIMARY KEY (id_statut)
			)
			ENGINE=InnoDB';
	
	$rows_affected=$pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Table statut créée' . PHP_EOL);
	}

	// Requete pour creer la seconde table appartient
	$q = 'CREATE TABLE IF NOT EXISTS `appartient` (
				`id_statut` INT UNSIGNED NOT NULL,
				`id_adherent` INT UNSIGNED NOT NULL,
				PRIMARY KEY (id_statut, id_adherent)
			)
			ENGINE=InnoDB';
	
	$rows_affected=$pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Table appartient créée' . PHP_EOL);
	}

	// Les INDEX

	$q = 'ALTER TABLE appartient ADD INDEX(id_adherent)';

	$rows_affected = $pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Index sur id_adhrent de la table appartient créé' . PHP_EOL);
	}

	$q = 'ALTER TABLE appartient ADD INDEX(id_statut)';

	$rows_affected = $pdo->exec($q);
				
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Index sur id_statut de la table appartient créé' . PHP_EOL);
	}

	$q = 'ALTER TABLE adherent ADD INDEX(id_adherent)';

	$rows_affected = $pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Index sur id_adhrent de la table adherent créé' . PHP_EOL);
	}

	$q = 'ALTER TABLE statut ADD INDEX(id_statut)';

	$rows_affected = $pdo->exec($q);
				
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Index sur id_statut de la table statut créé' . PHP_EOL);
	}

	// Les cles etrangeres


	$q = 'ALTER TABLE appartient
		  ADD CONSTRAINT fk_adherent
		  FOREIGN KEY (id_adherent)
		  REFERENCES adherent(id_adherent)';

		$rows_affected=$pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Clé étrangère fk_adherent sur id_adherent' . PHP_EOL);
	}

	$q = 'ALTER TABLE appartient
		  ADD CONSTRAINT fk_statut
		  FOREIGN KEY (id_statut)
		  REFERENCES statut(id_statut)';

		$rows_affected=$pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r('Clé étrangère fk_statut sur id_statut' . PHP_EOL);
	}





	
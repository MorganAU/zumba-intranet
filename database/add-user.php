<?php
	include 'database-functions.php';

	echo 'Ajout d\'utilisateur' . PHP_EOL;
	echo 'Ce programme sert à créer un utilisateur après la création de la base de données' . PHP_EOL;
	echo 'Créer cette utilisateur pour vous connecter au programme' . PHP_EOL;
	echo 'Créer un second utilisateur qui a tous les droits via le programme' . PHP_EOL;
	echo 'Supprimer le premier utilisateur ensuite' . PHP_EOL;

	$host = loopTest('host');
	$login = loopTest('phpMyAdmin login');
	$password = loopTest('password');

	$pdo = databaseConnect($host, $login, $password);
	$q = 'USE zumba_intranet';
	$pdo->query($q);

	echo 'Voulez-vous ajouter un utilisateur : o pour oui' . PHP_EOL;
	$answer = strtolower(trim(fgets(STDIN)));

	echo 'Nom de l\'utilisateur :' . PHP_EOL;
	$nom = trim(fgets(STDIN));
	echo 'Prénom de l\'utilisateur :' . PHP_EOL;
	$prenom = trim(fgets(STDIN));
	echo 'Adresse mail de l\'utilisateur :' . PHP_EOL;
	$mail = trim(fgets(STDIN));
	echo 'Mot de passe de l\'utilisateur :' . PHP_EOL;
	$pass = password_hash(trim(fgets(STDIN)), PASSWORD_DEFAULT);

	addUser($nom, $mail, $prenom, $pass, $pdo);
	$id = getId($mail, $pdo);
	getId($mail, $pdo);
	createPresident($id, $pdo);

	function addUser($sLastname, $sEmail, $sName, $sPass, $sPdo)
	{
		

		$q = $sPdo->prepare('INSERT INTO adherent (nom_adherent,  
												   mail_adherent,
												   prenom_adherent,
												   mdp_adherent, 
													date_adherent) 
							  VALUES (:nom, :mail, :prenom, :pass, NOW())');
		$q->bindParam(':nom', $sLastname);
		$q->bindParam(':mail', $sEmail);
		$q->bindParam(':prenom', $sName);
		$q->bindParam(':pass', $sPass);


		if ($q->execute() === true) {
			echo 'UTILISATEUR AJOUTÉ' .  PHP_EOL . PHP_EOL;
		} else {
			print_r($q->errorInfo());
		}
	}

	function getId($sEmail, $sPdo)
	{
		$q = $sPdo->prepare('SELECT id_adherent FROM adherent 
							 WHERE mail_adherent = :mail');

		$q->bindParam(':mail', $sEmail);

		$id = '';
		
		if($q->execute() != false) {
				while ($row = $q->fetch()) {
					$id = $row['id_adherent'];
			} 
		} else {
			print_r($q->errorInfo());
		}
		return $id;
	}

	function createPresident($nId, $sPdo)
	{
		$q = $sPdo->prepare('INSERT INTO appartient (id_statut, id_adherent)
							VALUES (:statut, :adherent)');

		$status = 5;

		$q->bindParam(':statut', $status);
		$q->bindParam(':adherent', $nId);

		$id = '';
		
		if($q->execute() != false) {
			print_r('STATUT PRESIDENT AJOUTE');
		} else {
			print_r($q->errorInfo());
		}
	}
	
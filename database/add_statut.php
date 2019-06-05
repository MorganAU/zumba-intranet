<?php
/**
* 
*
*
*
*
*
*
**/

	// Creation d'un DSN (Data Source Name)
	$dsn = 'mysql:host=localhost;dbname=zumba_intranet;port=3306;charset=utf8';
			
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
	
	echo PHP_EOL;
	$index = readStatut($pdo) . PHP_EOL . PHP_EOL;
	
	echo 'Voulez-vous ajouter une nouvelle entrée ? => o/n' . PHP_EOL;
	$answer = strtolower(trim(fgets(STDIN)));

	 while ($answer == 'o') {
	 	echo 'Intitulé du statut :' . PHP_EOL;
		$status = strtoupper(trim(fgets(STDIN)));


		addStatut($index, $status, $pdo);

		echo PHP_EOL;
		$index = readStatut($pdo) . PHP_EOL . PHP_EOL;

		echo 'Voulez-vous ajouter une nouvelle entrée ? => o/n' . PHP_EOL;
		$answer = strtolower(trim(fgets(STDIN)));
	}


	function addStatut($nIndex, $sStatut, $sPdo)
	{
		$q = $sPdo->prepare('INSERT INTO statut (id_statut, nom_statut)
				  				VALUES (:id, :nom)');
		$q->bindParam(':id', $nIndex);
		$q->bindParam(':nom', $sStatut);

		$q->execute();

		if ($q->execute() === true) {
			echo 'STATUT AJOUTÉ' .  PHP_EOL . PHP_EOL;
		} else {
			print_r($q->errorInfo());
		}
	}



	function readStatut($sPdo)
	{				
		$q = $sPdo->prepare('SELECT * FROM statut');
		$next = 1;

		if($q->execute() != false) {
			while ($row = $q->fetch()) {
				echo $row['id_statut'] . ' => ' . $row['nom_statut'] . PHP_EOL;
				$next = $row['id_statut'] + 1;
			}	
		}

		return $next;
	}

	
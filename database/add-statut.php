<?php
	include 'database-functions.php';
/**
* 
*
*
*
*
*
*
**/
	echo 'Ajout de statut supplémentaire' . PHP_EOL;

	$host = loopTest('host');
	$login = loopTest('phpMyAdmin login');
	$password = loopTest('password');

	$pdo = databaseConnect($host, $login, $password);

	$q = 'USE zumba_intranet';
	$pdo->query($q);

	$index = readStatut($pdo) . PHP_EOL . PHP_EOL;

	echo 'Voulez-vous ajouter un statut : o pour oui' . PHP_EOL;
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

	
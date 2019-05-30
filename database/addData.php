<?php
	/*// Creation d'un DSN (Data Source Name)
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

	$q = 'ALTER TABLE user
		  ADD CONSTRAINT fk_statut_adherent_id_statut
		  FOREIGN KEY (statut_adherent)
		  REFERENCES statut(id_statut)';

		$rows_affected=$pdo->exec($q);
			
	if ($rows_affected === FALSE) {
		print_r($pdo->errorInfo());
	} else {
		print_r($rows_affected);
	}*/

	
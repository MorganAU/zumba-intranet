<?php
	include_once 'objets/classe-adherent.php';

	$array = array(
		'login' =>'',
		'nom' => '',
		'prenom' => '',
		'mdp' => '',
		'statut' => '',
		'adresse' => '',
		'cp' => '',
		'ville' => '',
		'tel' => '',
		'mail' => '',
		'photo' => '',
		'dateInscritpion' => ''
	);

	if ($argc < 11) {
		die('Manque des informations');
	} else {

		$file = fopen('log.json', 'rw+');
		// \écrire dans le fichier
		
		fputs($file, "{\n");
		foreach( array_keys( $array ) as $index => $key ) {
			// display the current index + key + value
   			$array[$key] = $argv[$index + 1];
			fputs($file, "\t\"" . $key . "\": \"" . $array[$key] . "\",\n");
		}
		fputs($file, "}");

		fclose($file);

		$json = file_get_contents("log.json");

		var_dump(json_decode($json));
		
	}

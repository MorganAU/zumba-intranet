<?php
	include_once 'objets/classe-adherent.php';

	define('PRE_INSCRIT', 0);
	define('INSCRIT', 1);
	define('PROFESSEUR', 2);
	define('SECRETAIRE', 3);
	define('PRESIDENT', 4);
/*
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
		
	}*/

	function menuButton($nStatut)
	{
		$nav = '';

		if ($nStatut == PRESIDENT) {
		 $nav .= '<div class="nav_button">	
					<input type="button" id="classic_button" name="logout_button" value="Utilisateurs" onclick=" button()" />
				</div>';
		}

		$nav .= '<div class="nav_button">
					<input type="button" id="classic_button" name="logout_button" value="Réservations" onclick=" button()" />
				</div>
				<div class="nav_button">
					<input type="button" id="classic_button" name="logout_button" value="Adhérents" onclick=" button()" />
				</div>';

		return $nav;

	}

	function choixMenu()
	{
		$page = basename($_SERVER['SCRIPT_NAME']);
			$html =
				'<ul id="menu">
					<li class="item" ';
					if($page == 'options.php') {
								$html .= 'class="actif"';
					}
					$html .= '><a href="./options.php">Options des questionnaires</a></li>
					<li class="item" ';
					if($page == 'graphiques.php') {
								$html .= 'class="actif"';
							}
							$html .= '><a href="./graphiques.php">Graphiques</a></li>
							<li class="item" ';
							if($page == 'statistiques.php') {
								$html .= 'class="actif"';
							}
							$html .= '><a href="./statistiques.php">Statistiques</a></li>
						</ul>';
					echo $html;
				}














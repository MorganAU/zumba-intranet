<?php
	include_once 'objets/classe-adherent.php';

	define('PRE_INSCRIT', 1);
	define('INSCRIT', 2);
	define('PROFESSEUR', 3);
	define('SECRETAIRE', 4);
	define('PRESIDENT', 5);
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
	$debug_statut = PRESIDENT;

	$nav = menuButton($debug_statut);
	/*$aside = asideButton($page);
	$section = */

	function menuButton($nStatut)
	{
		$nav = '';

		if ($nStatut == PRESIDENT) {
		 $nav .= '<div class="nav_button">
		 			<form id="button" name="button" method="post" action="#">
						<input type="submit" name="valid" id="button" name="logout_button" value="Utilisateurs" />
					</form>
				</div>';
		}

		$nav .= '<div class="nav_button">
		 			<form id="button" name="button" method="post" action="#">
						<input type="submit" id="classic_button" name="valid" value="Réservations" />
					</form>
				</div>
				<div class="nav_button">
		 			<form id="button" name="button" method="post" action="#">
						<input type="submit" id="classic_button" name="valid" value="Adhérents" />
					</form>
				</div>';

		return $nav;

	}

	function displayUsersPage()
	{
		return 'La page Utilisateurs';

	}

	function displayMembersPage()
	{
		return 'La page Adhérents';

	}

	function displayReservationsPage()
	{
		return 'La page Réservations';

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














<?php

	function menuButton($nStatut)
		{
			$nav = '<div class="nav-button">
			 			<form id="button" class="button" name="button" method="post" action="#">
							<input type="submit" id="classic_button" name="valid" value="Réservations" />
						</form>
					</div>
					<div class="nav-button">
			 			<form id="button" class="button" name="button" method="post" action="#">
							<input type="submit" id="classic_button" name="valid" value="Adhérents" />
						</form>
					</div>';
			
			if ($nStatut == PRESIDENT) {
			 	$nav .= '<div class="nav-button">
			 			<form id="button" class="button" name="button" method="post" action="#">
							<input type="submit" name="valid" id="button" name="logout_button" value="Utilisateurs" />
						</form>
					</div>';
			}
			return $nav;
	
		}
	
	
	
		function displayUsersPage()
		{
			$page = '
				<form action="#" method="post">
					<div class="user-div">
						<label class="user-label" for="lastname">Nom de famille</label><br />
						<input  type="text" name="lastname" placeholder="Nom" /><br />
						<label class="user-label" for="lastname">Prénom</label><br />				
						<input type="text" name="name" placeholder="Prénom" />
					</div>				
					<div class="user-div">
						<label class="user-label" for="lastname">Email</label><br />
						<input type="text" name="mail" placeholder="Email" /><br />
						<label class="user-label" for="lastname">Mot de passe provisoire</label><br />
						<input type="text" name="tempPass" placeholder="Mot de passe provisoire" />
					</div>
					<div>
						<select class="user-input" name="statut">
							<option value="">--Choississez un rôle--</option>
							<option value="secretary">Secrétaire</option>
							<option value="instructor">Professeur</option>
							<option value="president">Président</option>
						</select>
					</div>
					<div>
						<input class="user-input" type="submit" value="Valider" />
					</div>
				</form>
				<div>
					<input id="deconnection-button" class="user-input" type="submit" value="Déconnexion" />
				</div>
				<script>
					var buttons = document.getElementsByClassName("button");
					var aside = document.getElementsByTagName("aside");
					var section = document.getElementsByTagName("section");
					aside[0].setAttribute("class", "hidden");
					section[0].setAttribute("class", "user-section");
					buttons[2].id= "active";
				</script>
			';
	
			return $page;
	
		}
	
	
	
		function displayReservationsPage()
		{
			$page = '
				<h1>Titre de la soirée</h1>
				<h3>Date / Heure</h3>
				<h4>Description</h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo 	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est 	laborum.</p>
				<div id="div-img-party">Div contenant une image</div>
				<div id="div-nb-party"><p id="number-of-reservation"><b>Nombre de réservations</b></p></div>
				';
	
			$page .= '<script>
					var buttons = document.getElementsByClassName("button");
					var aside = document.getElementsByTagName("aside");
					var section = document.getElementsByTagName("section");
					aside[0].setAttribute("class", "hidden");
					section[0].setAttribute("class", "user-section");
					buttons[0].id= "active";
				</script>';
	
			return $page;
		}
	
		function displayMembersPage()
		{
			$page = '';
	
			$page = aside_user_button_switch();
	
			$page .= '<script>
					var buttons = document.getElementsByClassName("button");
					buttons[1].id= "active";
				</script>';
	
			return $page;
		}
	
	
	
		function asideMembers()
		{
			$aside = '
				<form id="aside_button" class="aside-form" name="aside_button" method="post" action="#">
					<div class="aside_div">	
						<input type="submit" id="classic_button" class="aside_button" name="aside_valid" value="Voir les adhérents" />
					</div>
				</form>
				<form id="aside_button" class="aside-form" name="aside_button" method="post" action="#">
					<div class="aside_div">	
						<input type="submit" id="classic_button" class="aside_button" name="aside_valid" value="Pré-inscription" />
					</div>
				</form>
				<form id="aside_button" class="aside-form" name="aside_button" method="post" action="#">
					<div class="aside_div">	
						<input type="submit" id="classic_button" class="aside_button" name="aside_valid" value="Ajouter un adhérent" />
					</div>
				</form>
				<form id="aside_button" class="aside-form" name="aside_button" method="post" action="#">
					<div class="aside_div">	
						<input type="submit" id="classic_button" class="aside_button" name="aside_valid" value="Modifier un adhérent" />
					</div>
				</form>
				<form id="aside_button" class="aside-form" name="aside_button" method="post" action="#">
					<div class="aside_div">	
						<input type="submit" id="classic_button" class="aside_button" name="aside_valid" value="Supprimer un adhérent" />
					</div>
				</form>
				<form id="aside_button" class="aside-form" name="aside_button" method="post" action="#">
					<div class="aside_div">	
						<input type="button" id="classic_button" name="aside_valid" value="Déconnexion" />
					</div>
				</form>';
	
			return $aside;		
		}



		function getData()
		{
			$aAdherent = array();
			$adherent = new Adherent();
			$aAdherent = $adherent->getAllAdherents();
			
			for ( $i = 0; $i < 3; $i++ ) {
             $aAdherent[$i] += [ 'statut_adherent' => $adherent->readStatus($aAdherent[$i]['id_adherent']) ];
       		}

			return $aAdherent;
		}


	
		function membersList()
		{	
			$page = '<h1>Liste des membres</h1>';

			$data = getData();
	
			$page .= tablePattern($data);
		
			return $page;
		}


		function button_switch()
		{
			$name_button = '';
			$id_button = 0;

			if (isset($_POST['aside_valid'])) {
				switch ($_POST['aside_valid']) {
					case 'Voir les adhérents':
						$name_button = 'Envoyer un mail';
						$id_button = 0;
						break;
					
					case 'Pré-inscription':
						$name_button = 'Valider l\'inscription';
						$id_button = 1;
						break;
					
					case 'Modifier un adhérent':
						$name_button = 'Modifier';
						$id_button = 3;
						break;
					
					case 'Supprimer un adhérent':
						$name_button = 'Supprimer';
						$id_button = 4;
						break;
					
					default:
						$name_button = 'Envoyer un mail';
						$id_button = 0;
						break;
				}
			} else {
				$name_button = 'Envoyer un mail';
				$id_button = 0;
			}
	
			$button = '
					<td>
						<form action="registration_process.php" method="POST">
							<input type="submit" name="admin_button" value="' . $name_button . '" 	onclick="buttonDelete()">
							<input type="hidden" name="id" value="" />
						</form>
					</td>
					<script>
						var buttons = document.getElementsByClassName("aside_div");
						buttons[' . $id_button . '].id= "active";
					</script>';/* . $aData[$i]['id_adherent'] . */

			return $button;

		}
	
		function preRegistrationList()
		{
	
			$page = '<h1>Pré-inscriptions en attente:</h1>';
			$data = getData();
			$listPreRegistered = array();

			foreach ($data as $value) {
				if ($value['statut_adherent'] == 'PRE_INSCRIT') {
					array_push($listPreRegistered, $value);
				}
			}

			$page .= tablePattern($listPreRegistered);
	
			return $page;
		}
	
	
	
		function tablePattern($aData)
		{
	
			if (isset($_POST['aside_valid'])) {
				$tab = $_POST['aside_valid'];
			} else {
				$tab = 'Voir les adhérents';
			}
	
			$c = count($aData);
	
			$page = '<table class="style-table">
						<tr>
							<th>Id</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Statut</th>
							<th>Adresse</th>
							<th>Code Postal</th>
							<th>Ville</th>
							<th>Téléphone</th>
							<th>Mail</th>
							<th>Photo</th>
							<th>Date d\'inscription</th>
							';
	
			for ($i = 0 ; $i < $c ; $i++) {
					$page .= '
							</tr>
							<tr>
								<td>' . $aData[$i]['id_adherent'] . '</td>
								<td>' . $aData[$i]['nom_adherent'] . '</td>
								<td>' . $aData[$i]['prenom_adherent'] . '</td>
								<td>' . $aData[$i]['statut_adherent'] . '</td>
								<td>' . $aData[$i]['adresse_adherent'] . '</td>
								<td>' . $aData[$i]['cp_adherent'] . '</td>
								<td>' . $aData[$i]['ville_adherent'] . '</td>
								<td>' . $aData[$i]['tel_adherent'] . '</td>
								<td>' . $aData[$i]['mail_adherent'] . '</td>
								<td>' . $aData[$i]['photo_adherent'] . '</td>
								<td>' . $aData[$i]['date_adherent'] . '</td>
								';
	
					if ($tab != 'Ajouter un adhérent') {
						$page .= button_switch();
					}
	
					$page .= '</tr>';
	
			}
	
			$page .= '</table>';
	
			return $page;
	
		}
	
	
	
		function addMember()
		{
			$page = 'Ici on ajoute un membre';
	
			$page = '
				<form action="#" method="post">
					<div class="add-user-div">
						<label class="user-label" for="lastname">Nom de famille</label><br />
						<input  type="text" name="lastname" placeholder="Nom" /><br />
						<label class="user-label" for="name">Prénom</label><br />				
						<input type="text" name="name" placeholder="Prénom" />
					</div>
					<div class="add-user-div">
						<label class="user-label" for="address">Adresse</label><br />
						<input type="text" name="address" placeholder="Adresse" /><br />
						<label class="user-label" for="cp">Code Postal</label><br />
						<input type="text" name="cp" placeholder="Code Postal" />
						<label class="user-label" for="city">Ville</label><br />
						<input type="text" name="city" placeholder="Ville" />
					</div>
					<div class="add-user-div">
						<label class="user-label" for="mail">Email</label><br />
						<input type="text" name="mail" placeholder="Email" /><br />
						<label class="user-label" for="phone">Téléphone</label><br />				
						<input type="text" name="phone" placeholder="Téléphone" />
					</div>
					<div>
						<input class="user-input" type="submit" value="Valider" />
					</div>
				</form>
			';
	
			$page .= '
					<script>
						var buttons = document.getElementsByClassName("aside_div");
						buttons[2].id= "active";
					</script>';
	
			return $page;
		}
	
	
	

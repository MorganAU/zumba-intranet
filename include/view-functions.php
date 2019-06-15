<?php
	

	// Affiche les boutons des menus 
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
						<input type="submit" name="valid" id="button" name="logout_button"value="Utilisateurs" />
					</form>
				</div>';
		}
		return $nav;

	}


	// Affiche la page Réservation
	function displayReservationsPage()
	{
		$page = '
			<h1>Titre de la soirée</h1>
			<h3>Date / Heure</h3>
			<h4>Description</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrudexercitation ullamco laboris nisi ut aliquip ex ea commodo 	consequat. Duis auteirure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nullapariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officiadeserunt mollit anim id est 	laborum.</p>
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
	
	
	// Affiche la page utilisateurs
	function displayUsersPage()
	{
		$page = '
			<form action="#" method="post">
				<div class="user-div">
					<label class="user-label" for="lastname">Nom de famille</label><br />
					<input  type="text" name="lastname" placeholder="Nom" /><br />
					<label class="user-label" for="name">Prénom</label><br />				
					<input type="text" name="name" placeholder="Prénom" />
				</div>				
				<div class="user-div">
					<label class="user-label" for="mail">Email</label><br />
					<input type="text" name="email" placeholder="Email" /><br />
					<label class="user-label" for="tempPass">Mot de passe provisoire</label><br />
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
	
	
	
	// Affiche la page des adhérents
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
					<input type="submit" id="classic_button" class="aside_button" name="aside_valid"value="Voir les adhérents" />
				</div>
			</form>
			<form id="aside_button" class="aside-form" name="aside_button" method="post" action="#">
				<div class="aside_div">	
					<input type="submit" id="classic_button" class="aside_button" name="aside_valid"value="Pré-inscription (' . numberOfPreRegistered() . ')" />
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



		

	
	function membersList()
	{	
		$page = '<h1>Liste des membres</h1>';

		$data = getData();
	
		$page .= tablePattern($data);
	
		return $page;
	}





	
	function preRegistrationList()
	{
	
		$page = '<h1>Pré-inscriptions en attente:</h1>';
		$data = getPreRegistered();

		$page .= tablePattern($data);
	
		return $page;
	}


	function numberOfPreRegistered()
	{
		$data = getPreRegistered();
		return count($data);
	}



	function getPreRegistered()
	{
		$data = getData();
		$listPreRegistered = array();

		foreach ($data as $value) {
			if ($value['statut_adherent'] == 'PRE_INSCRIT') {
				array_push($listPreRegistered, $value);
			}
		}

		return $listPreRegistered;

	}
	
	
	
	function tablePattern($aData)
	{
		if (isset($_SESSION['aside_valid'])) {
			$tab = $_SESSION['aside_valid'];
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
						<td>' . newFormatDate($aData[$i]['date_adherent']) . '</td>
						';
	
			if ($tab != 'Ajouter un adhérent') {
				$page .= button_switch($aData[$i]);
			}
			if (isset($_POST['id'])) {
				if ($aData[$i]['id_adherent'] == $_POST['id']) {
					$page .= buttons_form_process_switch($aData[$i]);
					unset($_POST['id']);
				}
			}
	
			$page .= '</tr>';
	
		}
	
		$page .= '</table>';
	
		return $page;
	
	}
	
	function addMember()
	{
		$page = '<h1>Formulaire d\'ajout de membre</h1>';
		$page .= '
			<form action="#" method="post" id="add-user-form" onsubmit="return verifAllForm()">
				<div class="add-user-div">
					<label class="user-label" for="lastname">Nom de famille</label><br />
					<input class="add-user-input" id="lastname" type="text" name="lastname" placeholder="Nom" onblur="verifInputText(this, 6, 18)" required /><br />
					<p class="hidden" name="lastname"></p>
					<label class="user-label" for="name">Prénom</label><br />				
					<input class="add-user-input" type="text" name="name" placeholder="Prénom" onblur="verifInputText(this, 6, 18)" required />
					<p class="hidden" name="name"></p>
				</div>
				<div class="add-user-div">
					<label class="user-label" for="address">Adresse</label><br />
					<input class="add-user-input" type="text" name="address" placeholder="Adresse"  onblur="verifInputText(this, 6, 248)" required /><br />
					<p class="hidden" name="address"></p>					
					<label class="user-label" for="cp">Code Postal</label><br />
					<input class="add-user-input" type="text" name="cp" placeholder="Code Postal"  onblur="verifInputText(this, 5, 5)" required />
					<p class="hidden" name="cp"></p>					
					<label class="user-label" for="city">Ville</label><br />
					<input class="add-user-input" type="text" name="city" placeholder="Ville"  onblur="verifInputText(this, 4, 75)" required />
					<p class="hidden" name="city"></p>					
				</div>
				<div class="add-user-div">
					<label class="user-label" for="mail">Email</label><br />
					<input class="add-user-input" type="email" name="email" placeholder="Email"  onblur="verifInputText(this, 6, 75)" required /><br />
					<p class="hidden" name="email"></p>					
					<label class="user-label" for="phone">Téléphone</label><br />				
					<input class="add-user-input" type="text" name="phone" placeholder="Téléphone"  onblur="verifInputText(this, 10, 10)" required />
					<p class="hidden" name="phone"></p>					
				</div>
				<div>
					<input class="user-input" type="submit" name="add-user-button" value="Valider" />
				</div>
			</form>
		';
	
		$page .= '
				<script>
					var buttons = document.getElementsByClassName("aside_div");
					buttons[2].id= "active";
					var inputs = document.getElementsByClassName("add-user-input");					
				</script>';

		
	
		return $page;
	}
	
	
	
function display_buttons($nIdButton, $sNameButton, $nIdAdherent, $sMailAdherent)
{	

	$button = '
			<td>
				<form name="aside_button" method="post" action="#">
					<input type="submit" name="buttons_form" value="' . $sNameButton . '" />
					<input type="hidden" name="id" value="' . $nIdAdherent . '" />
					<input type="hidden" name="mail" value="' . $sMailAdherent . '" />
				</form>
			</td>
			<script>
				var buttons = document.getElementsByClassName("aside_div");
				buttons[' . $nIdButton . '].id= "active";
			</script>';
	return $button;
}
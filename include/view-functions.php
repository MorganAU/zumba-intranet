<?php
	/** Liste des fonctions pour gérer les pages HTML en fonction de là où est l'utilisateur 
	*	menuButton($nStatut) ---------------> Code HTML pour les trois boutons du menu
	*	displayReservationsPage() ----------> Code HTML pour la page des réservations
	*	displayMembersPage() ---------------> Code HTML pour la page des des adhérents
	*	displayUsersPage() -----------------> Code HTML pour la page des des utilisateurs
	*	asideMembers() ---------------------> Code HTML pour l'aside quand on est sur la page des adhérents
	*	membersList() ----------------------> Code HTML pour la liste des membres
	*	sendMail($aUser) -------------------> Code affichant le texte après clique sur le bouton d'envoi de mail en attendant d'un réel envoie !!!!!!!!!!!!!!!!!!!
	*	preRegistrationList() --------------> Code HTML pour la liste des pré-inscrits
	*	tablePattern($aData) ---------------> Code pour afficher un tableau contentant des données d'utilisateurs
	*	displayButtons($nIdButton, $sNameButton, $nIdAdherent, $sMailAdherent) -> Code HTML pour certain boutons de l'aside
	*	addMember() ------------------------> Code HTML pour la page d'ajout d'adhérent
	*	updateMemberPage() --------> Code HTML pour la page de modification d'adhérent
	*	memberForm() --------> Code HTML pour la construction du formulaire
	*/

	// Code HTML pour les trois boutons du menu 
	function menuButton($nStatut)
	{
		$nav = '
			<div class="nav-button">
		 		<form method="post" action="#">
					<input type="submit"  class="menu-buttons" name="menu_button" value="Réservations" />
				</form>
			</div>
			<div class="nav-button">
		 		<form method="post" action="#">
					<input type="submit" class="menu-buttons" name="menu_button" value="Adhérents" />
				</form>
			</div>';
		
		// Si c'est le président qui est connecté on ajoute le troisième bouton
		if ($nStatut == PRESIDENT) {
		 	$nav .= '
		 		<div class="nav-button">
		 			<form method="post" action="#">
						<input type="submit" class="menu-buttons" name="menu_button" value="Utilisateurs" />
					</form>
				</div>';
		}
		return $nav;

	}


	// Code HTML pour la page des réservations
	function displayReservationsPage()
	{
		// Page des réservations 
		$page = '
			<h1>Titre de la soirée</h1>
			<h3>Date / Heure</h3>
			<h4>Description</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrudexercitation ullamco laboris nisi ut aliquip ex ea commodo 	consequat. Duis auteirure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nullapariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officiadeserunt mollit anim id est 	laborum.</p>
			<div id="div-list-party">Liste des personnes ayant réservé</div>
			<div id="div-nb-party"><p id="number-of-reservation"><b>Nombre de réservations</b></p></div>
			';

		// Code JavaScript pour les boutons et l'aside
		$page .= '
			<script>
				var menuButtons = document.getElementsByClassName("menu-buttons");
				var asideButtons = document.getElementsByTagName("aside");
				var section = document.getElementsByTagName("section");
				menuButtons[0].id= "active";
				asideButtons[0].setAttribute("class", "hidden");
				section[0].setAttribute("class", "section-without-aside");
			</script>';

		return $page;
	}
	

	// Code HTML pour la page des des adhérents
	function displayMembersPage()
	{	
		// Page des adhérents 		
		$page = aside_user_button_switch();
	
		// Code JavaScript pour les boutons
		$page .= '
			<script>
				var menuButtons = document.getElementsByClassName("menu-buttons");
				menuButtons[1].id= "active";
			</script>';
		
		return $page;
	}
	
	
	// Code HTML pour la page des des utilisateurs
	function displayUsersPage()
	{
		// Page des utilisateurs
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
			</div>';

		// Code JavaScript pour les boutons et l'aside
		$page .= '
			<script>
				var menuButtons = document.getElementsByClassName("menu-buttons");
				var asideButtons = document.getElementsByTagName("aside");
				var section = document.getElementsByTagName("section");
				menuButtons[2].id= "active";
				asideButtons[0].setAttribute("class", "hidden");
				section[0].setAttribute("class", "section-without-aside");
			</script>';

		return $page;

	}
	
	
	//Code HTML pour l'aside quand on est sur la page des adhérents
	function asideMembers()
	{
		// Aside
		$aside = '
			<form class="aside-form" method="post" action="#">
				<div>	
					<input type="submit" class="aside-button" name="aside_buttons" value="Voir les adhérents" />
				</div>
			</form>
			<form class="aside-form" method="post" action="#">
				<div>	
					<input type="submit" class="aside-button" name="aside_buttons" value="Pré-inscription (' . numberOfPreRegistered() . ')" />
				</div>
			</form>
			<form class="aside-form" method="post" action="#">
				<div>	
					<input type="submit" class="aside-button" name="aside_buttons" value="Ajouter un adhérent" />
				</div>
			</form>
			<form class="aside-form" method="post" action="#">
				<div>	
					<input type="submit" class="aside-button" name="aside_buttons" value="Modifier un adhérent" />
				</div>
			</form>
			<form class="aside-form" method="post" action="#">
				<div>	
					<input type="submit" class="aside-button" name="aside_buttons" value="Supprimer un adhérent" />
				</div>
			</form>
			<form class="aside-form" method="post" action="#">
				<div>	
					<input type="button" name="aside_buttons" value="Déconnexion" />
				</div>
			</form>';

		return $aside;		
	}


	// Code HTML pour la liste des membres
	function membersList()
	{	
		$page = '<h1>Liste des membres</h1>';

		// Récupération des données de la base
		$data = getData();
		
		// Construction du tableau
		$page .= tablePattern($data);
	
		return $page;
	}


	// Code affichant le texte après clique sur le bouton d'envoi de mail en attendant d'un réel envoie
	function sendMail($aUser)
	{
		$text = '<h3>Un mail est envoyé à "' . $aUser['mail_adherent'] . '" pour qu\'il puisse changer son mot 	de passe</h3>';
	
		return $text;
	}


	// Code HTML pour la liste des pré-inscrits
	function preRegistrationList()
	{
	
		$page = '<h1>Pré-inscriptions en attente:</h1>';

		// Récupération la liste des pré-inscrits
		$data = getPreRegistered();

		// Construction du tableau
		$page .= tablePattern($data);
	
		return $page;
	}

	
	// Code pour afficher un tableau contentant des données d'utilisateurs
	function tablePattern($aData)
	{
		if (isset($_SESSION['aside_buttons'])) {
			$tab = $_SESSION['aside_buttons'];
		} else {
			$tab = 'Voir les adhérents';
		}
		
		// Récupération du nombre d'entrée du tableau
		$c = count($aData);
		
		// Construction de l'en-tête du tableau
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
		
		// Ajout des entrées
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
			
			// Ajout des boutons en fonction de l'onglet sélectionné
			$page .= buttonSwitch($aData[$i]);
			
			// Si un bouton est pressé
			if (isset($_POST['id'])) {
				// Récupération de l'id pour lequel le bouton a été pressé
				if ($aData[$i]['id_adherent'] == $_POST['id']) {
					// Utilisation de la fonction du bouton
					$page .= buttonProcess($aData[$i]);
					unset($_POST['id']);
				}
			}	
			if (isset($_POST['buttons_form'])) {
				// Récupération de l'id pour lequel le bouton a été pressé
				
			}
			$page .= '</tr>';
		}
		$page .= '</table>';
	
		return $page;
	}
	

	// Code HTML pour certain boutons de l'aside
	function displayButtons($nIdButton, $sNameButton, $nIdAdherent, $sMailAdherent)
	{	
		$button = '
				<td>
					<form method="post" action="#">
						<input type="submit" name="buttons_form" value="' . $sNameButton . '" />
						<input type="hidden" name="id" value="' . $nIdAdherent . '" />
						<input type="hidden" name="mail" value="' . $sMailAdherent . '" />
					</form>
				</td>
				<script>
					var asideButtons = document.getElementsByClassName("aside-button");
					asideButtons[' . $nIdButton . '].id= "active";
				</script>';

		return $button;
	}


	// Code HTML pour la page d'ajout d'adhérent
	function addMember()
	{
		$page = '<h1>Formulaire d\'ajout de membre</h1>';
		$page .= addMemberForm();
	
		// Code JavaScript pour les boutons de l'aside
		$page .= '
				<script>
					var asideButtons = document.getElementsByClassName("aside-button");
					asideButtons[2].id= "active";
				</script>';

		// Si le bouton Valider est pressé
		if (isset($_POST['add-user-button'])) {
			if ($_POST['add-user-button'] == 'Valider') {
				$page .= addMembersButton();
			}	
		}

		return $page;
	}
	
	

	// Code HTML pour la page de modification d'adhérent
	function updateMemberPage()
	{
		unset($_POST['buttons_form']);

		$page = '<h1>Formulaire de modification de membre</h1>';
			$page .= updateMemberForm();
			$page .= '
					<script>
						var asideButtons = document.getElementsByClassName("aside-button");
						asideButtons[3].id= "active";
					</script>';

	

	
			/*if (isset($_POST['return'])) {
				if ($_POST['return'] == 'Retour') {
					$page .= aside_user_button_switch();
				}
			}*/
	
			return $page;
	
	}


	// Code HTML pour la construction du formulaire
	function updateMemberForm()
	{
		$adherent = new Adherent();
		$adherent->readAdherentByMail($_POST['mail']);

		$form = '
			<form action="#" method="post" onsubmit="return verifAllForm()">
				<div class="add-user-div">
					<label class="user-label" for="lastname">Nom de famille</label><br />
					<input type="text" class="add-user-input" name="lastname" value="'. $adherent->getNom() .'" placeholder="Nom" minlength="2" maxlength="18" onblur="verifInputText(this)" required /><br />
					<p class="hidden" name="lastname"></p>
					<label class="user-label" for="name">Prénom</label><br />				
					<input type="text" class="add-user-input" name="name" value="'. $adherent->getPrenom() .'" placeholder="Prénom" minlength="2" maxlength="18" onblur="verifInputText(this)" required />
					<p class="hidden" name="name"></p>
				</div>
				<div class="add-user-div">
					<label class="user-label" for="address">Adresse</label><br />
					<input type="text" class="add-user-input" name="address" value="'. $adherent->getAdresse() .'" placeholder="Adresse" minlength="6" maxlength="248"  onblur="verifInputText(this)" required /><br />
					<p class="hidden" name="address"></p>					
					<label class="user-label" for="cp">Code Postal</label><br />
					<input type="text" class="add-user-input" name="cp" value="'. $adherent->getCp() .'" placeholder="Code Postal" minlength="5" maxlength="5"  onblur="verifInputText(this)" required />
					<p class="hidden" name="cp"></p>					
					<label class="user-label" for="city">Ville</label><br />
					<input type="text" class="add-user-input" name="city" value="'. $adherent->getVille() .'" placeholder="Ville" minlength="4" maxlength="75"  onblur="verifInputText(this)" required />
					<p class="hidden" name="city"></p>					
				</div>
				<div class="add-user-div">
					<label class="user-label" for="mail">Email</label><br />
					<input type="email" class="add-user-input" name="email" value="'. $adherent->getMail() .'" placeholder="Adresse mail" minlength="6" maxlength="75"  onblur="verifInputText(this)" required /><br />
					<p class="hidden" name="email"></p>					
					<label class="user-label" for="phone">Téléphone</label><br />				
					<input type="text" class="add-user-input" name="phone" value="'. $adherent->getTel() .'" placeholder="Téléphone" minlength="10" maxlength="10"  onblur="verifInputText(this)" required />
					<p class="hidden" name="phone"></p>					
				</div>
				<div>
					<input class="user-input" type="submit" name="buttons_form" value="Modifier" />
					<input type="hidden" name="mail" value="' .  $adherent->getMail() . '" />
					<input type="hidden" name="test" value="1" />
				</div>
			</form>
			<form action="#" method="post">
				<input class="user-input" type="submit" name="return" value="Retour" />
			</form>
		';

		return $form;
	}



	// Code HTML pour la construction du formulaire
	function addMemberForm()
	{
		$form = '
			<form action="#" method="post" onsubmit="return verifAllForm()">
				<div class="add-user-div">
					<label class="user-label" for="lastname">Nom de famille</label><br />
					<input type="text" class="add-user-input" name="lastname" placeholder="Nom" minlength="2" maxlength="18" onblur="verifInputText(this)" required /><br />
					<p class="hidden" name="lastname"></p>
					<label class="user-label" for="name">Prénom</label><br />				
					<input type="text" class="add-user-input" name="name" placeholder="Prénom" minlength="2" maxlength="18" onblur="verifInputText(this)" required />
					<p class="hidden" name="name"></p>
				</div>
				<div class="add-user-div">
					<label class="user-label" for="address">Adresse</label><br />
					<input type="text" class="add-user-input" name="address" placeholder="Adresse" minlength="6" maxlength="248"  onblur="verifInputText(this)" required /><br />
					<p class="hidden" name="address"></p>					
					<label class="user-label" for="cp">Code Postal</label><br />
					<input type="text" class="add-user-input" name="cp" placeholder="Code Postal" minlength="5" maxlength="5"  onblur="verifInputText(this)" required />
					<p class="hidden" name="cp"></p>					
					<label class="user-label" for="city">Ville</label><br />
					<input type="text" class="add-user-input" name="city" placeholder="Ville" minlength="4" maxlength="75"  onblur="verifInputText(this)" required />
					<p class="hidden" name="city"></p>					
				</div>
				<div class="add-user-div">
					<label class="user-label" for="mail">Email</label><br />
					<input type="email" class="add-user-input" name="email" placeholder="Adresse mail" minlength="6" maxlength="75"  onblur="verifInputText(this)" required /><br />
					<p class="hidden" name="email"></p>					
					<label class="user-label" for="phone">Téléphone</label><br />				
					<input type="text" class="add-user-input" name="phone" placeholder="Téléphone" minlength="10" maxlength="10"  onblur="verifInputText(this)" required />
					<p class="hidden" name="phone"></p>					
				</div>
				<div>
					<input class="user-input" type="submit" name="add-user-button" value="Valider" />
				</div>
			</form>
		';
	

		return $form;
	}
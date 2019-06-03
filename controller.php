<?php
	include_once 'objets/classe-adherent.php';

	define('PRE_INSCRIT', 1);
	define('INSCRIT', 2);
	define('PROFESSEUR', 3);
	define('SECRETAIRE', 4);
	define('PRESIDENT', 5);

	$debug_statut = PRESIDENT;

	$section = display($debug_statut);
	$nav = menuButton($debug_statut);
	$aside = asideButton();

	function menuButton($nStatut)
	{
		$nav = '';

		if ($nStatut == PRESIDENT) {
		 $nav .= '<div class="nav-button">
		 			<form id="button" class="button" name="button" method="post" action="#">
						<input type="submit" name="valid" id="button" name="logout_button" value="Utilisateurs" />
					</form>
				</div>';
		}

		$nav .= '<div class="nav-button">
		 			<form id="button" class="button" name="button" method="post" action="#">
						<input type="submit" id="classic_button" name="valid" value="Réservations" />
					</form>
				</div>
				<div class="nav-button">
		 			<form id="button" class="button" name="button" method="post" action="#">
						<input type="submit" id="classic_button" name="valid" value="Adhérents" />
					</form>
				</div>';

		return $nav;

	}

	function display($nStatut)
	{
		$section = '';

		if (isset($_POST['valid'])) {
   			if ($_POST['valid'] == 'Utilisateurs' && $nStatut == PRESIDENT) {
   				$_SESSION['page'] = 'Utilisateurs';
   			} else if ($_POST['valid'] == 'Adhérents') {
   				$_SESSION['page'] = 'Adhérents';
   			} else {
   				$_SESSION['page'] = 'Réservation';
   			}
		}

		if (isset($_SESSION['page'])) {
			if ($_SESSION['page'] == 'Utilisateurs') {
				$section = displayUsersPage();
			} else if ($_SESSION['page'] == 'Adhérents') {
				$section = displayMembersPage();				
			} else {
				$section = displayReservationsPage();				
			}
		}

		return $section;

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
				var aside = document.getElementsByTagName("aside");
				var section = document.getElementsByTagName("section");
				var buttons = document.getElementsByClassName("button");

				aside[0].setAttribute("class", "hidden");
				section[0].setAttribute("class", "user-section");
				buttons[0].id= "active";
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
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<div id="div-img-party">Div contenant une image</div>
			<div id="div-nb-party"><p id="number-of-reservation"><b>Nombre de réservations</b></p></div>
			';

		$page .= '<script>
				var buttons = document.getElementsByClassName("button");
				buttons[1].id= "active";
			</script>';

		return $page;
	}

	function displayMembersPage()
	{
		$page = '';

		if (isset($_POST['aside_valid'])) {
			switch ($_POST['aside_valid']) {
				case 'Voir les adhérents':
					$page = membersList();
					break;

				case 'Pré-inscription':
					$page = preRegistrationList();
					break;
				
				case 'Ajouter un adhérent':
					$page = addMember();
					break;
				
				case 'Modifier un adhérent':
					$page = updateMember();
					break;
				
				case 'Supprimer un adhérent':
					$page = deleteMember();
					break;
				
				case 'Gestion des mots de passe':
					$page = updatePasswords();
					break;
				
				default:
					$page = membersList();
					break;
			}
		} else {
			$page = membersList();					
		}

		$page .= '<script>
				var buttons = document.getElementsByClassName("button");
				buttons[2].id= "active";
			</script>';

		return $page;
	}

	function asideButton()
	{
		$aside = '';

		if ($_SESSION['page'] == 'Adhérents') {
			$aside = asideMembers();
		} else if ($_SESSION['page'] == 'Réservation') {
			$aside = asideReservation();
		}



		return $aside;
	}

	function asideReservation()
	{
		$aside = '
			<select class="user-input" name="date_party">
				<option value="">--Choississez une soirée--</option>
				<option value="0">Soirée 1</option>
				<option value="1">Soirée 2</option>
				<option value="2">Soirée 3</option>
			</select>';

			$aside .='
			<div>
				<input id="aside-deconnection-button" class="user-input" type="submit" value="Déconnexion" />
			</div>';

		return $aside;
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
					<input type="submit" id="classic_button" class="aside_button" name="aside_valid" value="Gestion des mots de passe" />
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
		$page = 'Ici on liste tous les membres';

		$page .= '
				<script>
					var buttons = document.getElementsByClassName("aside_div");
					buttons[0].id= "active";
				</script>';

		return $page;
	}

	function preRegistrationList()
	{
		$page = 'Ici on liste les pré-inscriptions';

		$page .= '
				<script>
					var buttons = document.getElementsByClassName("aside_div");
					buttons[1].id= "active";
				</script>';

		return $page;
	}

	function addMember()
	{
		$page = 'Ici on ajoute un membre';

		$page .= '
				<script>
					var buttons = document.getElementsByClassName("aside_div");
					buttons[2].id= "active";
				</script>';

		return $page;
	}

	function updateMember()
	{
		$page = 'Ici on modifie un membre';

		$page .= '
				<script>
					var buttons = document.getElementsByClassName("aside_div");
					buttons[3].id= "active";
				</script>';

		return $page;
	}

	function deleteMember()
	{
		$page = 'Ici on supprime un membre';

		$page .= '
				<script>
					var buttons = document.getElementsByClassName("aside_div");
					buttons[4].id= "active";
				</script>';

		return $page;
	}

	function updatePasswords()
	{
		$page = 'Ici on modifie les mots de passe';

		$page .= '
				<script>
					var buttons = document.getElementsByClassName("aside_div");
					buttons[5].id= "active";
				</script>';

		return $page;
	}












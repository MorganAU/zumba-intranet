<?php

	echo '
		<!DOCTYPE html>
		<html>
		<head>
			<title>Intranet de Zumbambb</title>
			<meta charset="utf-8">
			<link rel="stylesheet" type="text/css" href="include/style.css">
		</head>
		<body>
			<header>Ceci est le header</header>
			<nav> '
				. menuButton(PRESIDENT) .
			'</nav>
		<aside class="">'
				. asideMembers() .
		'</aside>
		<section>'
				.	display(PRESIDENT) .
		'</section>
			<footer>Ceci est le footer</footer>
		</body>
		</html>';



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
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
		$adherent = new Adherent();
		$aAdherent = array();
		$aAdherent = $adherent->getAllAdherents();
		var_dump($aAdherent);

		$page = 'Ici on liste tous les membres';
	
		for ($i = 0, $c = count($aAdherent) ; $i < $c ; $i++) {
			$page .= '
				<tr>
					<td>' . $aAdherent[$i]['id_adherent'] . '</td>
					<td>' . $aAdherent[$i]['nom_adherent'] . '</td>
					<td>' . $aAdherent[$i]['prenom_adherent'] . '</td>
					<td>' . $aAdherent[$i]['mdp_adherent'] . '</td>
					<td>' . $aAdherent[$i]['statut_adherent'] . '</td>
					<td>' . $aAdherent[$i]['adresse_adherent'] . '</td>
					<td>' . $aAdherent[$i]['cp_adherent'] . '</td>
					<td>' . $aAdherent[$i]['ville_adherent'] . '</td>
					<td>' . $aAdherent[$i]['tel_adherent'] . '</td>
					<td>' . $aAdherent[$i]['mail_adherent'] . '</td>
					<td>' . $aAdherent[$i]['photo_adherent'] . '</td>
					<td>' . $aAdherent[$i]['date_adherent'] . '</td>
					
						<td>
							<form action="registration_process.php" method="POST">
								<input type="submit" name="admin_button" value="Envoyer un mail" onclick="buttonDelete()">
								<input type="hidden" name="id" value="' . $aAdherent[$i]['id_adherent'] . '" />
							</form>
						</td>
						<td>
							<form action="delete_user.php" method="POST">
								<input type="hidden" name="id" value="' . $aAdherent[$i]['id_adherent'] . '" />
								<input type="submit" name="admin_button" value="Supprimer">
							</form>
						</td>
					</center>
				</tr>

			';
		}

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



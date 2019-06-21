<?php
	/** Liste des fonctions pour gérer les pages HTML en fonction de là où est l'utilisateur 
	*	menuButton($nStatut) ---------------> Code HTML pour les trois boutons du menu
	*	displayReservationsPage() ----------> Code HTML pour la page des réservations
	*	displayUsersPage() -----------------> Code HTML pour la page des utilisateurs
	*	asideMembers() ---------------------> Code HTML pour l'aside quand on est sur la page des adhérents
	*	membersList() ----------------------> Code HTML pour la liste des membres
	*	sendMail($aUser) -------------------> Code affichant le texte après clique sur le bouton d'envoi de mail en attendant d'un réel envoie !!!!!!!!!!!!!!!!!!!
	*	preRegistrationList() --------------> Code HTML pour la liste des pré-inscrits
	*	tablePattern($aData) ---------------> Code pour afficher un tableau contentant des données d'utilisateurs
	*	displayButtons($nIdButton, $sNameButton, $nIdAdherent, $sMailAdherent) -> Code HTML pour certain boutons de l'aside
	*	addMember() ------------------------> Code HTML pour la page d'ajout d'adhérent
	*	updateMemberPage() -----------------> Code HTML pour la page de modification d'adhérent
	*	addForm() --------------------------> Code HTML pour la construction du formulaire d'ajout
	**/


	// Code HTML pour les trois boutons du menu 
	function menuButton($nStatut)
	{
		if ($_SESSION['connect'] == 1) {
			$nav = ' 
			<!-- Page Content -->

			    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
			    	<button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
			    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			          <span class="navbar-toggler-icon"></span>
			   		</button>
			   		<input id="deconnection-button" class="btn btn-primary" type="submit" name="" value="Déconnexion" />
			    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
			        	<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
			            	<li class="nav-item active">
			            	<form method="post" action="#">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="page_button" value="Réservations" />
			            	</li>
			            	<li class="nav-item">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="page_button" value="Adhérents" />
							</form>
			            	</li>';

			        // Si c'est le président qui est connecté on ajoute le troisième bouton
					if ($nStatut == PRESIDENT) {
					 	$nav .= '
 							<li class="nav-item">
					 			<form method="post" action="#">
									<input type="submit" class="btn btn-outline-primary btn-lg" name="page_button" value="Utilisateurs" />
								</form>
							</li>';
					}

			$nav .= '
			          	</ul>
			        </div>
			    </nav>';
		return $nav;
		}   

	}


	// Code HTML pour la page de connexion
	function displayConnectionPage()
	{
		if (!isset($_SESSION['connect']) || $_SESSION['connect'] === 0) {
			$page = '
			<center>
				<h1>Veuillez-vous connecter</h1>
				<form method="post" action="#">
					<input type="email" class="btn btn-outline-primary btn-lg" name="email" placeholder="Adresse mail" minlength="6" maxlength="75" onblur="verifInputText(this)" required />
					<input type="password" class="btn btn-outline-primary btn-lg" name="password" placeholder="Mot de passe" required />
				</form>
			</center>';

			return $page;
		}
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
				var menuButtons = document.getElementsByClassName("btn btn-outline-primary btn-lg");
				var toggleButton  = document.getElementById("menu-toggle");
				menuButtons[0].id= "active-button-menu";
				toggleButton.setAttribute("disabled","disabled");

			</script>';

		return $page;
	}
	
	// Code HTML pour la page des des utilisateurs
	function displayUsersPage()
	{
		// Page des utilisateurs
		$page = '
			<form action="#" method="post" onsubmit="return verifAllForm()">
				<div class="user-div">
					<label class="user-label" for="lastname">Nom de famille</label><br />
					<input type="text" class="add-user-input" name="lastname" placeholder="Nom" minlength="2" maxlength="18" onblur="verifInputText(this)" required /><br />
					<p class="hidden" name="lastname"></p>
					<label class="user-label" for="name">Prénom</label><br />				
					<input type="text" class="add-user-input" name="name" placeholder="Prénom" minlength="2" maxlength="18" onblur="verifInputText(this)" required />
					<p class="hidden" name="name"></p>
				</div>				
				<div class="user-div">
					<label class="user-label" for="mail">Email</label><br />
					<input type="email" class="add-user-input" name="email" placeholder="Adresse mail" minlength="6" maxlength="75"  onblur="verifInputText(this)" required /><br />
					<p class="hidden" name="email"></p>
					<label class="user-label" for="phone">Téléphone</label><br />				
					<input type="text" class="add-user-input" name="phone" placeholder="Téléphone" minlength="10" maxlength="10"  onblur="verifInputText(this)" required />
					<p class="hidden" name="phone"></p>
				</div>
				<div>
					<select class="add-user-input" name="status" onchange="verifInputText(this)">
						<option value=0>--Choississez un rôle--</option>
						<option value=3>Secrétaire</option>
						<option value=4>Professeur</option>
						<option value=5>Président</option>
					</select>
					<p class="hidden" name="status"></p>
				</div>
				<div>
					<input class="user-input" type="submit" name="button" value="Créer" />
				</div>
			</form>';

		// Code JavaScript pour les boutons et l'aside
		$page .= '
			<script>
				var menuButtons = document.getElementsByClassName("btn btn-outline-primary btn-lg");
				var toggleButton  = document.getElementById("menu-toggle");
				menuButtons[2].id= "active-button-menu";
				toggleButton.setAttribute("disabled","disabled");
			</script>';


			// Si le bouton Valider est pressé
		if (isset($_POST['button'])) {
			if ($_POST['button'] == 'Créer') {
				$page .= addUsersButton();
			}	
		}

		return $page;

	}
	
	
	//Code HTML pour l'aside quand on est sur la page des adhérents
	function asideMembers()
	{
		$count = numberOfPreRegistered();
		$input = '';

		if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) {
			if ($count == 0) {
				$input = '<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Pré-inscription (' . numberOfPreRegistered() . ')" disabled ="disabled" />';
			} else {
				$input = '<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Pré-inscription (' . numberOfPreRegistered() . ')" />';
			}
			// Aside
			$aside = '
					<!-- Sidebar -->
				    <div class="bg-light border-right" id="sidebar-wrapper">
			     	   	<div class="sidebar-heading">
			     	   		<!--<script>
								var maintenant=new Date();
								var jour=maintenant.getDate();
								var mois=maintenant.getMonth()+1;
								var an=maintenant.getFullYear();
								var heure = maintenant.getHours();
								var min = maintenant.getMinutes();
								var sec = maintenant.getSeconds();
	
								if (mois < 10) {
									document.write(jour, "/0", mois, "/", an);
								}
								else {
									document.write(jour,"/",mois,"/",an);
								}
	
								if (min < 10) {
									document.write("<br />", heure, ":0", min, ":", sec);
								} else {
									document.write("<br />", heure, ":", min, ":", sec);
								}
							</script>-->
			     	   	</div>
			      		<div class="list-group list-group-flush">
			        		<form class="aside-form" method="post" action="#">
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Voir les adhérents" />' .
								$input . '
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Ajouter un adhérent" />
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Modifier un adhérent" />
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Supprimer un adhérent" />
							</form>
			      		</div>
			    	</div>
			   		<!-- /#sidebar-wrapper -->';
		return $aside;		
		}
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
		// Les lignes suivantes sont pour le test en local
		$_SESSION['page'] = 'Formulaire de mot de passe';
		header ("Refresh: 3;URL=/zumba-intranet/pass-form.php");

	
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
		// Récupération du nombre d'entrée du tableau
		$c = count($aData);
		
		// Construction de l'en-tête du tableau
		$page = '
			<div class"table-responsive">
			<table class="table table-sm table-hover">
				<thead>
					<tr>
						<th scope="col">Id</th>
						<th scope="col">Nom</th>
						<th scope="col">Prénom</th>
						<th scope="col">Statut</th>
						<th scope="col">Adresse</th>
						<th scope="col">Code Postal</th>
						<th scope="col">Ville</th>
						<th scope="col">Téléphone</th>
						<th scope="col">Mail</th>
						<th scope="col">Photo</th>
						<th scope="col">Date d\'inscription</th>
					</tr>
				</thead>
				<tbody>
						';
		
		// Ajout des entrées
		for ($i = 0 ; $i < $c ; $i++) {
			$page .= '
					<tr>
						<th scope="row">' . $aData[$i]['id_adherent'] . '</th>
						<td scope="row">' . $aData[$i]['nom_adherent'] . '</td>
						<td scope="row">' . $aData[$i]['prenom_adherent'] . '</td>
						<td scope="row">' . $aData[$i]['statut_adherent'] . '</td>
						<td scope="row">' . $aData[$i]['adresse_adherent'] . '</td>
						<td scope="row">' . $aData[$i]['cp_adherent'] . '</td>
						<td scope="row">' . $aData[$i]['ville_adherent'] . '</td>
						<td scope="row">' . $aData[$i]['tel_adherent'] . '</td>
						<td scope="row">' . $aData[$i]['mail_adherent'] . '</td>
						<td scope="row">' . $aData[$i]['photo_adherent'] . '</td>
						<td scope="row">' . newFormatDate($aData[$i]['date_adherent']) . '</td>
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
			$page .= '</tr>';
		}
		
		$page .= '
				</tbody>
			</table>
		</div>
		<!--Code JavaScript pour les boutons-->
		<script>
			var menuButtons = document.getElementsByClassName("btn btn-outline-primary btn-lg");
			menuButtons[1].id= "active-button-menu";
		</script>';
	
		return $page;
	}
	

	// Code HTML pour certain boutons de l'aside
	function displayButtons($nIdButton, $sNameButton, $sValueButton, $oUser)
	{	
		$button = '
				<td>
					<form method="post" action="#">
						<input type="submit" name="' . $sNameButton . '" value="' . $sValueButton . '" />
						<input type="hidden" name="id" value="' . $oUser->getId() . '" />
						<input type="hidden" name="mail" value="' . $oUser->getMail() . '" />
					</form>
				</td>
				<script>
					var asideButtons = document.getElementsByClassName("btn btn-outline-secondary btn-block");
					asideButtons[' . $nIdButton . '].id= "active-button-aside";
				</script>';

		return $button;
	}


	// Code HTML pour la page d'ajout d'adhérent
	function addMember()
	{
		$page = '<h1>Formulaire d\'ajout de membre</h1>';
		$page .= addForm('Valider');
	
		// Code JavaScript pour les boutons de l'aside
		$page .= '
				<script>
					var asideButtons = document.getElementsByClassName("btn btn-outline-secondary btn-block");
					asideButtons[2].id= "active-button-aside";
				</script>';

		// Si le bouton Valider est pressé
		if (isset($_POST['button'])) {
			if ($_POST['button'] == 'Valider') {
				$page .= addUsersButton();
			}	
		}

		return $page;
	}
	
	

	// Code HTML pour la page de modification d'adhérent
	function updateMemberPage()
	{
		$page = '<h1>Formulaire de modification de membre</h1>';
			$page .= addForm('Modifier');
			$page .= '
					<script>
						var asideButtons = document.getElementsByClassName("list-group-item list-group-item-action bg-light");
						asideButtons[3].id= "active";
					</script>';
	
			return $page;
	
	}


	// Code HTML pour la construction du formulaire d'ajout
	function addForm($sButtonValue)
	{
		$adherent = new Adherent();
	
		if (isset($_POST['mail'])) {
			$adherent->setMail($_POST['mail']);
			$adherent->readAdherentByMail();
		}

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
					<input class="user-input" type="submit" name="button" value="' . $sButtonValue . '" />
					<input type="hidden" name="emailTemp" value="' .  $adherent->getMail() . '" />
					<input type="hidden" name="idTemp" value="' .  $adherent->getId() . '" />
					<input type="hidden" name="test" value="1" />';

		if (isset($_POST['button'])) {
			buttonProcess($adherent);
		}

		$form.= '	
				</div>
			</form>';

		if (isset($_SESSION['button_page'])) {
			if ($_SESSION['button_page'] == 'Modifier') {
				$form .= '
					<form action="#" method="post">
						<input class="user-input" type="submit" name="page_button" value="Retour" />
					</form>';
			}	
		}	

		return $form;
	}

<?php
	/** Liste des fonctions pour gérer les pages HTML en fonction de là où est l'utilisateur 
	*	menuButton($nStatut) ---------------> Code HTML pour les trois boutons du menu
	*	displayConnectionPage() ------------> Code HTML pour la page de connexion
	*	displayReservationsPage() ----------> Code HTML pour la page des réservations
	*	displayUsersPage() -----------------> Code HTML pour la page des utilisateurs
	*	asideMembers() ---------------------> Code HTML pour l'aside quand on est sur la page des adhérents
	*	membersList() ----------------------> Code HTML pour la liste des membres en fonction de la page
	*	tablePattern($aData) ---------------> Code pour afficher un tableau contentant des données d'utilisateurs
	*	displayButtons($nIdButton, $sNameButton, $nIdAdherent, $sMailAdherent) 
										   -> Code HTML pour certain boutons de l'aside
	*	sendMail($aUser) -------------------> Code affichant le texte après
	*	addMember() ------------------------> Code HTML pour la page d'ajout d'adhérent
	*	updateMemberPage() -----------------> Code HTML pour la page de modification d'adhérent
	*	addForm() --------------------------> Code HTML pour la construction du formulaire d'ajout
	**/


	// Code HTML pour les trois boutons du menu 
	function menuButton()
	{
		if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) {
			if (isset($_POST['button']) && $_POST['button'] == 'Déconnexion') {
				buttonProcess(null);
				$nav = '<center><h3>Vous avez été déconnecté.</h3></center>';
			} else {


				$nav = ' 
				<!-- Page Content -->
	
				    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
				    	<button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
				    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 	aria-expanded="false" aria-label="Toggle navigation">
				          <span class="navbar-toggler-icon"></span>
				   		</button>
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
						if ($_SESSION['status'] == 'PRESIDENT') {
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
			}
		return $nav;
		}   
	}


	// Code HTML pour la page de connexion
	function displayConnectionPage()
	{
		if (!isset($_SESSION['connect']) || $_SESSION['connect'] === 0) {
			$page = '
			<center>
				<h1>Veuillez-vous connecter</h1><br />';

				if (isset($_POST['button'])) {
					$page .= buttonProcess(null);
				}
			
			$page .= '
				<form method="post" action="#">
					<label class="user-label" for="email">Adresse mail</label><br />
					<input type="email" class="btn-custom" name="email" placeholder="Adresse mail" minlength="6" maxlength="75" size="40" onblur="verifInputText(this)" required /><br />
					<label class="user-label" for="password">Mot de passe</label><br />
					<input type="password" class="btn-custom" name="password" placeholder="Mot de passe" size="40" required /><br /><br />
					<input class="btn btn-outline-primary btn-lg" type="submit" name="button" value="Se connecter" />
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
			<h1>Liste des soirées</h1>
			<div id="section"></div>
			';

		// Code JavaScript pour les boutons et l'aside
		$page .= '
			<script>
				var menuButtons = document.getElementsByClassName("btn btn-outline-primary btn-lg");
				var toggleButton  = document.getElementById("menu-toggle");
				menuButtons[0].id= "active-button-menu";
				toggleButton.setAttribute("disabled","disabled");
    			var section = document.querySelector("#section");
    			var requestUrl = "../zumba-intranet/log.json";
    			var request = new XMLHttpRequest();
    			request.open("GET", requestUrl);
   				request.responseType = "json";
    			request.send();
    			request.onload = function()
    			{
      				var listeSoirees = request.response;
     	 			dataProcessing(listeSoirees);
    			}

    			function dataProcessing(jsonObj)
    			{
    				var soiree = jsonObj["soiree"];
      				for (var i = 0 ; i < soiree.length ; i++) {
      					var myH2 = document.createElement("h2");
      					myH2.textContent = soiree[i]["title"];
      					var myH4 = document.createElement("h4");
      					myH4.textContent = "Le " + soiree[i]["date_evenement"];
      					var myPara = document.createElement("p");
      					myPara.textContent = soiree[i]["content"];
      					section.appendChild(myH2);
      					section.appendChild(myH4);
      					section.appendChild(myPara);
				      	showMembers(jsonObj["soiree"][i]);
      				}
    			}

    			function showMembers(jsonObj)
    			{
    				var soiree = jsonObj;
        			var myArticle = document.createElement("article");
        			var myH5 = document.createElement("h5");
        			var myList = document.createElement("ul");
        			myH5.textContent = soiree["reservations_evenement"].length + " personne(s) ayant réservées";
        			myArticle.appendChild(myH5);
        			var members = soiree["reservations_evenement"];
        				for (var j = 0 ; j < members.length ; j++) {
          					var listItem = document.createElement("li");
          					listItem.textContent = members[j];
          					myList.appendChild(listItem);
     					}
        			myArticle.appendChild(myList);
        			section.appendChild(myArticle);
				}
    		</script>';

		return $page;
	}
	
	// Code HTML pour la page des des utilisateurs
	function displayUsersPage()
	{
		// Page des utilisateurs
		$page = '<center><h3>Formulaire d\'ajout d\'utilisateur</h3></center>';

		// Si le bouton Valider est pressé
		if (isset($_POST['button'])) {
			if ($_POST['button'] == 'Créer') {
				$page .= addUsersButton();
				$page .= '<center><h3>Utilisateur ajouté</h3></center>';
			}	
		}

		$page .= '
			<form action="#" method="post" onsubmit="return verifAllForm()">
				<center>
					<div class="user-div">
						<label class="user-label" for="lastname"><b>Nom de famille</b></label><br />
						<input type="text" class="btn-custom" name="lastname" placeholder="Nom" minlength="2" maxlength="18" onblur="verifInputText(this)" required 	/><br />
						<p class="hidden" name="lastname"></p>
						<label class="user-label" for="name"><b>Prénom</b></label><br />				
						<input type="text" class="btn-custom" name="name" placeholder="Prénom" minlength="2" maxlength="18" onblur="verifInputText(this)" required />
						<p class="hidden" name="name"></p>
					</div>				
					<div class="user-div">
						<label class="user-label" for="mail"><b>Email</b></label><br />
						<input type="email" class="btn-custom" name="email" placeholder="Adresse mail" minlength="6" maxlength="75"  onblur="verifInputText(this)" 	required /><br />
						<p class="hidden" name="email"></p>
						<label class="user-label" for="phone"><b>Téléphone</b></label><br />				
						<input type="text" class="btn-custom" name="phone" placeholder="Téléphone" minlength="10" maxlength="10"  onblur="verifInputText(this)" required 	/>
						<p class="hidden" name="phone"></p>
					</div>
					<div>
						<select class="btn-custom" name="status" onchange="verifInputText(this)">
							<option value=0>--Choississez un rôle--</option>
							<option value=3>Secrétaire</option>
							<option value=4>Professeur</option>
							<option value=5>Président</option>
						</select>
						<p class="hidden" name="status"></p>
					</div>
					<div>
						<input class="btn btn-outline-primary btn-lg" type="submit" name="button" value="Créer" />
					</div>
				</center>
			</form>';

		// Code JavaScript pour les boutons et l'aside
		$page .= '
			<script>
				var menuButtons = document.getElementsByClassName("btn btn-outline-primary btn-lg");
				var toggleButton  = document.getElementById("menu-toggle");
				menuButtons[2].id= "active-button-menu";
				toggleButton.setAttribute("disabled","disabled");
			</script>';


		

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
			      		<div class="list-group list-group-flush">
			        		<form class="aside-form" method="post" action="#">
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Voir les adhérents" />' .
								$input . '
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Ajouter un adhérent" />
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Modifier un adhérent" />
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Supprimer un adhérent" />
								<input type="submit" class="btn btn-outline-secondary btn-block" name="page_button" value="Mot de passe en attente" /><br />
			   						<input class="btn btn-outline-secondary btn-block" type="submit" name="button" value="Déconnexion" />
							</form>
			      		</div>
			    	</div>
			   		<!-- /#sidebar-wrapper -->';

		return $aside;		
		}
	}

	// Code HTML pour la liste des membres en fonction de la page
	function membersList()
	{	

		// Récupération des données de la base en fonction de la page
		if ($_SESSION['page'] == 'Voir les adhérents') {
			$page = '<h1>Liste des membres</h1>';
			$data = getMembers();
		} else if ($_SESSION['page'] == 'Modifier un adhérent' || $_SESSION['page'] == 'Supprimer un adhérent') {
			$page = '<h1>Liste des membres</h1>';
			$data = getData();
		} else if ($_SESSION['page'] == 'Pré-inscription (' . numberOfPreRegistered() . ')') {
			$page = '<center><h3>Pré-inscriptions en attente</h3></center>';
			$data = getPreRegistered();
		} else if ($_SESSION['page'] == 'Mot de passe en attente') {
			$page = '<h1>Adhérents en attante de mot de passe</h1>';
			$data = getPasswordEmpty();
		}

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

	// Code affichant le texte après clique sur le bouton d'envoi de mail en attendant d'un réel envoie
	function sendMail($aUser)
	{
		$text = '<h3>Un mail est envoyé à "' . $aUser['mail_adherent'] . '" pour qu\'il puisse changer son mot 	de passe</h3>';
		// Les lignes suivantes sont pour le test en local
		$adherent = new Adherent();
		$adherent = arrayToObject($aUser);
		$adherent->setMail('');
		$adherent->updatePassword();
		header ("Refresh: 3;URL=/zumba-intranet/pass-form.php");

	
		return $text;
	}
	
	// Code HTML pour la page d'ajout d'adhérent
	function addMember()
	{
		$page = '<center><h3>Formulaire d\'ajout de membre</h3></center>';
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
		$page = '<center><h3>Formulaire de modification de membre</h3></center>';
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
		$form = '<br />';
		$adherent = new Adherent();
	
		if (isset($_POST['mail'])) {
			$adherent->setMail($_POST['mail']);
			$adherent->readAdherentByMail();
		}
		if (isset($_POST['button'])) {
				$form = buttonProcess($adherent);
		} else {
			$form .= '
			<center>
				<form action="#" method="post" onsubmit="return verifAllForm()">
					<div class="add-user-div">
						<label class="user-label" for="lastname">Nom de famille</label><br />
						<input type="text" class="btn-custom" name="lastname" value="'. $adherent->getNom() .'" placeholder="Nom" minlength="2" maxlength="18" 	onblur="verifInputText(this)" required /><br />
						<p class="hidden" name="lastname"></p>
						<label class="user-label" for="name">Prénom</label><br />				
						<input type="text" class="btn-custom" name="name" value="'. $adherent->getPrenom() .'" placeholder="Prénom" minlength="2" maxlength="18" 	onblur="verifInputText(this)" required />
						<p class="hidden" name="name"></p>
					</div>
					<div class="add-user-div">
						<label class="user-label" for="address">Adresse</label><br />
						<input type="text" class="btn-custom" name="address" value="'. $adherent->getAdresse() .'" placeholder="Adresse" minlength="6" maxlength="248"  	onblur="verifInputText(this)" required /><br />
						<p class="hidden" name="address"></p>					
						<label class="user-label" for="cp">Code Postal</label><br />
						<input type="text" class="btn-custom" name="cp" value="'. $adherent->getCp() .'" placeholder="Code Postal" minlength="5" maxlength="5"  	onblur="verifInputText(this)" required />
						<p class="hidden" name="cp"></p>					
						<label class="user-label" for="city">Ville</label><br />
						<input type="text" class="btn-custom" name="city" value="'. $adherent->getVille() .'" placeholder="Ville" minlength="4" maxlength="75"  	onblur="verifInputText(this)" required />
						<p class="hidden" name="city"></p>					
					</div>
					<div class="add-user-div">
						<label class="user-label" for="mail">Email</label><br />
						<input type="email" class="btn-custom" name="email" value="'. $adherent->getMail() .'" placeholder="Adresse mail" minlength="6" maxlength="75"  	onblur="verifInputText(this)" required /><br />
						<p class="hidden" name="email"></p>					
						<label class="user-label" for="phone">Téléphone</label><br />				
						<input type="text" class="btn-custom" name="phone" value="'. $adherent->getTel() .'" placeholder="Téléphone" minlength="10" maxlength="10"  	onblur="verifInputText(this)" required />
						<p class="hidden" name="phone"></p>					
					</div>
					<div>
						<input class="btn btn-outline-primary btn-lg" type="submit" name="button" value="' . $sButtonValue . '" />
						<input type="hidden" name="emailTemp" value="' .  $adherent->getMail() . '" />
						<input type="hidden" name="idTemp" value="' .  $adherent->getId() . '" />
						<input type="hidden" name="test" value="1" />';
	
	
			$form .= '	
					</div>
				</form>';
	
			if (isset($_SESSION['button_page'])) {
				if ($_SESSION['button_page'] == 'Modifier') {
					$form .= '
						<form action="#" method="post">
							<input class="btn btn-outline-primary btn-lg" type="submit" name="page_button" value="Retour" />
						</form>';
				}	
			}	
	
			$form .= '</center>';
		}
		return $form;
	}

<?php
	/** Liste des fonctions du fichier controller.php
	*	switchPages($nStatut)---------> Récupère la variable $_POST et la traite
	*	display() --------------------> Affiche la page correspondante ainsi que les boutons
	*	buttonSwitch($aUser) ---------> Gère les différents boutons des tableaux
	*	buttonProcess($aUser) --------> Gère les fonctions des boutons des tableaux
	*	addUsersButton() -------------> Gère les formulaires d'ajout de adhérents ou d'utilisateurs
	*	validPreRegistration($aUser) -> Gère la validation d'un pré-inscription
	*	updateMemberButton() ---------> Gère la modification de membres
	*	deleteMember($aUser) ---------> Gère la suppression de membres
	*	getData() --------------------> Récupère toutes les données pour les tableaux
	*	getMembers() -----------------> Retourne un tableau contenant les adhérents inscrits
	*	getPreRegistered() -----------> Retourne un tableau contenant les adhérents pré-inscrits
	*	numberOfPreRegistered() ------> Retourne le nombre de pré-inscrit
	*	getCurrentDateTime() ---------> Retourne la date et l'heure actuelle selon notre format et notre fuseau
	*	newFormatDate($sDate) --------> Retourne une date données dans notre format
	*	arrayToObject($aArray) -------> Convertit un tableau de données Adherent en objet Adherent
	*	createPass($oUser) -----------> Gère les données avant de créer un mot de passe
	*	connectProcess() -------------> Gestion de la connexion
	*	disconnectProcess() ----------> Gestion de la déconnexion
	**/

	// Pages principales
	function switchPages()
	{
		$section = '';

		if (!isset($_SESSION['connect']) || $_SESSION['connect'] == 0) {
			$_SESSION['page'] = 'Connexion';
		} else if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) {
			if (isset($_POST['page_button'])) {
				switch ($_POST['page_button']) {
					case 'Utilisateurs':
						if ($_SESSION['status'] == 'PRESIDENT') {
   							$_SESSION['page'] = 'Utilisateurs';
						}
						break;
	
					case 'Adhérents':
					case 'Voir les adhérents':
   						$_SESSION['page'] = 'Voir les adhérents';
   						$_SESSION['button_page'] = 'Envoyer un mail';
						break;
					
					case 'Réservations':
   						$_SESSION['page'] = 'Réversations';
						break;
	
					case 'Pré-inscription (' . numberOfPreRegistered() . ')':
						$_SESSION['page'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
						$_SESSION['button_page'] = 'Valider l\'inscription';
						break;
	
					case 'Ajouter un adhérent':
						$_SESSION['page'] = 'Ajouter un adhérent';
						$_SESSION['button_page'] = 'Valider';
						break;
	
					case 'Modifier un adhérent':
					case 'Retour':
						$_SESSION['page'] = 'Modifier un adhérent';
						$_SESSION['button_page'] = 'Modifier';
						break;
						
					case 'Modifier':
						$_SESSION['page'] = 'Formulaire de modification';
						$_SESSION['button_page'] = 'Modifier';
						break;
						
					case 'Supprimer un adhérent':
						$_SESSION['page'] = 'Supprimer un adhérent';
						$_SESSION['button_page'] = 'Supprimer';
						break;
						
					case 'Mot de passe en attente':
						$_SESSION['page'] = 'Mot de passe en attente';
						$_SESSION['button_page'] = 'Envoyer un mail';
						break;
						
					default:
   						$_SESSION['page'] = 'Réversations';
						break;
						
				}
			}
		}

		$section = display();

		return $section;
	}

	// Affiche la page correspondante
	function display()
	{
		if (isset($_SESSION['page'])) {
			switch ($_SESSION['page']) {
				case 'Connexion':
					$section = displayConnectionPage();
					break;
				
				case 'Utilisateurs':
					$section = displayUsersPage();
					break;
				
				case 'Voir les adhérents':
				case 'Pré-inscription (' . numberOfPreRegistered() . ')':
				case 'Modifier un adhérent':
				case 'Supprimer un adhérent':
				case 'Mot de passe en attente':
					$section = membersList();		
					break;
				
				case 'Réversations':
					$section = displayReservationsPage();	
					break;

				case 'Ajouter un adhérent':
					$section = addMember();
					break;
					
				case 'Formulaire de modification':
					$section = addForm("Modifier");
					break;
					
				default:
					$section = displayReservationsPage();	
					break;
			}
		} else {
			$section = displayConnectionPage();
		}

		return $section;
	}

	// Gère les différents boutons des tableaux
	function buttonSwitch($aUser)
	{
		$adherent = arrayToObject($aUser);

		switch ($_SESSION['button_page']) {
			case 'Envoyer un mail':
				$name_button = 'button';
				$value_button = $_SESSION['button_page'];
				if ((isset($_POST['page_button']) && $_POST['page_button'] == 'Voir les adhérents') || $_SESSION['page'] == 'Voir les adhérents') {
					$id_button = 0;
				} else {
					$id_button = 5;
				}
				break;
			
			case 'Valider l\'inscription':
				$name_button = 'button';
				$value_button = $_SESSION['button_page'];
				$id_button = 1;
				break;
			
			case 'Modifier':
				$name_button = 'page_button';
				$value_button = $_SESSION['button_page'];
				$id_button = 3;
				break;
			
			case 'Supprimer':
				$name_button = 'button';
				$value_button = $_SESSION['button_page'];
				$id_button = 4;
				break;
			
			default:
				$name_button = 'button';
				$value_button = $_SESSION['button_page'];
				$id_button = 0;
				break;
		}

		$button = displayButtons($id_button, $name_button, $value_button, $adherent);

		return $button;
	}


	// Gère les fonctions des boutons des tableaux
	function buttonProcess($aUser)
	{	
		if (isset($_POST['button'])) {
			switch ($_POST['button']) {
				case 'Se connecter':
					$page = connectProcess();
					break;
				
				case 'Déconnexion':
					$page = disconnectProcess();
					break;
				
				case 'Envoyer un mail':
					$page = sendMail($aUser);
					break;
				
				case 'Valider l\'inscription':
					$page = validPreRegistration($aUser);
					break;
				
				case 'Valider':
				case 'Créer':
					$page = addUsersButton();
					break;
				
				case 'Modifier':
					$page = updateMemberButton();
					break;
				
				case 'Supprimer':
					$page = deleteMember($aUser);
				break;
				
				case 'Valider le mot de passe':
					$page = createPass($aUser);
				break;
				
				default:
					$page = '<h1>Un problème est survenu</h1>';
					break;
			}
		}

		return $page;
	}


	// Gère les formulaires d'ajout de adhérents ou d'utilisateurs
	function addUsersButton()
	{
		$page = '';
		$post = '';
		$exist = null;


		if (isset($_POST['button'])) {
			if ($_POST['button'] == 'Créer') {
				$post = 'user';
			} else if ($_POST['button'] == 'Valider') {
				$post = 'member';
			}
		}

		if ($post != '') {
			$newAdherent = new Adherent();

			$newAdherent->setMail(strtolower($_POST['email']));
			$exist = $newAdherent->freeMail();

			if ($exist === null) {
				$newAdherent->setNom($_POST['lastname']);
				$newAdherent->setPrenom($_POST['name']);
				$newAdherent->setMail(strtolower($_POST['email']));
				$newAdherent->setTel($_POST['phone']);
				$newAdherent->setDate(getCurrentDateTime());

				if ($post == 'user') {
					$newAdherent->setStatut(intval($_POST['status']));
					$_SESSION['page'] = 'Voir les adhérents';
				}

				if ($post == 'member') {
					$newAdherent->setAdresse($_POST['address']);
					$newAdherent->setCp($_POST['cp']);
					$newAdherent->setVille($_POST['city']);
					$count = numberOfPreRegistered() + 1;
					$_SESSION['page'] = 'Pré-inscription (' . $count . ')';
				}
				$newAdherent->createUser();
				$page .= '<center><h3>Un nouvel adhérent a été créé</h3></center>';
			} else {
				header ("Refresh: 3");
			}
		}
		return $page;
	}
		
	// Gère la validation d'un pré-inscription
	function validPreRegistration($aUser)
	{
		$adherent = new Adherent();
		$id = intval($aUser['id_adherent'], 10);
		$adherent->updateStatus($id, INSCRIT);
		$_SESSION['page'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
	}

	// Gère la modification de membres
	function updateMemberButton()
	{
		$page = '<center>';
		$exist = null;
		if (isset($_POST['button'])) {
			if ($_POST['button'] == 'Modifier') {
				$currentAdherent  = new Adherent();
				// Si l'email est différent
				if (strtolower($_POST['email']) != strtolower($_POST['emailTemp'])) {
					$currentAdherent->setMail(strtolower($_POST['email']));
					$exist = $currentAdherent->freeMail();
					// Si l'email existe dans la base de données $exist sera différent de null
					if ($exist !== null) {
						$page .= '<h3>Ce mail existe déjà dans la base. L\'id de l\'inscrit est ' . $exist . '</h3>.';
						$_SESSION['page'] = 'Modifier un adhérent';
						header ("Refresh: 3");
					}
				} 	
				// Si l'email n'existe pas ou que l'email reste la même
				if ($exist === null) {
					$currentAdherent->setNom($_POST['lastname']);
					$currentAdherent->setPrenom($_POST['name']);
					$currentAdherent->setAdresse($_POST['address']);
					$currentAdherent->setCp($_POST['cp']);
					$currentAdherent->setVille($_POST['city']);
					$currentAdherent->setMail(strtolower($_POST['email']));
					$currentAdherent->setTel($_POST['phone']);
					$page .= '<h3>Mise à jour effectuée</h3>';
					$currentAdherent->updateUser($_POST['idTemp']);
					$_SESSION['page'] = 'Modifier un adhérent';
					header ("Refresh: 3");
				}
			}
		}

		$page .= '</center>';


		return $page;
	}

	// Gère la suppression de membres
	function deleteMember($aUser)
	{
		$adherent = new Adherent();

		$adherent->setId($aUser['id_adherent']);
		$page = '<h3>L\'utilisateur n°' . $aUser['id_adherent'] . ' => ' . $aUser['nom_adherent'] . ' ' . $aUser['prenom_adherent'] . ' a bien été supprimé.</h3>';
		
		$adherent->deleteMember();

		return $page;
	}


	// Retourne toutes les données pour les tableaux
	function getData()
	{
		$aAdherent = array();
		$adherent = new Adherent();
		$aAdherent = $adherent->getAllAdherents();
		$count = count($aAdherent);
		
		// Récupère les statuts
		for ( $i = 0; $i < $count; $i++ ) {
          $aAdherent[$i] += ['statut_adherent' => $adherent->readStatus($aAdherent[$i]['id_adherent'])];
    	}

		return $aAdherent;
	}

	// Retourne un tableau contenant les adhérents inscrits
	function getMembers()
	{
		$data = getData();
		$listMembers = array();

		foreach ($data as $value) {
			if ($value['statut_adherent'] != 'PRE_INSCRIT') {
				array_push($listMembers, $value);
			}
		}

		return $listMembers;
	}

	// Retourne un tableau contenant les adhérents pré-inscrits
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

	// Retourne un tableau contenant les adhérents pré-inscrits
	function getPasswordEmpty()
	{
		$data = getData();
		$listPasswordEmpty = array();

		foreach ($data as $value) {
			if ($value['mdp_adherent'] === null) {
				array_push($listPasswordEmpty, $value);
			}
		}

		return $listPasswordEmpty;
	}

	// Retourne le nombre de pré-inscrit
	function numberOfPreRegistered()
	{
		$data = getPreRegistered();
		return count($data);
	}
	
	// Retourne la date et l'heure actuelle selon notre format et notre fuseau
	function getCurrentDateTime()
	{
		date_default_timezone_set('Europe/Paris');
		$date = date("d-m-Y H:i");

		return $date;
	}

	// Retourne une date données dans notre format
	function newFormatDate($sDate)
	{
		if ($sDate != null) {
			$dt = DateTime::createFromFormat('Y-m-d H:i:s', $sDate);		
			return $dt->format('j-m-Y H:i:s');
		}
	}

	// Convertit un tableau de données Adherent en objet Adherent
	function arrayToObject($aArray)
	{
		$object = new Adherent();
		$object->setId($aArray['id_adherent']);
		$object->setNom($aArray['nom_adherent']);
		$object->setPrenom($aArray['prenom_adherent']);
		$object->setAdresse($aArray['adresse_adherent']);
		$object->setCp($aArray['cp_adherent']);
		$object->setVille($aArray['ville_adherent']);
		$object->setTel($aArray['tel_adherent']);
		$object->setMail($aArray['mail_adherent']);
		$object->setPhoto($aArray['photo_adherent']);
		$object->setDate(newFormatDate($aArray['date_adherent']));

		return $object;
	}

	// Gère les données avant de créer un mot de passe
	function createPass($oUser)
	{
		$oUser->setPass(password_hash($oUser->getPass(), PASSWORD_DEFAULT));
		$oUser->updatePassword();	
		$_SESSION['page'] = 'Connexion';
		header ("Refresh: 3;URL=index.php");
	}

	// Gestion de la connexion
	function connectProcess()
	{
		$adherent = new Adherent();
					
		$adherent->setMail($_POST['email']);
		$adherent->readAdherentByMail();
		// Si le nom est présent dans la BDD et que le mot de passe n'est pas vide
		if ($adherent->getNom() !== null && $adherent->getPass() !== null) {
			$adherent->setStatut($adherent->readStatus(intval($adherent->getId())));
			// Si l'utilisateur a le bon statut
			if ($adherent->getStatut() === 'PRESIDENT' || $adherent->getStatut() === 'SECRETAIRE') {
				if (password_verify($_POST['password'], $adherent->getPass())) {
					$page = '<h3>Vous êtes connecté.</h3>';
					$_SESSION['connect'] = 1;
					$_SESSION['status'] = $adherent->getStatut();
				} else {
					$page = '<h3>Erreur de connexion.</h3>';
				}
			} else {
				$page = '<h3>Vous n\'avez pas accès à l\'intranet</h3>';
			}
		} else {
		$page = '<h3>Cette utilisateur n\'existe pas</h3>';
		}
		header("Refresh: 3;URL=index.php");

		return $page;
	}

	// Gestion de la déconnexion
	function disconnectProcess()
	{
		unset($_POST);
		unset($_SESSION);

		session_destroy();
		header ("Refresh: 3");
	}




	

	
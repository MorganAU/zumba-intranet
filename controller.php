<?php

	define('PRE_INSCRIT', 1);
	define('INSCRIT', 2);
	define('PROFESSEUR', 3);
	define('SECRETAIRE', 4);
	define('PRESIDENT', 5);

	$debug_statut = PRESIDENT;
	
	/**
	*
	*	Gestion des pages
	*
	*
	**/

	// Pages principales
	function switchPages($nStatut)
	{
		$section = '';


		if (!isset($_SESSION['connect']) || $_SESSION['connect'] == 0) {
			$_SESSION['page'] = 'Connexion';
			$_SESSION['button_page'] = 'Se connecter';
		} else if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) {
			if (isset($_POST['page_button'])) {
				switch ($_POST['page_button']) {
					case 'Utilisateurs':
						if ($nStatut == PRESIDENT) {
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
					case 'Retour':
						$_SESSION['page'] = 'Formulaire de modification';
						$_SESSION['button_page'] = 'Modifier';
						break;
						
					case 'Supprimer un adhérent':
						$_SESSION['page'] = 'Supprimer un adhérent';
						$_SESSION['button_page'] = 'Supprimer';
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
					$section = membersList();		
					break;
				
				case 'Réversations':
					$section = displayReservationsPage();	
					break;

				case 'Pré-inscription (' . numberOfPreRegistered() . ')':
					$section = preRegistrationList();
					break;
				
				case 'Ajouter un adhérent':
					$section = addMember();
					break;

				case 'Modifier un adhérent':
					$section = membersList();
					break;
					
				case 'Formulaire de modification':
					$section = addForm("Modifier");
					break;
					
				case 'Supprimer un adhérent':
					$section = membersList();
					break;
					
				default:
					$section = displayReservationsPage();	
					break;
			}

		}

		return $section;
	}



	function buttonSwitch($aUser)
	{
		$adherent = arrayToObject($aUser);

		switch ($_SESSION['button_page']) {
			case 'Envoyer un mail':
				$name_button = 'button';
				$value_button = $_SESSION['button_page'];
				$id_button = 0;
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


	// Gère les boutons des tableaux et leur fonction
	function buttonProcess($aUser)
	{	
		if (isset($_POST['button'])) {
			switch ($_POST['button']) {
	
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
				
				default:
					$page = '<h1>Un problème est survenu</h1>';
					break;
			}
		}

		if (isset($_SESSION['button'])) {
			switch ($_SESSION['button']) {
				case 'Envoyer un mail':
					$page = sendMail($aUser);
					break;

			}
		}
		return $page;
	}



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
					$page = '<h3>L\'utilisateur a bien été créé. Pensez à lui envoyer un mail pour son mot de passe.</h3>';
					$_SESSION['page'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
					$_SESSION['button'] = 'Valider l\'inscription';
				}

				if ($post == 'member') {
					$newAdherent->setAdresse($_POST['address']);
					$newAdherent->setCp($_POST['cp']);
					$newAdherent->setVille($_POST['city']);

					$page = '<h3>L\'adhérent a bien été pré-inscrit. Veuillez valider l\'inscritpion.<h3>';
				}
				$newAdherent->createUser();
				$_SESSION['page'] = 'Voir les adhérents';
			} else {
				$page = '<h3>Ce mail existe déjà dans la base. L\'id de l\'inscrit est ' . $exist . '.<h3>';
				header ("Refresh: 3;URL=" . $_SERVER['PHP_SELF']);

			}
		
		}
		return $page;
	}
		
	
	
	function validPreRegistration($aUser)
	{
		$adherent = new Adherent();
		$int = intval($aUser['id_adherent'], 10);
		$adherent->updateStatus($int, INSCRIT);
		$_SESSION['page'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
	
	
	}

	/*function updateMemberSwitchPage()
	{
		$page = '';
		$test = 0;
		if (isset($_POST['test'])) {
			$test = $_POST['test'];
		}

		if (isset($_POST['button'])) {
			if ($_POST['button'] == "Modifier" && $test == '0') {
				$page = updateMemberPage();
			} else if ($_POST['button'] == "Modifier" && $test == '1') {
				$page = updateMemberButton();
			} else {
				$page = membersList();
			}
		} else {
			$page = membersList();
		}

		return $page;
	}
*/


	function updateMemberButton()
	{
		$page = '';
		$exist = null;
		if (isset($_POST['button'])) {
			if ($_POST['button'] == 'Modifier') {
				$currentAdherent  = new Adherent();

				if (strtolower($_POST['email']) != strtolower($_POST['emailTemp'])) {
					$currentAdherent->setMail(strtolower($_POST['email']));
					$exist = $currentAdherent->freeMail();
					
					if ($exist !== null) {
						$page = '<h3>Ce mail existe déjà dans la base. L\'id de l\'inscrit est ' . $exist . '</h3>.';
						$_SESSION['page'] = 'Modifier un adhérent';
						header ("Refresh: 0;URL=" . $_SERVER['PHP_SELF']);
					}
				} 	

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
					header ("Refresh: 0;URL=" . $_SERVER['PHP_SELF']);

				}
			}
		}
		return $page;
	
	}




	function deleteMember($aUser) {
		$adherent = new Adherent();

		$adherent->setId($aUser['id_adherent']);
		$page = '<h3>L\'utilisateur n°' . $aUser['id_adherent'] . ' => ' . $aUser['nom_adherent'] . ' ' . $aUser['prenom_adherent'] . ' a bien été supprimé.</h3>';
		$adherent->deleteStatus();
		$adherent->deleteMember();

		return $page;
	}



	function getData()
	{
		$aAdherent = array();
		$adherent = new Adherent();
		$aAdherent = $adherent->getAllAdherents();
		$count = count($aAdherent);
	
		for ( $i = 0; $i < $count; $i++ ) {
          $aAdherent[$i] += ['statut_adherent' => $adherent->readStatus($aAdherent[$i]['id_adherent'])];
    	}

		return $aAdherent;
	}


	function getCurrentDateTime()
	{
		date_default_timezone_set('Europe/Paris');
		$date = date("d-m-Y H:i");

		return $date;
	}



	



	function newFormatDate($sDate)
	{
		if ($sDate != null) {
			$dt = DateTime::createFromFormat('Y-m-d H:i:s', $sDate);		
			return $dt->format('j-m-Y H:i:s');
		}

	}



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
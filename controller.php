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
	function display($nStatut)
	{
		$section = '';

		if (isset($_POST['menu_button'])) {
   				if ($_POST['menu_button'] == 'Utilisateurs' && $nStatut == PRESIDENT) {
   					$_SESSION['page'] = 'Utilisateurs';
   				} else if ($_POST['menu_button'] == 'Adhérents') {
   					$_SESSION['page'] = 'Adhérents';
   					$_SESSION['aside_buttons'] = 'Voir les adhérents';
   					$_SESSION['button_page'] = 'Envoyer un mail';
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


	// Boutons de l'aside
	function aside_user_button_switch()
	{

			if (isset($_POST['aside_buttons'])) {
				switch ($_POST['aside_buttons']) {
					case 'Voir les adhérents':
						$_SESSION['aside_buttons'] = 'Voir les adhérents';
						break;
	
					case 'Pré-inscription (' . numberOfPreRegistered() . ')':
						$_SESSION['aside_buttons'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
						break;
					
					case 'Ajouter un adhérent':
						$_SESSION['aside_buttons'] = 'Ajouter un adhérent';
						break;
					
					case 'Modifier un adhérent':
					case 'Retour':
						$_SESSION['aside_buttons'] = 'Modifier un adhérent';
						break;
					
					case 'Supprimer un adhérent':
						$_SESSION['aside_buttons'] = 'Supprimer un adhérent';
						break;

					default:
						$_SESSION['aside_buttons'] = 'Voir les adhérents';
						break;
				}
			}
			
			if (isset($_SESSION['aside_buttons'])) {
				switch ($_SESSION['aside_buttons']) {
					case 'Voir les adhérents':
						$page = membersList();
						break;
	
					case 'Pré-inscription (' . numberOfPreRegistered() . ')':
						$page = preRegistrationList();
						break;
					
					case 'Ajouter un adhérent':
						$page = addMember();
						break;
					
					case 'Modifier un adhérent':
						$page = updateMemberSwitchPage();
						break;
					
					case 'Supprimer un adhérent':
						$page = membersList();
						break;
					
					default:
						$page = membersList();
						break;
				}
			}


		return $page;
	}


	// Gère les boutons des tableaux et leur finctions
	function buttonProcess($aUser)
	{	
		if (isset($_POST['buttons_form'])) {
			switch ($_POST['buttons_form']) {
				case 'Envoyer un mail':
					$_SESSION['buttons_form'] = 'Envoyer un mail';
					break;
	
				case 'Valider l\'inscription':
					$page = validPreRegistration($aUser);
					unset($_SESSION['buttons_form']);
					break;
				
				case 'Ajouter un adhérent':
					$page = addMember();
					unset($_SESSION['buttons_form']);
					break;
				
				case 'Modifier':
					$page = updateMemberSwitchPage();
					unset($_SESSION['buttons_form']);
					break;
				
				case 'Supprimer':
					$page = deleteMember($aUser);
						unset($_SESSION['buttons_form']);
				break;
				
				default:
					$page = '<h1>Un problème est survenu</h1>';
					break;
			}
		}

		if (isset($_SESSION['buttons_form'])) {
			switch ($_SESSION['buttons_form']) {
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


		if (isset($_POST['add-user-button'])) {
			if ($_POST['add-user-button'] == 'Valider') {
				$post = 'user';
			}
		} else if (isset($_POST['buttons_form'])) {
			if ($_POST['buttons_form'] == 'Valider') {
				$post = 'member';
			}
		}

		if ($post != '') {
			$new  = new Adherent();
			$new  = new Adherent();
			$new->setMail(strtolower($_POST['email']));
			$exist = $new->freeMail();

			if ($exist === null) {
				$new->setNom($_POST['lastname']);
				$new->setPrenom($_POST['name']);
				$new->setMail(strtolower($_POST['email']));
				$new->setTel($_POST['phone']);
				$new->setDate(getCurrentDateTime());

				if ($post == 'user') {
					$new->setStatut(intval($_POST['status']));
					$page = '<h3>L\'utilisateur a bien été créé. Pensez à lui envoyer un mail pour son mot de passe.</h3>';
					$_SESSION['aside_buttons'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
					$_SESSION['buttons_form'] = 'Valider l\'inscription';
				}

				if ($post == 'member') {
					$new->setAdresse($_POST['address']);
					$new->setCp($_POST['cp']);
					$new->setVille($_POST['city']);
					$page = '<h3>L\'adhérent a bien été pré-inscrit. Veuillez valider l\'inscritpion.<h3>';
				}

				$new->createUser();


			} else {
				$page = '<h3>Ce mail existe déjà dans la base. L\'id de l\'inscrit est ' . $exist . '.<h3>';
			}
		
		}
		return $page;
	}
		
	
	
	function validPreRegistration($aUser)
	{
		$adherent = new Adherent();
		$int = intval($aUser['id_adherent'], 10);
		$adherent->updateStatus($int, INSCRIT);
		$_SESSION['aside_buttons'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
	
	
	}

	function updateMemberSwitchPage()
	{
		$page = '';
		$test = 0;
		if (isset($_POST['test'])) {
			$test = $_POST['test'];
		}

		if (isset($_POST['buttons_form'])) {
			if ($_POST['buttons_form'] == "Modifier" && $test == '0') {
				$page = updateMemberPage();
			} else if ($_POST['buttons_form'] == "Modifier" && $test == '1') {
				$page = updateMemberButton();
			} else {
				$page = membersList();
			}
		} else {
			$page = membersList();
		}

		return $page;
	}



	function updateMemberButton()
	{
		$page = '';
		$exist = null;
		if (isset($_POST['buttons_form'])) {
			if ($_POST['buttons_form'] == 'Modifier') {
				$currentAdherent  = new Adherent();

				if (strtolower($_POST['email']) != strtolower($_POST['emailTemp'])) {
					$currentAdherent->setMail(strtolower($_POST['email']));
					$exist = $currentAdherent->freeMail();
					
					if ($exist !== null) {
						$page = 'Ce mail existe déjà dans la base. L\'id de l\'inscrit est ' . $exist . '.';
						header ("Refresh: 3;URL=" . $_SERVER['PHP_SELF']);
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
					$page .= 'L\'utilisateur a bien été mis à jour.';
					$currentAdherent->updateUser($_POST['idTemp']);
				}
			}
		}
		return $page;
	
	}




	function deleteMember($aUser) {
		$adherent = new Adherent();

		$adherent->setId($aUser['id_adherent']);
		$page = '<h3>L\'utilisateur n°' . $aUser['id_adherent'] . ' => ' . $aUser['nom_adherent'] . ' ' . $aUser['prenom_adherent'] . ' a bien été supprimé.</h3>';
		var_dump($page);
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



	function buttonSwitch($aUser)
	{
		if (isset($_POST['aside_buttons'])) {
			switch ($_POST['aside_buttons']) {
				case 'Voir les adhérents':
					$_SESSION['button_page'] = 'Envoyer un mail';
					break;
				
				case 'Pré-inscription (' . numberOfPreRegistered() . ')':
					$_SESSION['button_page'] = 'Valider l\'inscription';
					break;
				
				case 'Modifier un adhérent':
					$_SESSION['button_page'] = 'Modifier';
					break;
				
				case 'Supprimer un adhérent':
					$_SESSION['button_page'] = 'Supprimer';
					break;
				
				default:
					$_SESSION['button_page'] = 'Envoyer un mail';
					break;
			}
		}

		switch ($_SESSION['button_page']) {
			case 'Envoyer un mail':
				$name_button = $_SESSION['button_page'];
				$id_button = 0;
				break;
			
			case 'Valider l\'inscription':
				$name_button = $_SESSION['button_page'];
				$id_button = 1;
				break;
			
			case 'Modifier':
				$name_button = $_SESSION['button_page'];
				$id_button = 3;
				break;
			
			case 'Supprimer':
				$name_button = $_SESSION['button_page'];
				$id_button = 4;
				break;
			
			default:
				$name_button = $_SESSION['button_page'];
				$id_button = 0;
				break;
		}


		$button = displayButtons($id_button, $name_button, $aUser['id_adherent'], $aUser['mail_adherent']);

		return $button;

	}



	function newFormatDate($sDate)
	{
		if ($sDate != null) {
			$dt = DateTime::createFromFormat('Y-m-d H:i:s', $sDate);		
			return $dt->format('j-m-Y H:i:s');
		}

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
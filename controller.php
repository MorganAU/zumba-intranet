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

		if (isset($_POST['valid'])) {
   				if ($_POST['valid'] == 'Utilisateurs' && $nStatut == PRESIDENT) {
   					$_SESSION['page'] = 'Utilisateurs';
   				} else if ($_POST['valid'] == 'Adhérents') {
   					$_SESSION['page'] = 'Adhérents';
   					$_SESSION['aside_valid'] = 'Voir les adhérents';
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
		$page ='';
		if (isset($_POST['aside_valid'])) {
			switch ($_POST['aside_valid']) {
				case 'Voir les adhérents':
					$_SESSION['aside_valid'] = 'Voir les adhérents';
					break;

				case 'Pré-inscription (' . numberOfPreRegistered() . ')':
					$_SESSION['aside_valid'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
					break;
				
				case 'Ajouter un adhérent':
					$_SESSION['aside_valid'] = 'Ajouter un adhérent';
					break;
				
				case 'Modifier un adhérent':
					$_SESSION['aside_valid'] = 'Modifier un adhérent';
					break;
				
				case 'Supprimer un adhérent':


					$_SESSION['aside_valid'] = 'Supprimer un adhérent';
					break;
				
				default:
					$_SESSION['aside_valid'] = 'Voir les adhérents';
					break;
			}
		}
		
		if (isset($_SESSION['aside_valid'])) {
			switch ($_SESSION['aside_valid']) {
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
					$page = membersList();
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
	function buttons_form_process_switch($aUser)
	{
		$page ='';
	
		if (isset($_POST['buttons_form'])) {
			switch ($_POST['buttons_form']) {
				case 'Envoyer un mail':
					$page = sendMail($aUser);
					break;
	
				case 'Valider l\'inscription':
					$page = validPreRegistration($aUser);
					break;
				
				case 'Ajouter un adhérent':
					$page = addMember();
					break;
				
				case 'Modifier un adhérent':
					$page = membersList();
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
	
	
	
	function sendMail($aUser)
	{
		$text = '<h3>Un mail est envoyé à "' . $aUser['mail_adherent'] . '" pour qu\'il puisse changer son mot 	de passe</h3>';
	
		return $text;
	}
	
	
	
	function validPreRegistration($aUser)
	{
		$adherent = new Adherent();
		$int = intval($aUser['id_adherent'], 10);
		$adherent->updatePreRegistrationStatus($int);
		$_SESSION['button_page'] = 'Valider l\'inscription';
		$_SESSION['aside_valid'] = 'Pré-inscription (' . numberOfPreRegistered() . ')';
	
	
	}



	function getData()
	{
		$aAdherent = array();
		$adherent = new Adherent();
		$aAdherent = $adherent->getAllAdherents();
	
		for ( $i = 0; $i < 3; $i++ ) {
          $aAdherent[$i] += ['statut_adherent' => $adherent->readStatus($aAdherent[$i]['id_adherent'])];
    		}

		return $aAdherent;
	}



	function button_switch($aUser)
	{
		if (isset($_POST['aside_valid'])) {
			switch ($_POST['aside_valid']) {
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


		$button = display_buttons($id_button, $name_button, $aUser['id_adherent'], $aUser['mail_adherent']);

		return $button;

	}



	function newFormatDate($sDate)
	{
		$dt = DateTime::createFromFormat('Y-m-d H:i:s', $sDate);
		return $dt->format('j-m-Y H:i:s');
	}



	function addUserButton()
	{
		if (isset($_POST['add-user-button'])) {
			if ($_POST['add-user-button'] == 'Valider') {
				$newAdherent  = new Adherent();

				$newAdherent->setNom($_POST['lastname']);
				$newAdherent->setPrenom($_POST['name']);
				$newAdherent->setAdresse($_POST['address']);
				$newAdherent->setCp($_POST['cp']);
				$newAdherent->setVille($_POST['city']);
				$newAdherent->setMail($_POST['mail']);
				$newAdherent->setTel($_POST['phone']);
			}

			var_dump($newAdherent);
		}
	}
<?php

	define('PRE_INSCRIT', 1);
	define('INSCRIT', 2);
	define('PROFESSEUR', 3);
	define('SECRETAIRE', 4);
	define('PRESIDENT', 5);

	$debug_statut = PRESIDENT;
	

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



	function aside_user_button_switch()
	{
		$page ='';
		if (isset($_POST['aside_valid'])) {
			switch ($_POST['aside_valid']) {
				case 'Voir les adhérents':
					$_SESSION['aside_valid'] = 'Voir les adhérents';
					break;

				case 'Pré-inscription':
					$_SESSION['aside_valid'] = 'Pré-inscription';
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

				case 'Pré-inscription':
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
	$text = '<h3>Un mail est envoyé à "' . $aUser['mail_adherent'] . '" pour qu\'il puisse changer son mot de passe</h3>';

	return $text;
}



function validPreRegistration($aUser)
{
	$adherent = new Adherent();
	$int = intval($aUser['id_adherent'], 10);
	$adherent->updatePreRegistrationStatus($int);
	$_SESSION['button_page'] = 'Valider l\'inscription';


}




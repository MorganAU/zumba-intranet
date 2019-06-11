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

		return $page;
	}








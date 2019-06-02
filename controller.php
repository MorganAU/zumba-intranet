<?php
	include_once 'objets/classe-adherent.php';

	define('PRE_INSCRIT', 1);
	define('INSCRIT', 2);
	define('PROFESSEUR', 3);
	define('SECRETAIRE', 4);
	define('PRESIDENT', 5);

	$debug_statut = PRESIDENT;

	$nav = menuButton($debug_statut);
	/*$aside = asideButton($page);*/
	$section = display($debug_statut);

	function menuButton($nStatut)
	{
		$nav = '';

		if ($nStatut == PRESIDENT) {
		 $nav .= '<div class="nav_button">
		 			<form id="button" name="button" method="post" action="#">
						<input type="submit" name="valid" id="button" name="logout_button" value="Utilisateurs" />
					</form>
				</div>';
		}

		$nav .= '<div class="nav_button">
		 			<form id="button" name="button" method="post" action="#">
						<input type="submit" id="classic_button" name="valid" value="Réservations" />
					</form>
				</div>
				<div class="nav_button">
		 			<form id="button" name="button" method="post" action="#">
						<input type="submit" id="classic_button" name="valid" value="Adhérents" />
					</form>
				</div>';

		return $nav;

	}

	function display($nStatut)
	{
		if (isset($_POST['valid'])) {
   			if ($_POST['valid'] == 'Utilisateurs' && $nStatut == PRESIDENT) {
        		return displayUsersPage();
   			} else if ($_POST['valid'] == 'Adhérents') {
   				return displayMembersPage();
   			} else {
   				return displayReservationsPage();
   			}
		} else {
			return displayReservationsPage();					
		}
	}

	function displayUsersPage()
	{
		return 'La page Utilisateurs';

	}

	function displayMembersPage()
	{
		return 'La page Adhérents';

	}

	function displayReservationsPage()
	{
		return 'La page Réservations';

	}















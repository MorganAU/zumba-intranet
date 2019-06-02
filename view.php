<?php
	include_once 'controller.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Intranet de Zumbambb</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="include/style.css">
</head>
<body>
	<header>Ceci est le header</header>
	<nav>
		<?php 
			echo $nav;
		?>
	</nav>

	<aside>
		<div class="aside_button">	
				<input type="button" id="classic_button" name="logout_button" value="Lister les adhérents" onclick=" button()" />
		</div>
		<div class="aside_button">	
				<input type="button" id="classic_button" name="logout_button" value="Pré-inscription" onclick=" button()" />
		</div>
		<div class="aside_button">	
				<input type="button" id="classic_button" name="logout_button" value="Ajouter un adhérent" onclick=" button()	" />
		</div>
		<div class="aside_button">	
				<input type="button" id="classic_button" name="logout_button" value="Modifier un adhérent" onclick=" button()" />
		</div>
		<div class="aside_button">	
				<input type="button" id="classic_button" name="logout_button" value="Supprimer un adhérent" onclick=" button()" />
		</div>
		<div class="aside_button">	
				<input type="button" id="classic_button" name="logout_button" value="Gestion des mots de passe" onclick=" 	button()" />
		</div>
		<div class="aside_button">	
				<input type="button" id="classic_button" name="logout_button" value="Déconnexion" onclick=" 	button()" />
		</div>
	</aside>
	<section>
		<?php
			if (isset($_POST['valid'])) {
   				if ($_POST['valid'] == 'Utilisateurs' && $debug_statut == PRESIDENT) {
        			echo displayUsersPage();
   				} else if ($_POST['valid'] == 'Adhérents') {
   					echo displayMembersPage();
   				} else {
   					echo displayReservationsPage();
   				}
			} else {
				echo displayReservationsPage();					
			}
		?>
	</section>
	<footer>Ceci est le footer</footer>
</body>
</html>
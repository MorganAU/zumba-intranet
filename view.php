<?php
	include 'controller.php';
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
		<?php echo menuButton(4); ?>
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
	<section>Ceci est la section</section>
	<footer>Ceci est le footer</footer>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>Intranet de Zumbambb</title>
	<meta charset="utf-8">
</head>
<style type="text/css">
	body {
		margin: 0 auto;
		text-align: center;
		min-height: 100%;
		width: 1200px;
	}

	header, aside, footer, section, nav {
		border: solid 1px black;
	}

	header {
		height: 200px;
		background-color: #41DFE8;
	}
	nav {
		margin: 5px auto 5px auto;
		padding: 15px;
		width: 900px;
		background-color: #41DFE8;
	}
	aside {
		min-width: 33%;
		height: 100vh;
		float: left;
		background-color: #B8FFD5;
	}
	section {
		width: 66%;
		height: 100vh;
		float: right;
		display: inline-block;
		background-color: #FFC5B8;
		margin-bottom: 5px;
	}
	footer {
		clear: both;
		background-color: #B9A7E8;		
	}
	.nav_button {
		display: inline-block;
		min-width: 33%;
	}
	.aside_button {
		padding: 10px;
	}
	.aside_button input {
		min-width: 190px;
	}
</style>
<body>
	<header>Ceci est le header</header>
	<nav>
		<div class="nav_button">	
			<input type="button" id="classic_button" name="logout_button" value="Utilisateurs" onclick=" button()" />
		</div>
		<div class="nav_button">
			<input type="button" id="classic_button" name="logout_button" value="Réservations" onclick=" button()" />
		</div>
		<div class="nav_button">
			<input type="button" id="classic_button" name="logout_button" value="Adhérents" onclick=" button()" />
		</div>
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
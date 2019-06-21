<?php
	if (!session_id()) {
		session_start();
	}

	include_once 'objets/classe-adherent.php';
	require_once 'controller.php';
	require_once 'include/view-functions.php';	
	var_dump($_POST);
	var_dump($_SESSION);
	
	echo '
		<!DOCTYPE html>
		<html>
		<head>
			<title>Intranet de Zumbambb</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="Site intranet pour l\'association Zumbam2b" content="Gestion des utilisateurs et des réservations">
		  	<meta name="author" content="">
		  	<title>Simple Sidebar - Start Bootstrap Template</title>
			<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<!-- Bootstrap core CSS -->
  			<link href="bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  		<!-- Custom styles for this template -->
  			<link href="bootstrap/css/simple-sidebar.css" rel="stylesheet">
			<script src="include/script.js"></script>
			<link rel="stylesheet" href="include/style.css">
		</head>
		<body>
			<div class="d-flex toggled" id="wrapper">

			<!-- Page Content -->

				<div id="page-content-wrapper">
					<div class="container-fluid">
						<center>
						<h1>Veuillez saisir votre mot de passe</h1><br /><br />
						<form action="#" method="post" onsubmit="return verifAllForm()">
								<label class="user-label" for="password">Mot de passe</label><br />
								<input type="password" class="btn btn-outline-primary btn-lg" placeholder="Mot de passe" name="password" minlength="12" maxlength="36" size="40" onblur="verifInputText(this)" required /><br /><br />
								<p class="hidden" name="password"></p>
								<label class="user-label" for="password-confirm">Confirmation du mot de passe</label><br />
								<input type="password" class="btn btn-outline-primary btn-lg" placeholder="Vérifier le mot de passe" name="password-confirm" maxlength="36" size="40"  onblur="verifInputText(this)" required /><br /><br />
								<p class="hidden" name="password-confirm"></p>
								<input type="submit" class="btn btn-outline-primary btn-lg" name="submit" value="Valider l\'inscription" class="bouton">
						</form>
						</center>
					</div>
				</div>

		<!-- /#page-content-wrapper -->
			</div>
	  	<!-- /#wrapper -->

	 	<!-- Bootstrap core JavaScript -->
	  	<script src="bootstrap/vendor/jquery/jquery.min.js"></script>
	  	<script src="bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	  	<!-- Menu Toggle Script -->
	  	<script>
	    $("#menu-toggle").click(function(e) {
	      e.preventDefault();
	      $("#wrapper").toggleClass("toggled");
	    });
	  	</script>
	</body>
</html>';





	
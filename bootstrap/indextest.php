<?php
// Code HTML pour les trois boutons du menu 
	function menuButton($nStatut)
	{
		$nav = '
			<ul class="nav nav-tabs">
 				<li class="nav-item">
 				  	
 				</li>';

 				





 		/*'<li class="nav-item"> 
 				  <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
 				</li>
			<ul>

			<div class="nav-button">
		 		<form method="post" action="#">
					<input type="submit"  class="menu-buttons" name="menu_button" value="Réservations" />
				</form>
			</div>
			<div class="nav-button">
		 		<form method="post" action="#">
					<input type="submit" class="menu-buttons" name="menu_button" value="Adhérents" />
				</form>
			</div>';
		
		// Si c'est le président qui est connecté on ajoute le troisième bouton
		if ($nStatut == PRESIDENT) {
		 	$nav .= '
		 		<div class="nav-button">
		 			<form method="post" action="#">
						<input type="submit" class="menu-buttons" name="menu_button" value="Utilisateurs" />
					</form>
				</div>';
		}*/
		return $nav;

	}










	echo '
		<!DOCTYPE html>
		<html lang="en">

		<head>

		  <meta charset="utf-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		  <meta name="description" content="">
		  <meta name="author" content="">

		  <title>Simple Sidebar - Start Bootstrap Template</title>

		  <!-- Bootstrap core CSS -->
		  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		  <!-- Custom styles for this template -->
		  <link href="css/simple-sidebar.css" rel="stylesheet">

		</head>

		<body>

		  <div class="d-flex" id="wrapper">

		    <!-- Sidebar -->
		    <div class="bg-light border-right" id="sidebar-wrapper">
		      <div class="sidebar-heading">Start Bootstrap </div>
		      <div class="list-group list-group-flush">
		        <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
		        <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>
		        <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
		        <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
		        <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
		        <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
		      </div>
		    </div>
		    <!-- /#sidebar-wrapper -->

		    <!-- Page Content -->
		    <div id="page-content-wrapper">

		      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
		        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

		        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		          <span class="navbar-toggler-icon"></span>
		        </button>

		        <div class="collapse navbar-collapse" id="navbarSupportedContent">
		          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
		            <li class="nav-item active">
		            	<form method="post" action="#">
							<input type="submit" class="btn btn-outline-primary btn-lg" name="menu_button" value="Réservations" />
						</form>
		            </li>
		            <li class="nav-item">
		            	<form method="post" action="#">
							<input type="submit" class="btn btn-outline-primary btn-lg" value="Adhérents" />
						</form>
		            </li>
		            <li class="nav-item dropdown">';

		        // Si c'est le président qui est connecté on ajoute le troisième bouton
				if (5 == 5) {
				 	echo '
 						<li class="nav-item">
				 			<form method="post" action="#">
								<input type="submit" class="btn btn-outline-primary btn-lg" name="menu_button" 		value="Utilisateurs" />
							</form>
						</li>';
				}

		echo '
		              
		          </ul>
		        </div>
		      </nav>

		      <div class="container-fluid">
		        <h1 class="mt-4">Simple Sidebar</h1>
		        <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
		        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>
		      </div>
		    </div>
		    <!-- /#page-content-wrapper -->

		  </div>
		  <!-- /#wrapper -->

		  <!-- Bootstrap core JavaScript -->
		  <script src="vendor/jquery/jquery.min.js"></script>
		  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		  <!-- Menu Toggle Script -->
		  <script>
		    $("#menu-toggle").click(function(e) {
		      e.preventDefault();
		      $("#wrapper").toggleClass("toggled");
		    });
		  </script>

		</body>

		</html>';

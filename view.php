<?php
	echo '
		<!DOCTYPE html>
		<html>
		<head>
			<link rel="icon" href="resources/favicon.ico" />
		  	<title>Zumbam2b - Intranet</title>
			<meta charset="utf-8">
			<meta name="Site intranet pour l\'association Zumbam2b" content="Gestion des utilisateurs et des réservations">
		  	<meta name="author" content="">
		<!-- Bootstrap core CSS -->
			<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  		<!-- Custom styles for this template -->
  			<link href="bootstrap/css/simple-sidebar.css" rel="stylesheet">
  		<!-- My files -->
			<script src="include/script.js"></script>
			<link rel="stylesheet" href="include/style.css">
		</head>
		<body>
			<div class="d-flex toggled" id="wrapper">
		<!-- Sidebar -->'
				. asideMembers() . '
		<!-- /#sidebar-wrapper -->
		<!-- Page Content -->
				<div id="page-content-wrapper">'
					. menuButton(PRESIDENT) . '
					<div class="container-fluid">' 
					. switchPages(PRESIDENT) . '
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





	

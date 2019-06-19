<?php

	echo '
		<!DOCTYPE html>
		<html>
		<head>
			<title>Intranet de Zumbambb</title>
			<meta charset="utf-8">
			<!--<link rel="stylesheet" href="bootstrap/css/bootstrap.css">-->
			<link rel="stylesheet" type="text/css" href="include/style.css">
			<script src="include/script.js"></script>
		</head>
		<body>
			<header>Ceci est le header</header>
			<nav class="bg-primary">'
				. menuButton(PRESIDENT) . '
			<script>
				var maintenant=new Date();
				var jour=maintenant.getDate();
				var mois=maintenant.getMonth()+1;
				var an=maintenant.getFullYear();
				if (mois<10)
					document.write("Nous sommes le ",jour,"/0",mois,"/",an,".");
				else
					document.write("Nous sommes le ",jour,"/",mois,"/",an,".");
			</script>
			</nav>
		<aside class="">'
				. asideMembers() .
		'</aside>
		<section class="bg-success">'
				.	display(PRESIDENT) .
		'</section>
			<footer>Ceci est le footer</footer>
		</body>
		</html>';





	

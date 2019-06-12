<?php

	echo '
		<!DOCTYPE html>
		<html>
		<head>
			<title>Intranet de Zumbambb</title>
			<meta charset="utf-8">
			<link rel="stylesheet" type="text/css" href="include/style.css">
		</head>
		<body>
			<header>Ceci est le header</header>
			<nav> '
				. menuButton(PRESIDENT) .
			'</nav>
		<aside class="">'
				. asideMembers() .
		'</aside>
		<section>'
				.	display(PRESIDENT) .
		'</section>
			<footer>Ceci est le footer</footer>
		</body>
		</html>';



	

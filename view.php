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

	<aside class="">
		<?php
			echo $aside;
		?>
	</aside>
	<section>
		<?php
			echo $section;
		?>
	</section>
	<footer>Ceci est le footer</footer>
</body>
</html>
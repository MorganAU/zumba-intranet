<?php 
	if (!session_id()) {
		session_start();
	}

	// debugmod
	$_SESSION['connect'] = 1;

	include_once 'objets/classe-adherent.php';
	require_once 'controller.php';
	require_once 'include/view-functions.php';	
	var_dump($_POST);
	var_dump($_SESSION);
	require_once 'view.php';

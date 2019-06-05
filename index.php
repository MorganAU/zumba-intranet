<?php 
	session_start();
	if (!isset($_SESSION['page'])) {
		$_SESSION['page'] = 'Réservation';
	}
	require_once 'controller.php';
	require_once 'view.php';



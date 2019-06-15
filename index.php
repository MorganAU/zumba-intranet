<?php 
	if (!session_id()) {
		session_start();
	}
	
	include_once 'objets/classe-adherent.php';
	require_once 'controller.php';
	require_once 'include/view-functions.php';
	require_once 'view.php';





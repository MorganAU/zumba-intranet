<?php

	define('CREER_ADHERENT', 'INSERT INTO adherent (nom_adherent, 
													prenom_adherent, 
													adresse_adherent, 
													cp_adherent, 
													ville_adherent, 
													mail_adherent,
													tel_adherent, 
													/*photo_adherent,*/  
													date_adherent) 
							  VALUES (:nom, :prenom, :adresse, :cp, :ville, :mail, :tel,/* :photo, */NOW())');

	define('CREER_UTILISATEUR', 'INSERT INTO adherent (nom_adherent, 
													prenom_adherent, 
													mail_adherent,
													tel_adherent, 
													date_adherent) 
							  	 VALUES (:nom, :prenom, :mail, :tel,/* :photo, */NOW())');

	define('CREER_STATUT', 'INSERT INTO appartient (id_statut, id_adherent)
							VALUES (:statut, :adherent)');
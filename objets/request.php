<?php
	// function createUser() 
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

	// function createStatus()
	define('CREER_STATUT', 'INSERT INTO appartient (id_statut, id_adherent)
							VALUES (:statut, :adherent)');

	// function readAdherentByMail()
	define('LIRE_ADHERENT_PAR_MAIL', 'SELECT * FROM adherent
									  WHERE mail_adherent = :mail');
	
	// function freeMail()
	define('MAIL_DISPONIBLE', 'SELECT * FROM adherent 
							   WHERE mail_adherent = :mail');
	
	// function readStatus($nId)
	define('LIRE_STATUT_PAR_ID', 'SELECT nom_statut FROM adherent AS ad 
								INNER JOIN appartient AS ap ON (ad.id_adherent=ap.id_adherent) 
								INNER JOIN statut AS s ON (ap.id_statut=s.id_statut) 
								WHERE ap.id_adherent = :id');

	// function getAllAdherents()
	define('TOUS_LES_ADHERENTS', 'SELECT * FROM adherent');

	// function readIdByMail()
	define('LIRE_ID_ADHERENT_PAR_MAIL', 'SELECT id_adherent FROM adherent 
								  WHERE mail_adherent = :mail');

	// function updateUser($nId)
	define('MAJ_ADHERENT_PAR_ID', 'UPDATE adherent
								   SET nom_adherent = :nom,
								   prenom_adherent = :prenom,
								   adresse_adherent = :adresse,
								   cp_adherent = :cp,
								   ville_adherent = :ville,
								   mail_adherent = :mail,
								   tel_adherent = :tel
								   WHERE id_adherent = :id');

	// function updateStatus($nId, $nStatut)
	define('MAJ_STATUT_PAR_ID_ADHERENT', 'UPDATE appartient
								  		  SET id_statut = :statut
								 		  WHERE id_adherent = :id');

	/*// function deleteMember() 
	define('TOUS_LES_ADHERENTS', 'SELECT * FROM adherent');*/

	// function updatePassUser($sMail, $sNewPassword) 
	define('SUPPRIME_ADHERENT_PAR_ID', 'DELETE FROM adherent 
				 				WHERE id_adherent = :id');

	// function deleteStatus() 
	define('SUPPRIME_STATUT_PAR_ID_ADHERENT', 'DELETE FROM appartient 
				 				WHERE id_adherent = :id');


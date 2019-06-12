<?php
	include_once 'sql_connect.php';

	define('CREER_ADHERENT', 'INSERT INTO mod582_user_coment_add (login_adherent,
															  	  nom_adherent, 
															  	  prenom_adherent, 
															  	  mdp_adherent, 
															  	  adresse_adherent, 
															  	  cp_adherent, 
															  	  ville_adherent, 
															  	  mail_adherent, 
															  	  photo_adherent,  
															  	  date_adherent) 
							  VALUES (:login, :nom, :prenom, :mdp, :adresse, :cp, :ville, :mail, :photo, :dateInscritpion)');

	class Adherent 
	{ 
		private $id;
		private $login;
		private $nom;
		private $prenom;
		private $pass;
		private $statut;
		private $adresse;
		private $cp;
		private $ville;
		private $tel;
		private $mail;
		private $photo;
		private $dateInscritpion;
 
		public function __construct() 
		{
 			$this->statut = 0;
		}
 
		/*********************************************************************
		*								CREATE 								 *
		*********************************************************************/

		public function createUser() 
		{
			$pdo = databaseConnect();
			$q = $pdo->prepare(CREER_ADHERENT);

			$sPassHash = password_hash($sPass, PASSWORD_DEFAULT);
			$q->bindParam(':login', $this->getLogin());
			$q->bindParam(':nom', $this->getNom());
			$q->bindParam(':prenom', $this->getPrenom());
			$q->bindParam(':mdp', $this->getPass());
			$q->bindParam(':adresse', $this->getAdresse());
			$q->bindParam(':cp', $this->getCp());
			$q->bindParam(':ville', $this->getVille());
			$q->bindParam(':mail', $this->getMail());
			$q->bindParam(':photo', $this->getPhoto());
			$q->bindParam(':dateInscritpion', $this->dateInscription());

			$q->execute();
			
			if ($q == 0) {
				logout('user_created');
			} else {
				log($q->errorInfo());
			}
		}

		/*********************************************************************
		*								READ 								 *
		*********************************************************************/
 
		public function readAdherentByMail($sMail) 
		{
			$pdo = databaseConnect();
						
			$q = $pdo->prepare('SELECT * FROM adherent WHERE mail_adherent = :mail');

			$q->bindParam(':mail', $sMail);

			if($q->execute() != false) {
				while ($row = $q->fetch()) {
					$this->setNom($row['nom_adherent']);
					$this->setPrenom($row['prenom_adherent']);
					$this->setPass($row['mdp_adherent']);
					$this->setAdresse($row['adresse_adherent']);
					$this->setCp($row['cp_adherent']);
					$this->setVille($row['ville_adherent']);
					$this->setTel($row['tel_adherent']);
					$this->setMail($row['mail_adherent']);
					$this->setPhoto($row['photo_adherent']);
					$this->setDate($row['date_adherent']);
				}	
			}
		}

		public function freeNickname($sNickname)
		{
			$pdo = databaseConnect();
						
			$q = $pdo->prepare('SELECT registered_id FROM mod582_user_coment_add WHERE nickname = :nickname');

			$q->bindParam(':nickname', $sNickname);
			$id = null;
			if($q->execute() != false) {
				while ($row = $q->fetch()) {
					$id = $row['registered_id'];
				}	
			}
			return $id; 
		}

		public function readStatus($nId)
		{
			$pdo = databaseConnect();

			$status = '';
			$q = $pdo->prepare('SELECT nom_statut FROM adherent AS ad 
								INNER JOIN appartient AS ap ON (ad.id_adherent=ap.id_adherent) 
								INNER JOIN statut AS s ON (ap.id_statut=s.id_statut) 
								WHERE ap.id_adherent = :id');

			$q->bindParam(':id', $nId);

			if($q->execute() != false) {
				while ($row = $q->fetch()) {
					$status = $row['nom_statut'];
				}	
			}

			return $status;
		}

		public function readAdmin($sMail) 
		{
			$pdo = databaseConnect();
			
			$q = $pdo->prepare('SELECT * FROM mod582_users WHERE user_email = :mail');

			$q->bindParam(':mail', $sMail);

			if($q->execute() != false) {
				while ($row = $q->fetch()) {
					$this->setMail($row['user_email']);
					$this->setPass($row['user_pass']);
					$this->setNickname($row['user_nicename']);
				}	
			}
		}

 		public function getAllAdherents()
		{
			$pdo = databaseConnect();
						
			$q = $pdo->prepare('SELECT * FROM adherent');
			$i = 0;
			$aObjects = array();

			if($q->execute() != false) {        
               while ($data=$q->fetch()) {
                   $aObjects[$i]['id_adherent'] = $data['id_adherent'];
                   $aObjects[$i]['nom_adherent'] = $data['nom_adherent'];
                   $aObjects[$i]['prenom_adherent'] = $data['prenom_adherent'];
                   $aObjects[$i]['mdp_adherent'] = $data['mdp_adherent'];
                   $aObjects[$i]['adresse_adherent'] = $data['adresse_adherent'];
                   $aObjects[$i]['cp_adherent'] = $data['cp_adherent'];
                   $aObjects[$i]['ville_adherent'] = $data['ville_adherent'];
                   $aObjects[$i]['tel_adherent'] = $data['tel_adherent'];
                   $aObjects[$i]['mail_adherent'] = $data['mail_adherent'];
                   $aObjects[$i]['photo_adherent'] = $data['photo_adherent'];
                   $aObjects[$i]['date_adherent'] = $data['date_adherent'];
                   $i++;
               }
               
			}

			return $aObjects; 
		}

		public function getAllPreRegistration()
				{
					$pdo = databaseConnect();

					$id = PRE_INSCRIT;
								
					$q = $pdo->prepare('SELECT * FROM adherent AS ad 
										INNER JOIN appartient AS ap ON (ad.id_adherent=ap.id_adherent) 
										INNER JOIN statut AS s ON (ap.id_statut=s.id_statut) 
										WHERE s.id_statut = :id');

					$q->bindParam(':id', $id);
					$aObjects = array();

					if($q->execute() != false) {
						$aObjects = $q->fetchAll();	
					}

					return $aObjects; 
				}


		/*********************************************************************
		*								UPDATE 								 *
		*********************************************************************/

		public function updateUser($sNickname, $sMail, $sOldMail) 
		{
 			$pdo = databaseConnect();
			
			$q = $pdo->prepare('UPDATE mod582_user_coment_add
								SET nickname = :nickname,
									mail = :mail,
									pass = :pass
								WHERE mail = :oldMail');

			$sPassHash = password_hash($sPass, PASSWORD_DEFAULT);
			$q->bindParam(':nickname', $sNickname);
			$q->bindParam(':mail', $sMail);
			$q->bindParam(':pass', $sPassHash);
			$q->bindParam(':oldMail', $sOldMail);

			$q->execute();
			
			if ($q->fetch() != false) {
				logoutLog('database_error');
			} else {
				loginLog('update_sucess');
			}

		}
 
		public function updatePassUser($sMail, $sNewPassword) 
		{
 			$pdo = databaseConnect();
			
			$q = $pdo->prepare('UPDATE mod582_user_coment_add
								SET pass = :pass
								WHERE mail = :mail');

			$sNewPassword = password_hash($sPass, PASSWORD_DEFAULT);
			$q->bindParam(':mail', $sMail);
			$q->bindParam(':pass', $sNewPassword);

			$q->execute();
			
			if ($q->fetch() != false) {
				logoutLog('database_error');
			} else {
				loginLog('update_sucess');
			}

		}

		/*********************************************************************
		*								DELETE 								 *
		*********************************************************************/

		public function deleteUser($nId) 
		{
 			$pdo = databaseConnect();
			
			$q = $pdo->prepare('DELETE FROM mod582_user_coment_add 
				 				WHERE registered_id = :id');

			$q->bindParam(':id', $nId);

			$q->execute();
			
			if ($q->fetch() != false) {
				logoutLog('database_error');
			}

		}

		

		/************************************************************
		*****					MUTATORS						*****
		************************************************************/

		public function setNom($sNom)
		{
			$this->nom = $sNom;
		}

		public function setPrenom($sPrenom)
		{
			$this->prenom = $sPrenom;
		}

		public function setPass($sPass)
		{
			$this->pass = $sPass;
		}

		public function setStatut($nStatut)
		{
			$this->statut = $nStatut;
		}

		public function setAdresse($sAdresse)
		{
			$this->adresse = $sAdresse;
		}

		public function setCp($nCp)
		{
			$this->cp = $nCp;
		}

		public function setVille($sVille)
		{
			$this->ville = $sVille;
		}

		public function setTel($nTel)
		{
			$this->tel = $nTel;
		}

		public function setMail($sMail)
		{
			$this->mail = $sMail;
		}


		public function setPhoto($sPhoto)
		{
			$this->photo = $sPhoto;
		}

		public function setDate($sDate)
		{
			$this->date = $sDate;
		}

		

		
		/************************************************************
		*****					ACCESSORS						*****
		************************************************************/
		public function getId()
		{
			return $this->id;
		}

		public function getNom()
		{
			return $this->nom;
		}

		public function getPrenom()
		{
			return $this->prenom;
		}

		public function getPass()
		{
			return $this->pass;
		}

		public function getStatut()
		{
			return $this->statut;
		}

		public function getAdresse()
		{
			return $this->adresse;
		}

		public function getCp()
		{
			return $this->cp;
		}

		public function getVille()
		{
			return $this->ville;
		}

		public function getTel()
		{
			return $this->tel;
		}

		public function getMail()
		{
			return $this->mail;
		}

		public function getPhoto()
		{
			return $this->photo;
		}

		public function getDate()
		{
			return $this->date;
		}

		
	}
 


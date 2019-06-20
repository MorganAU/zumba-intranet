<?php
	/** Liste des méthodes de la classe adhérent
	*	__construct() --------------> Fonction pour vérifier les valeurs des input du formulaire
	*	createUser() ------------> Fonction pour vérirfier si les valeurs saisies sont bien au format mail
	*	createStatus() ---------------> Fonction pour vérirfier la taille des valeurs saisies
	*	readAdherentByMail() ---------------> Fonction pour changer le bckground du champ si il y a une erreur
	*	changeClassAndMessage(sName, sMessage, result)-> Fonction qui renvoie les messages d'erreur en fonction de celles-ci
	*	getParaIndex(aElements, sName) -----> Fonction qui renvoie l'indes d'un élément
	*	verifAllForm() ---------------------> Fonction pour vérifier tout le formulaire quand le bouton valoider est pressé
	**/




	include_once 'sql_connect.php';
	include_once 'request.php';

	class Adherent 
	{ 
		private $id;
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
 			$this->statut = 1;
 			$this->adresse = 'xxxxxx';
			$this->cp = 'xxxxx';
			$this->ville = 'xxxxxx';
		}
 
		/*********************************************************************
		*								CREATE 								 *
		*********************************************************************/

		public function createUser() 
		{
			$pdo = databaseConnect();
			$q = $pdo->prepare(CREER_ADHERENT);
			$lastname = $this->getNom();
			$name = $this->getPrenom();
			$address = $this->getAdresse();
			$cp = $this->getCp();
			$city = $this->getVille();
			$email = $this->getMail();
			$phone = $this->getTel();

			$q->bindParam(':nom', $lastname);
			$q->bindParam(':prenom', $name);
			$q->bindParam(':adresse', $address);
			$q->bindParam(':cp', $cp);
			$q->bindParam(':ville',$city);
			$q->bindParam(':mail', $email);
			$q->bindParam(':tel', $phone);

			if($q->execute() != false) {
				$this->readIdByMail();
				$this->createStatus();
				header ("Refresh: 3;URL=" . $_SERVER['PHP_SELF']);
			} else {
				errorDatabase($q);
			}
			
		}


		private function createStatus()
		{
			$pdo = databaseConnect();

			$status = $this->getStatut();
			$id = $this->getId();

			$q = $pdo->prepare(CREER_STATUT);

			$q->bindParam(':statut', $status);
			$q->bindParam(':adherent', $id);

			if($q->execute() === false) {
				errorDatabase($q);
			}
		}

		/*********************************************************************
		*								READ 								 *
		*********************************************************************/
 
		public function readAdherentByMail() 
		{
			$pdo = databaseConnect();
						
			$q = $pdo->prepare('SELECT * FROM adherent WHERE mail_adherent = :mail');

			$email = $this->getMail();

			$q->bindParam(':mail', $email);

			if($q->execute() != false) {
				while ($row = $q->fetch()) {
					$this->setId($row['id_adherent']);
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

		public function freeMail()
		{
			$pdo = databaseConnect();
			$id = null;
						
			$q = $pdo->prepare('SELECT * FROM adherent WHERE mail_adherent = :mail');

			$email = $this->getMail();

			$q->bindParam(':mail', $email);

			if($q->execute() != false) {
				while ($row = $q->fetch()) {
					$id = $row['id_adherent'];
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



		public function readIdByMail()
		{
			$pdo = databaseConnect();
			$email = $this->getMail();

			$q = $pdo->prepare('SELECT id_adherent FROM adherent 
								WHERE mail_adherent = :mail');

			$q->bindParam(':mail', $email);

			if($q->execute() != false) {
				while ($row = $q->fetch()) {
					$this->setId($row['id_adherent']);
				} 
			}
		}


		/*********************************************************************
		*								UPDATE 								 *
		*********************************************************************/

		public function updateUser($nId) 
		{

 			$pdo = databaseConnect();
			
			$q = $pdo->prepare('UPDATE adherent
								SET nom_adherent = :nom,
									prenom_adherent = :prenom,
									adresse_adherent = :adresse,
									cp_adherent = :cp,
									ville_adherent = :ville,
									mail_adherent = :mail,
									tel_adherent = :tel
								WHERE id_adherent = :id');

			$lastname = $this->getNom();
			$name = $this->getPrenom();
			$address = $this->getAdresse();
			$cp = $this->getCp();
			$city = $this->getVille();
			$email = $this->getMail();
			$phone = $this->getTel();

			$q->bindParam(':id', $nId);
			$q->bindParam(':nom', $lastname);
			$q->bindParam(':prenom', $name);
			$q->bindParam(':adresse', $address);
			$q->bindParam(':cp', $cp);
			$q->bindParam(':ville',$city);
			$q->bindParam(':mail', $email);
			$q->bindParam(':tel', $phone);
			
			if($q->execute() === false) {
				errorDatabase($q);
			}
		}

		public function updateStatus($nId, $nStatut)
		{
			$pdo = databaseConnect();
			
			$q = $pdo->prepare('UPDATE appartient
								SET id_statut = :statut
								WHERE id_adherent = :id');

			$q->bindParam(':statut', $nStatut);
			$q->bindParam(':id', intval($nId));

			if($q->execute() != false) {
				header('Location:' . $_SERVER['PHP_SELF']);
			} else {
				errorDatabase($q);
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

		public function deleteMember() 
		{
 			$pdo = databaseConnect();

			$q = $pdo->prepare('DELETE FROM adherent 
				 				WHERE id_adherent = :id');

			$id = intval($this->getId());

			$q->bindParam(':id', $id);
			
			if($q->execute() != false) {
				header ("Refresh: 3;URL=" . $_SERVER['PHP_SELF']);
			} else {
				errorDatabase($q);
				die("adherent");
			}

		}

		
		public function deleteStatus() 
		{
 			$pdo = databaseConnect();
		
			$q = $pdo->prepare('DELETE FROM appartient 
				 				WHERE id_adherent = :id');

			$id = intval($this->getId());

			$q->bindParam(':id', $id);
			
			if($q->execute() === false) {
				errorDatabase($q);
				die("statut");
			}

		}

		
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

		public function setId($nId)
		{
			$this->id = $nId;
		}

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
 


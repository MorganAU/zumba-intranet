<?php
	/** Liste des méthodes de la classe adhérent
	*	__construct() ----------------> Constructeur de la classe Adherent
	*	createUser() -----------------> Créer un adhérent dans la base de données
	*	createStatus() ---------------> Affecte un statut à un adhérent
	*	readAdherentByMail() ---------> Récupère un adhérent en fonction d'une adresse mail
	*	freeMail() -------------------> Vérifie si l'adresse mail est déjà présente si oui elle récupère l'id
	*	readStatus($nId) -------------> Récupère la valeur du champ nom_statut en fonction de son id
	*	getAllAdherents() ------------> Récupère tous les adhérents de la table
	*	readIdByMail() ---------------> Récupère l'id en fonction du mail
	*	updateUser($nId) -------------> Met un jour un utilisateur en fonction de son id
	*	updateStatus($nId, $nStatut) -> Met un jour le statut d'un utilisateur en fonction de son id
	*	updatePassword() -------------> Met à jour le mot de passe
	*	deleteMember() ---------------> Supprime un adhérent
	*	deleteStatus() ---------------> Supprime le statut d'un adherent 
	*	setId($nId) ------------------> Lien vers les mutateurs
	*	getId() ------------------- --> Lien vers les accesseurs
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
 		
 		// Constructeur de la classe Adherent
		public function __construct() 
		{
 			$this->statut = 1;
		}
 
		/*********************************************************************
		*								CREATE 								 *
		*********************************************************************/

		// Créer un adhérent dans la base de données
		public function createUser() 
		{
			$pdo = databaseConnect();
			$req = $pdo->prepare(CREER_ADHERENT);
			$lastname = $this->getNom();
			$name = $this->getPrenom();
			$address = $this->getAdresse();
			$cp = $this->getCp();
			$city = $this->getVille();
			$email = $this->getMail();
			$phone = $this->getTel();

			$req->bindParam(':nom', $lastname);
			$req->bindParam(':prenom', $name);
			$req->bindParam(':adresse', $address);
			$req->bindParam(':cp', $cp);
			$req->bindParam(':ville',$city);
			$req->bindParam(':mail', $email);
			$req->bindParam(':tel', $phone);

			if($req->execute() != false) {
				$this->readIdByMail();
				$this->createStatus();
			} else {
				errorDatabase($req);
			}
		}

		// Affecte un statut à un adhérent
		private function createStatus()
		{
			$pdo = databaseConnect();

			$status = $this->getStatut();
			$id = $this->getId();

			$req = $pdo->prepare(CREER_STATUT);

			$req->bindParam(':statut', $status);
			$req->bindParam(':adherent', $id);

			if($req->execute() === false) {
				errorDatabase($req);
			}
		}

		/*********************************************************************
		*								READ 								 *
		*********************************************************************/
 		
 		// Récupère un adhérent en fonction d'une adresse mail
		public function readAdherentByMail() 
		{
			$pdo = databaseConnect();
						
			$req = $pdo->prepare(LIRE_ADHERENT_PAR_MAIL);

			$email = $this->getMail();

			$req->bindParam(':mail', $email);

			if($req->execute() != false) {
				while ($row = $req->fetch()) {
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
			} else {
				errorDatabase($req);
			}
		}

		// Vérifie si l'adresse mail est déjà présente si oui elle récupère l'id
		public function freeMail()
		{
			$pdo = databaseConnect();
			$id = null;
						
			$req = $pdo->prepare(MAIL_DISPONIBLE);

			$email = $this->getMail();

			$req->bindParam(':mail', $email);

			if($req->execute() != false) {
				while ($row = $req->fetch()) {
					$id = $row['id_adherent'];
				}	
			} else {
				errorDatabase($req);
			}

			return $id; 
		}

		// Récupère la valeur du champ nom_statut en fonction de son id
		public function readStatus($nId)
		{
			$pdo = databaseConnect();

			$status = '';
			$req = $pdo->prepare(LIRE_STATUT_PAR_ID);

			$req->bindParam(':id', $nId);

			if($req->execute() != false) {
				while ($row = $req->fetch()) {
					$status = $row['nom_statut'];
				}	
			} else {
				errorDatabase($req);
			}

			return $status;
		}

		// Récupère tous les adhérents de la table
 		public function getAllAdherents()
		{
			$pdo = databaseConnect();
						
			$req = $pdo->prepare(TOUS_LES_ADHERENTS);
			$i = 0;
			$aObjects = array();

			if($req->execute() != false) {        
               while ($data=$req->fetch()) {
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
			} else {
				errorDatabase($req);
			}

			return $aObjects; 
		}

		// Récupère l'id en fonction du mail
		public function readIdByMail()
		{
			$pdo = databaseConnect();
			$email = $this->getMail();

			$req = $pdo->prepare(LIRE_ID_ADHERENT_PAR_MAIL);

			$req->bindParam(':mail', $email);

			if($req->execute() != false) {
				while ($row = $req->fetch()) {
					$this->setId($row['id_adherent']);
				} 
			} else {
				errorDatabase($req);
			}
		}


		/*********************************************************************
		*								UPDATE 								 *
		*********************************************************************/

		// Met un jour un utilisateur en fonction de son id
		public function updateUser($nId)
		{
 			$pdo = databaseConnect();
			
			$req = $pdo->prepare(MAJ_ADHERENT_PAR_ID);

			$lastname = $this->getNom();
			$name = $this->getPrenom();
			$address = $this->getAdresse();
			$cp = $this->getCp();
			$city = $this->getVille();
			$email = $this->getMail();
			$phone = $this->getTel();

			$req->bindParam(':id', $nId);
			$req->bindParam(':nom', $lastname);
			$req->bindParam(':prenom', $name);
			$req->bindParam(':adresse', $address);
			$req->bindParam(':cp', $cp);
			$req->bindParam(':ville',$city);
			$req->bindParam(':mail', $email);
			$req->bindParam(':tel', $phone);
			
			if($req->execute() === false) {
				errorDatabase($req);
			}
		}

		// Met un jour le statut d'un utilisateur en fonction de son id
		public function updateStatus($nId, $nStatut)
		{
			$pdo = databaseConnect();
			
			$req = $pdo->prepare(MAJ_STATUT_PAR_ID_ADHERENT);

			$req->bindParam(':statut', $nStatut);
			$req->bindParam(':id', intval($nId));

			if($req->execute() != false) {
				header('Location:' . $_SERVER['PHP_SELF']);
			} else {
				errorDatabase($req);
			}
		}

		// Met à jour le mot de passe
		public function updatePassword()
		{
			$pdo = databaseConnect();

			$id = $this->getId();
			$password = $this->getPass();

			$req = $pdo->prepare(CREER_MDP);


			$req->bindParam(':password', $password);
			$req->bindParam(':id', $id);

			if($req->execute() === false) {
				errorDatabase($req);
			}
		}

		/*********************************************************************
		*								DELETE 								 *
		*********************************************************************/

		// Supprime un adhérent
		public function deleteMember() 
		{
 			$pdo = databaseConnect();
			$req = $pdo->prepare(SUPPRIME_ADHERENT_PAR_ID);

			$id = intval($this->getId());
			$req->bindParam(':id', $id);
			
			$this->deleteStatus();
			
			if($req->execute() != false) {
				header ("Refresh: 3;URL=" . $_SERVER['PHP_SELF']);
			} else {
				errorDatabase($req);
			}
		}

		// Supprime le statut d'un adherent 
		private function deleteStatus() 
		{
 			$pdo = databaseConnect();
		
			$req = $pdo->prepare(SUPPRIME_STATUT_PAR_ID_ADHERENT);

			$id = intval($this->getId());

			$req->bindParam(':id', $id);
			
			if($req->execute() === false) {
				errorDatabase($req);
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
 


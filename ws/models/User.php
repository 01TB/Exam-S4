<?php
    class User {
        private $id;
        private $idDepartement;
        private $nom;
        private $prenom;
        private $password;

        public function __construct($id, $idDepartement, $nom, $prenom, $password) {
            $this->id = $id;
            $this->idDepartement = $idDepartement;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->password = $password;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getIdDepartement() { return $this->idDepartement; }
        public function getNom() { return $this->nom; }
        public function getPrenom() { return $this->prenom; }
        public function getPassword() { return $this->password; }

        // Setters
        public function setIdDepartement($idDepartement) { $this->idDepartement = $idDepartement; }
        public function setNom($nom) { $this->nom = $nom; }
        public function setPrenom($prenom) { $this->prenom = $prenom; }
        public function setPassword($password) { $this->password = $password; }

        public static function checkUser($nom,$password){
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM user WHERE nom=:nom AND password=:password");            
            
            $stmt->bindParam(':nom',$nom);
            $stmt->bindParam(':password',$password);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>
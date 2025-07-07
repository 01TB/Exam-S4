<?php
    class Client {
        private $id;
        private $nom;
        private $prenom;

        public function __construct($id, $nom, $prenom) {
            $this->id = $id;
            $this->nom = $nom;
            $this->prenom = $prenom;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getNom() { return $this->nom; }
        public function getPrenom() { return $this->prenom; }

        // Setters
        public function setNom($nom) { $this->nom = $nom; }
        public function setPrenom($prenom) { $this->prenom = $prenom; }
    }
?>
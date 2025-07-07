<?php
    class Departement {
        private $id;
        private $nom;

        public function __construct($id, $nom) {
            $this->id = $id;
            $this->nom = $nom;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getNom() { return $this->nom; }

        // Setters
        public function setNom($nom) { $this->nom = $nom; }
    }
?>
<?php
    class Depot {
        private $id;
        private $idUser;
        private $nomInvestisseur;
        private $montant;
        private $dateDepot;
        private $description;

        public function __construct($id, $idUser, $nomInvestisseur, $montant, $dateDepot, $description) {
            $this->id = $id;
            $this->idUser = $idUser;
            $this->nomInvestisseur = $nomInvestisseur;
            $this->montant = $montant;
            $this->dateDepot = $dateDepot;
            $this->description = $description;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getIdUser() { return $this->idUser; }
        public function getNomInvestisseur() { return $this->nomInvestisseur; }
        public function getMontant() { return $this->montant; }
        public function getDateDepot() { return $this->dateDepot; }
        public function getDescription() { return $this->description; }

        // Setters
        public function setIdUser($idUser) { $this->idUser = $idUser; }
        public function setNomInvestisseur($nomInvestisseur) { $this->nomInvestisseur = $nomInvestisseur; }
        public function setMontant($montant) { $this->montant = $montant; }
        public function setDateDepot($dateDepot) { $this->dateDepot = $dateDepot; }
        public function setDescription($description) { $this->description = $description; }
    }
?>
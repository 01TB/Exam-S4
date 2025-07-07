<?php
    class HistoriquePret {
        private $id;
        private $idUser;
        private $idPret;
        private $etat;
        private $dateModif;

        public function __construct($id, $idUser, $idPret, $etat, $dateModif) {
            $this->id = $id;
            $this->idUser = $idUser;
            $this->idPret = $idPret;
            $this->etat = $etat;
            $this->dateModif = $dateModif;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getIdUser() { return $this->idUser; }
        public function getIdPret() { return $this->idPret; }
        public function getEtat() { return $this->etat; }
        public function getDateModif() { return $this->dateModif; }

        // Setters
        public function setIdUser($idUser) { $this->idUser = $idUser; }
        public function setIdPret($idPret) { $this->idPret = $idPret; }
        public function setEtat($etat) { $this->etat = $etat; }
        public function setDateModif($dateModif) { $this->dateModif = $dateModif; }
    }
?>
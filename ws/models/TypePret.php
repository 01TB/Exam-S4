<?php

    class TypePret {
        private $id;
        private $nom;
        private $montantMax;
        private $montantMin;
        private $dureeRemboursementMax;
        private $dureeRemboursementMin;
        private $taux;

        public function __construct($id, $nom, $montantMax, $montantMin, $dureeRemboursementMax, $dureeRemboursementMin, $taux) {
            $this->id = $id;
            $this->nom = $nom;
            $this->montantMax = $montantMax;
            $this->montantMin = $montantMin;
            $this->dureeRemboursementMax = $dureeRemboursementMax;
            $this->dureeRemboursementMin = $dureeRemboursementMin;
            $this->taux = $taux;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getNom() { return $this->nom; }
        public function getMontantMax() { return $this->montantMax; }
        public function getMontantMin() { return $this->montantMin; }
        public function getDureeRemboursementMax() { return $this->dureeRemboursementMax; }
        public function getDureeRemboursementMin() { return $this->dureeRemboursementMin; }
        public function getTaux() { return $this->taux; }

        // Setters
        public function setNom($nom) { $this->nom = $nom; }
        public function setMontantMax($montantMax) { $this->montantMax = $montantMax; }
        public function setMontantMin($montantMin) { $this->montantMin = $montantMin; }
        public function setDureeRemboursementMax($dureeRemboursementMax) { $this->dureeRemboursementMax = $dureeRemboursementMax; }
        public function setDureeRemboursementMin($dureeRemboursementMin) { $this->dureeRemboursementMin = $dureeRemboursementMin; }
        public function setTaux($taux) { $this->taux = $taux; }
    }

    

    

    

    

    

    

?>
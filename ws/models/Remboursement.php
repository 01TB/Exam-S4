<?php
    require_once __DIR__ . '/../inc/db.php';

    class Remboursement {
        private $id;
        private $idPret;
        private $dateRemboursement;
        private $moisRembourse;
        private $anneeRembourse;
        private $montantRembourse;

        public function __construct($id, $idPret, $dateRemboursement,
                                    $moisRembourse, $anneeRembourse, 
                                    $montantRembourse) {
            $this->id = $id;
            $this->idPret = $idPret;
            $this->dateRemboursement = $dateRemboursement;
            $this->moisRembourse = $moisRembourse;
            $this->anneeRembourse = $anneeRembourse;
            $this->montantRembourse = $montantRembourse;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getIdPret() { return $this->idPret; }
        public function getDateRemboursement() { return $this->dateRemboursement; }
        public function getMoisRembourse() { return $this->moisRembourse; }
        public function getAnneeRembourse() { return $this->anneeRembourse; }
        public function getMontantRembourse() { return $this->montantRembourse; }
        
    }
?>
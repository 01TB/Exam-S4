<?php
    class Pret {
        private $id;
        private $idClient;
        private $idUserDemandeur;
        private $idUserValidateur;
        private $idTypePret;
        private $montantPret;
        private $montantRemboursementParMois;
        private $montantTotalRemboursement;
        private $dureeRemboursement;
        private $taux;
        private $dateDemande;

        public function __construct($id, $idClient, $idUserDemandeur, $idUserValidateur, $idTypePret, $montantPret, $montantRemboursementParMois, $montantTotalRemboursement, $dureeRemboursement, $taux, $dateDemande) {
            $this->id = $id;
            $this->idClient = $idClient;
            $this->idUserDemandeur = $idUserDemandeur;
            $this->idUserValidateur = $idUserValidateur;
            $this->idTypePret = $idTypePret;
            $this->montantPret = $montantPret;
            $this->montantRemboursementParMois = $montantRemboursementParMois;
            $this->montantTotalRemboursement = $montantTotalRemboursement;
            $this->dureeRemboursement = $dureeRemboursement;
            $this->taux = $taux;
            $this->dateDemande = $dateDemande;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getIdClient() { return $this->idClient; }
        public function getIdUserDemandeur() { return $this->idUserDemandeur; }
        public function getIdUserValidateur() { return $this->idUserValidateur; }
        public function getIdTypePret() { return $this->idTypePret; }
        public function getMontantPret() { return $this->montantPret; }
        public function getMontantRemboursementParMois() { return $this->montantRemboursementParMois; }
        public function getMontantTotalRemboursement() { return $this->montantTotalRemboursement; }
        public function getDureeRemboursement() { return $this->dureeRemboursement; }
        public function getTaux() { return $this->taux; }
        public function getDateDemande() { return $this->dateDemande; }

        // Setters
        public function setIdClient($idClient) { $this->idClient = $idClient; }
        public function setIdUserDemandeur($idUserDemandeur) { $this->idUserDemandeur = $idUserDemandeur; }
        public function setIdUserValidateur($idUserValidateur) { $this->idUserValidateur = $idUserValidateur; }
        public function setIdTypePret($idTypePret) { $this->idTypePret = $idTypePret; }
        public function setMontantPret($montantPret) { $this->montantPret = $montantPret; }
        public function setMontantRemboursementParMois($montantRemboursementParMois) { $this->montantRemboursementParMois = $montantRemboursementParMois; }
        public function setMontantTotalRemboursement($montantTotalRemboursement) { $this->montantTotalRemboursement = $montantTotalRemboursement; }
        public function setDureeRemboursement($dureeRemboursement) { $this->dureeRemboursement = $dureeRemboursement; }
        public function setTaux($taux) { $this->taux = $taux; }
        public function setDateDemande($dateDemande) { $this->dateDemande = $dateDemande; }
    }
?>

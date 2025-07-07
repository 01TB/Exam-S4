<?php

    require_once __DIR__ . '../inc/db.php';
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
        private $status;
        private $taux;
        private $dateDemande;
        private $dateValidation;

        public function __construct($id, $idClient, $idUserDemandeur, $idUserValidateur, $idTypePret, 
                                    $montantPret, $montantRemboursementParMois, $montantTotalRemboursement, 
                                    $dureeRemboursement, $status, $taux, $dateDemande, $dateValidation) {
            $this->id = $id;
            $this->idClient = $idClient;
            $this->idUserDemandeur = $idUserDemandeur;
            $this->idUserValidateur = $idUserValidateur;
            $this->idTypePret = $idTypePret;
            $this->montantPret = $montantPret;
            $this->montantRemboursementParMois = $montantRemboursementParMois;
            $this->montantTotalRemboursement = $montantTotalRemboursement;
            $this->dureeRemboursement = $dureeRemboursement;
            $this->status = $status;
            $this->taux = $taux;
            $this->dateDemande = $dateDemande;
            $this->$dateValidation = $dateValidation;
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
        public function getStatus(){return $this->status;}
        public function getTaux() { return $this->taux; }
        public function getDateDemande() { return $this->dateDemande; }
        public function getDateValidation() { return $this->dateValidation; }

        // Setters
        public function setIdClient($idClient) { $this->idClient = $idClient; }
        public function setIdUserDemandeur($idUserDemandeur) { $this->idUserDemandeur = $idUserDemandeur; }
        public function setIdUserValidateur($idUserValidateur) { $this->idUserValidateur = $idUserValidateur; }
        public function setIdTypePret($idTypePret) { $this->idTypePret = $idTypePret; }
        public function setMontantPret($montantPret) { $this->montantPret = $montantPret; }
        public function setMontantRemboursementParMois($montantRemboursementParMois) { $this->montantRemboursementParMois = $montantRemboursementParMois; }
        public function setMontantTotalRemboursement($montantTotalRemboursement) { $this->montantTotalRemboursement = $montantTotalRemboursement; }
        public function setDureeRemboursement($dureeRemboursement) { $this->dureeRemboursement = $dureeRemboursement; }
        public function setStatus($status){$this->status = $status;}
        public function setTaux($taux) { $this->taux = $taux; }
        public function setDateDemande($dateDemande) { $this->dateDemande = $dateDemande; }
        public function setDateValidation($dateValidation) { $this->dateValidation = $dateValidation; }
        
        // CRUD Operations
        public static function getAll() {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM pret");
            $types = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $types[] = new Pret(
                    $row['id'],
                    $row['id_client'],
                    $row['id_user_demandeur'],
                    $row['id_user_validateur'],
                    $row['id_type_pret'],
                    $row['montant_pret'],
                    $row['montant_remboursement_par_mois'],
                    $row['montant_total_remboursement'],
                    $row['duree_remboursement'],
                    $row['status'],
                    $row['taux'],
                    $row['date_demande'],
                    $row['date_validation'],
                );
            }
            return $types;
        }
    }
?>

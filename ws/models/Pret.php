<?php

    require_once __DIR__ . '/../inc/db.php';
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
        private $assurance;
        private $dateDemande;
        private $dateValidation;

        public function __construct($id, $idClient, $idUserDemandeur, $idUserValidateur, $idTypePret, 
                                    $montantPret, $montantRemboursementParMois, $montantTotalRemboursement, 
                                    $dureeRemboursement, $status, $taux, $assurance, $dateDemande, $dateValidation) {
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
            $this->assurance = $assurance;
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
        public function getAssurance() { return $this->assurance; }
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
        public function setAssurance($assurance) { $this->assurance = $assurance; }
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
                    $row['assurance'],
                    $row['date_demande'],
                    $row['date_validation'],
                );
            }
            return $types;
        }

        public function getMontantInteret(): float {
            $interetAnnuel = $this->getMontantPret() * $this->getTaux();
            return $interetAnnuel / $this->getDureeRemboursement();
        }

        /**
         * Calcule le tableau d'amortissement complet du prêt
         * @return array - Tableau des mensualités avec détail capital/intérêt
         */
        public function calculerTableauAmortissement(): array {
            $tauxMensuel = $this->taux / 12 / 100;
            $mensualite = $this->calculerMensualite();
            $capitalRestant = $this->montantPret;
            $tableau = [];
            $date = new DateTime($this->dateValidation);

            for ($mois = 1; $mois <= $this->dureeRemboursement; $mois++) {
                $date->modify('+1 month');
                $interetMensuel = $capitalRestant * $tauxMensuel;
                $capitalRembourse = $mensualite - $interetMensuel;
                
                // Ajustement pour la dernière mensualité
                if ($mois === $this->dureeRemboursement) {
                    $capitalRembourse = $capitalRestant;
                    $mensualite = $capitalRembourse + $interetMensuel;
                }

                $tableau[] = [
                    'mois' => $mois,
                    'date' => $date->format('Y-m-d'),
                    'mensualite' => round($mensualite, 2),
                    'capital' => round($capitalRembourse, 2),
                    'interet' => round($interetMensuel, 2),
                    'capital_restant' => round($capitalRestant - $capitalRembourse, 2)
                ];

                $capitalRestant -= $capitalRembourse;
            }

            return $tableau;
        }

        /**
         * Calcule les intérêts pour un mois spécifique
         * @param int $mois - Numéro du mois (1 à durée)
         * @return float - Montant des intérêts
         */
        public function calculerInteretPourMois(int $mois): float {
            if ($mois < 1 || $mois > $this->dureeRemboursement) {
                throw new InvalidArgumentException("Mois invalide");
            }

            $tauxMensuel = $this->taux / 12 / 100;
            $mensualite = $this->calculerMensualite();
            $capitalRestant = $this->montantPret;

            for ($m = 1; $m < $mois; $m++) {
                $interet = $capitalRestant * $tauxMensuel;
                $capitalRembourse = $mensualite - $interet;
                $capitalRestant -= $capitalRembourse;
            }

            return round($capitalRestant * $tauxMensuel, 2);
        }

        /**
         * Récupère un prêt par son ID
         * @param int $id - ID du prêt
         * @return Pret|null - Objet Pret ou null si non trouvé
         */
        public static function getById(int $id): ?Pret {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM pret WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                return new Pret(
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
                    $row['assurance'],
                    $row['date_demande'],
                    $row['date_validation']
                );
            }
            return null;
        }

        /**
         * Crée une nouvelle demande de prêt avec calcul automatique des mensualités
         * @param Pret $pret - Objet Pret à créer
         * @return int - ID du nouveau prêt
         */
        public static function demanderPret(Pret $pret) {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO pret (id_client, 
                                                           id_user_demandeur, 
                                                           id_type_pret, 
                                                           montant_pret, 
                                                           duree_remboursement,
                                                           taux,
                                                           assurance,
                                                           date_demande) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $pret->getIdClient(),
                $pret->getIdUserDemandeur(),
                $pret->getIdTypePret(),
                $pret->getMontantPret(),
                $pret->getDureeRemboursement(),
                $pret->getTaux(),
                $pret->getAssurance(),
                $pret->getDateDemande(),
            ]);
            return $db->lastInsertId();
        }

        
        /**
         * Calcule la mensualité du prêt
         * @return float - Montant de la mensualité
         */
        public function calculerMensualite(): float {
            // Conversion du taux annuel en taux mensuel (décimal)
            $tauxMensuel = $this->getTaux() / 12 / 100;
            
            // Calcul du nombre de mensualités (la durée est déjà en mois selon votre table)
            $nbMensualites = $this->getDureeRemboursement();
            
            // Cas particulier pour les prêts sans intérêt
            if ($tauxMensuel == 0) {
                return round($this->getMontantPret() / $nbMensualites, 2);
            }
            
            // Calcul standard
            $mensualite = ($this->getMontantPret() * $tauxMensuel * pow(1 + $tauxMensuel, $nbMensualites)) 
                        / (pow(1 + $tauxMensuel, $nbMensualites) - 1);
            
            return round($mensualite, 2);
        }

        /**
         * Calcule le montant total à rembourser
         * @return float - Montant total avec intérêts
         */
        public function calculerMontantTotal(): float {
            $mensualite = $this->calculerMensualite();
            return round($mensualite * $this->dureeRemboursement, 2);
        }

        /**
         * Valide et enregistre un prêt avec calcul automatique des montants
         * @param int $idValidateur - ID de l'utilisateur validant le prêt
         * @return bool - True si la validation a réussi
         */
        public function validerPret(int $idValidateur): bool {
            $this->idUserValidateur = $idValidateur;
            $this->montantRemboursementParMois = $this->calculerMensualite();
            $this->montantTotalRemboursement = $this->calculerMontantTotal();
            $this->status = 'valide';
            $this->dateValidation = date('Y-m-d H:i:s');

            $db = getDB();
            $stmt = $db->prepare("UPDATE pret SET 
                                id_user_validateur = ?,
                                montant_remboursement_par_mois = ?,
                                montant_total_remboursement = ?,
                                status = ?,
                                date_validation = ?
                                WHERE id = ?");
            
            return $stmt->execute([
                $this->idUserValidateur,
                $this->montantRemboursementParMois,
                $this->montantTotalRemboursement,
                $this->status,
                $this->dateValidation,
                $this->id
            ]);
        }
        
        /**
         * Refuser et enregistre un prêt avec calcul automatique des montants
         * @param int $idValidateur - ID de l'utilisateur refusant le prêt
         * @return bool - True si le refus a réussi
         */
        public function refuserPret(int $idValidateur): bool {
            $this->idUserValidateur = $idValidateur;
            $this->montantRemboursementParMois = $this->calculerMensualite();
            $this->montantTotalRemboursement = $this->calculerMontantTotal();
            $this->status = 'refuse';
            $this->dateValidation = date('Y-m-d H:i:s');

            $db = getDB();
            $stmt = $db->prepare("UPDATE pret SET 
                                id_user_validateur = ?,
                                montant_remboursement_par_mois = ?,
                                montant_total_remboursement = ?,
                                status = ?,
                                date_validation = ?
                                WHERE id = ?");
            
            return $stmt->execute([
                $this->idUserValidateur,
                $this->montantRemboursementParMois,
                $this->montantTotalRemboursement,
                $this->status,
                $this->dateValidation,
                $this->id
            ]);
        }



    }
?>

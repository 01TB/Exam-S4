<?php
    require_once __DIR__ . '/../inc/db.php';

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

        // CRUD Operations
        public static function getAll() {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM depot");
            $depots = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $depots[] = new Depot(
                    $row['id'],
                    $row['id_user'],
                    $row['nom_investisseur'],
                    $row['montant'],
                    $row['date_depot'],
                    $row['description']
                );
            }
            return $depots;
        }

        public static function getById($id) {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM depot WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Depot(
                    $row['id'],
                    $row['id_user'],
                    $row['nom_investisseur'],
                    $row['montant'],
                    $row['date_depot'],
                    $row['description']
                );
            }
            return null;
        }

        public static function create(Depot $depot) {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO depot (id_user, nom_investisseur, montant, date_depot, description) 
                                VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $depot->getIdUser(),
                $depot->getNomInvestisseur(),
                $depot->getMontant(),
                $depot->getDateDepot(),
                $depot->getDescription()
            ]);
            return $db->lastInsertId();
        }

        public static function update(Depot $depot) {
            $db = getDB();
            $stmt = $db->prepare("UPDATE depot SET 
                                id_user = ?, 
                                nom_investisseur = ?, 
                                montant = ?, 
                                date_depot = ?, 
                                description = ? 
                                WHERE id = ?");
            $stmt->execute([
                $depot->getIdUser(),
                $depot->getNomInvestisseur(),
                $depot->getMontant(),
                $depot->getDateDepot(),
                $depot->getDescription(),
                $depot->getId()
            ]);
        }

        public static function delete($id) {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM depot WHERE id = ?");
            $stmt->execute([$id]);
        }

        /**
         * Calcule le solde disponible de l'établissement financier
         * @param string $date - Date au format YYYY-MM-DD
         * @return float - Montant disponible (dépôts - prêts validés)
         */
        public static function calculerSoldeDisponible(string $date): float {
            $db = getDB();
 
            $realDate = new DateTime($date);

            // Récupérer le mois (format numérique, ex. : "07")
            $mois = $realDate->format('m');

            // Récupérer l'année (ex. : "2025")
            $annee = $realDate->format('Y');
            
            // Calcul du total des dépôts
            $stmtDepots = $db->prepare("SELECT SUM(montant) as total_depots 
                                    FROM depot 
                                    WHERE date_depot <= ?");
            $stmtDepots->execute([$date]);
            $totalDepots = (float)$stmtDepots->fetch(PDO::FETCH_ASSOC)['total_depots'] ?? 0;
            
            // Calcul du total des prêts validés
            $stmtPrets = $db->prepare("SELECT SUM(montant_pret) as total_prets 
                                    FROM pret 
                                    WHERE status = 'valide' 
                                    AND date_validation <= ?");
            $stmtPrets->execute([$date]);
            $totalPrets = (float)$stmtPrets->fetch(PDO::FETCH_ASSOC)['total_prets'] ?? 0;

            $stmtRemboursement = $db->prepare("SELECT SUM(montant_rembourse) as total_remboursement 
                                    FROM remboursement 
                                    WHERE date_remboursement <= ?");
            $stmtRemboursement->execute([$date]);
            $totalRemboursement = (float)$stmtRemboursement->fetch(PDO::FETCH_ASSOC)['total_remboursement'] ?? 0;

            $stmtAssurance = $db->prepare("SELECT SUM(montant) as total_Assurance 
                                    FROM Assurance_pret_periode app
                                    WHERE app.mois<=month(?) AND app.annee<=year(?)");
            $stmtAssurance->execute([$mois, $annee]);
            $totalAssurance = (float)$stmtAssurance->fetch(PDO::FETCH_ASSOC)['total_Assurance'] ?? 0;
            
            return round($totalDepots - $totalPrets+$totalRemboursement-$totalAssurance, 2);
        }

        // Calcul du solde au 31 décembre 2023
        // $solde = Depot::calculerSoldeDisponible('2023-12-31');
        // echo "Solde disponible : " . number_format($solde, 2, ',', ' ') . " €";

        public static function getMontantDispo($moisDebut,$moisFin,$anneeDebut,$anneeFin){
            try {
                $db = getDB();
            
                // Construction dynamique de la requête
                $sql = "SELECT *  
                        FROM vw_tresorerie_mensuelle vwtm
                        ";
                
                $params = [];
                $m=0;
                
                // Ajout des conditions seulement si les paramètres ne sont pas null
                if ($moisDebut !== null && $moisFin !== null) {
                    $sql .= " WHERE  vwtm.mois BETWEEN :moisDebut AND :moisFin";
                    $params[':moisDebut'] = $moisDebut;
                    $params[':moisFin'] = $moisFin;
                    $m=1;
                }
                
                if ($anneeDebut !== null && $anneeFin !== null) {
                    if($m==0){
                        $sql .= " WHERE vwtm.annee BETWEEN :anneeDebut AND :anneeFin";
                    }
                    else{
                        $sql .= " AND vwtm.annee BETWEEN :anneeDebut AND :anneeFin";
                    }
                    $params[':anneeDebut'] = $anneeDebut;
                    $params[':anneeFin'] = $anneeFin;
                }
                
                
                $stmt = $db->prepare($sql);
                
                // Liaison des paramètres
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, PDO::PARAM_INT);
                }
                
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
?>
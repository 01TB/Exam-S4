<?php
    require_once __DIR__ . '../inc/db.php';

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

        // CRUD Operations
        public static function getAll() {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM type_pret");
            $types = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $types[] = new TypePret(
                    $row['id'],
                    $row['nom'],
                    $row['montant_max'],
                    $row['montant_min'],
                    $row['duree_remboursement_max'],
                    $row['duree_remboursement_min'],
                    $row['taux']
                );
            }
            return $types;
        }

        public static function getById($id) {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM type_pret WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new TypePret(
                    $row['id'],
                    $row['nom'],
                    $row['montant_max'],
                    $row['montant_min'],
                    $row['duree_remboursement_max'],
                    $row['duree_remboursement_min'],
                    $row['taux']
                );
            }
            return null;
        }

        public static function create(TypePret $typePret) {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO type_pret (nom, montant_max, montant_min, duree_remboursement_max, duree_remboursement_min, taux) 
                                VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $typePret->getNom(),
                $typePret->getMontantMax(),
                $typePret->getMontantMin(),
                $typePret->getDureeRemboursementMax(),
                $typePret->getDureeRemboursementMin(),
                $typePret->getTaux()
            ]);
            return $db->lastInsertId();
        }

        public static function update(TypePret $typePret) {
            $db = getDB();
            $stmt = $db->prepare("UPDATE type_pret SET 
                                nom = ?, 
                                montant_max = ?, 
                                montant_min = ?, 
                                duree_remboursement_max = ?, 
                                duree_remboursement_min = ?, 
                                taux = ? 
                                WHERE id = ?");
            $stmt->execute([
                $typePret->getNom(),
                $typePret->getMontantMax(),
                $typePret->getMontantMin(),
                $typePret->getDureeRemboursementMax(),
                $typePret->getDureeRemboursementMin(),
                $typePret->getTaux(),
                $typePret->getId()
            ]);
        }

        public static function delete($id) {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM type_pret WHERE id = ?");
            $stmt->execute([$id]);
        }
    }
?>
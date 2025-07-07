<?php
    require_once __DIR__ . '../inc/db.php';

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
    }
?>
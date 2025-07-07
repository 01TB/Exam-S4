<?php
    require_once __DIR__ . '/../inc/db.php';

    class Departement {
        private $id;
        private $nom;

        public function __construct($id, $nom) {
            $this->id = $id;
            $this->nom = $nom;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getNom() { return $this->nom; }

        // CRUD Operations
        public static function getAll() {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM departement");
            $departements = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $departements[] = new Departement($row['id'], $row['nom']);
            }
            return $departements;
        }

        public static function getById($id) {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM departement WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? new Departement($row['id'], $row['nom']) : null;
        }

        public static function create(Departement $departement) {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO departement (nom) VALUES (?)");
            $stmt->execute([$departement->getNom()]);
            return $db->lastInsertId();
        }

        public static function update(Departement $departement) {
            $db = getDB();
            $stmt = $db->prepare("UPDATE departement SET nom = ? WHERE id = ?");
            $stmt->execute([$departement->getNom(), $departement->getId()]);
        }

        public static function delete($id) {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM departement WHERE id = ?");
            $stmt->execute([$id]);
        }
    }
?>
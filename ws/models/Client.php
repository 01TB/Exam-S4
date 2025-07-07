<?php
    require_once __DIR__ . '../inc/db.php';

    class Client {
        private $id;
        private $nom;
        private $prenom;

        public function __construct($id, $nom, $prenom) {
            $this->id = $id;
            $this->nom = $nom;
            $this->prenom = $prenom;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getNom() { return $this->nom; }
        public function getPrenom() { return $this->prenom; }

        // CRUD Operations
        public static function getAll() {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM client");
            $clients = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $clients[] = new Client($row['id'], $row['nom'], $row['prenom']);
            }
            return $clients;
        }

        public static function getById($id) {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM client WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? new Client($row['id'], $row['nom'], $row['prenom']) : null;
        }

        public static function create(Client $client) {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO client (nom, prenom) VALUES (?, ?)");
            $stmt->execute([$client->getNom(), $client->getPrenom()]);
            return $db->lastInsertId();
        }

        public static function update(Client $client) {
            $db = getDB();
            $stmt = $db->prepare("UPDATE client SET nom = ?, prenom = ? WHERE id = ?");
            $stmt->execute([$client->getNom(), $client->getPrenom(), $client->getId()]);
        }

        public static function delete($id) {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM client WHERE id = ?");
            $stmt->execute([$id]);
        }
    }
?>
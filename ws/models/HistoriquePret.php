<?php
    require_once __DIR__ . '/../inc/db.php';

    class HistoriquePret {
        private $id;
        private $idUser;
        private $idPret;
        private $etat;
        private $dateModif;

        public function __construct($id, $idUser, $idPret, $etat, $dateModif) {
            $this->id = $id;
            $this->idUser = $idUser;
            $this->idPret = $idPret;
            $this->etat = $etat;
            $this->dateModif = $dateModif;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getIdUser() { return $this->idUser; }
        public function getIdPret() { return $this->idPret; }
        public function getEtat() { return $this->etat; }
        public function getDateModif() { return $this->dateModif; }

        // CRUD Operations
        public static function getAll() {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM historique_pret");
            $historiques = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $historiques[] = new HistoriquePret(
                    $row['id'],
                    $row['id_user'],
                    $row['id_pret'],
                    $row['etat'],
                    $row['date_modif']
                );
            }
            return $historiques;
        }

        public static function getById($id) {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM historique_pret WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? new HistoriquePret(
                $row['id'],
                $row['id_user'],
                $row['id_pret'],
                $row['etat'],
                $row['date_modif']
            ) : null;
        }

        public static function create(HistoriquePret $historique) {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO historique_pret (id_user, id_pret, etat, date_modif) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $historique->getIdUser(),
                $historique->getIdPret(),
                $historique->getEtat(),
                $historique->getDateModif()
            ]);
            return $db->lastInsertId();
        }

        public static function getByPretId($idPret) {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM historique_pret WHERE id_pret = ? ORDER BY date_modif DESC");
            $stmt->execute([$idPret]);
            $historiques = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $historiques[] = new HistoriquePret(
                    $row['id'],
                    $row['id_user'],
                    $row['id_pret'],
                    $row['etat'],
                    $row['date_modif']
                );
            }
            return $historiques;
        }
    }
?>
<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/Pret.php';

class Assurance {
    private $idPret;
    private $montant;
    private $mois;
    private $annee;

    public function __construct($idPret, $montant, $mois, $annee) {
        $this->idPret = $idPret;
        $this->montant = $montant;
        $this->mois = $mois;
        $this->annee = $annee;
    }

    // Getters
    public function getIdPret() { return $this->idPret; }
    public function getMontant() { return $this->montant; }
    public function getMois() { return $this->mois; }
    public function getAnnee() { return $this->annee; }

    // CRUD Operations
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM assurance_pret_periode");
        $assurances = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $assurances[] = new Assurance(
                $row['id_pret'],
                $row['montant'],
                $row['mois'],
                $row['annee']
            );
        }
        return $assurances;
    }

    public static function getByPret($idPret) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM assurance_pret_periode WHERE id_pret = ?");
        $stmt->execute([$idPret]);
        $assurances = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $assurances[] = new Assurance(
                $row['id_pret'],
                $row['montant'],
                $row['mois'],
                $row['annee']
            );
        }
        return $assurances;
    }

    public static function getByPeriode($mois, $annee) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM assurance_pret_periode WHERE mois = ? AND annee = ?");
        $stmt->execute([$mois, $annee]);
        $assurances = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $assurances[] = new Assurance(
                $row['id_pret'],
                $row['montant'],
                $row['mois'],
                $row['annee']
            );
        }
        return $assurances;
    }

    public static function create(Assurance $assurance) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO assurance_pret_periode 
                            (id_pret, montant, mois, annee) 
                            VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $assurance->getIdPret(),
            $assurance->getMontant(),
            $assurance->getMois(),
            $assurance->getAnnee()
        ]);
        return $db->lastInsertId();
    }

    public static function update(Assurance $assurance) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE assurance_pret_periode SET 
                            montant = ? 
                            WHERE id_pret = ? AND mois = ? AND annee = ?");
        $stmt->execute([
            $assurance->getMontant(),
            $assurance->getIdPret(),
            $assurance->getMois(),
            $assurance->getAnnee()
        ]);
    }

    public static function delete($idPret, $mois, $annee) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM assurance_pret_periode 
                            WHERE id_pret = ? AND mois = ? AND annee = ?");
        $stmt->execute([$idPret, $mois, $annee]);
    }
    

    /**
     * Calcule le capital restant dû pour un prêt à une période donnée
     */
    
}
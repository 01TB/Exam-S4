<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/Pret.php';
require_once __DIR__ . '/InteretPretPeriode.php';

class Remboursement {
    private $id;
    private $idPret;
    private $dateRemboursement;
    private $moisRembourse;
    private $anneeRembourse;
    private $montantRembourse;

    public function __construct($id, $idPret, $dateRemboursement,
                                $moisRembourse, $anneeRembourse, 
                                $montantRembourse) {
        $this->id = $id;
        $this->idPret = $idPret;
        $this->dateRemboursement = $dateRemboursement;
        $this->moisRembourse = $moisRembourse;
        $this->anneeRembourse = $anneeRembourse;
        $this->montantRembourse = $montantRembourse;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getIdPret() { return $this->idPret; }
    public function getDateRemboursement() { return $this->dateRemboursement; }
    public function getMoisRembourse() { return $this->moisRembourse; }
    public function getAnneeRembourse() { return $this->anneeRembourse; }
    public function getMontantRembourse() { return $this->montantRembourse; }

    // CRUD Operations
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM remboursement");
        $remboursements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $remboursements[] = new Remboursement(
                $row['id'],
                $row['id_pret'],
                $row['date_remboursement'],
                $row['mois_rembourse'],
                $row['annee_rembourse'],
                $row['montant_rembourse']
            );
        }
        return $remboursements;
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM remboursement WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Remboursement(
            $row['id'],
            $row['id_pret'],
            $row['date_remboursement'],
            $row['mois_rembourse'],
            $row['annee_rembourse'],
            $row['montant_rembourse']
        ) : null;
    }

    public static function getByPret($idPret) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM remboursement WHERE id_pret = ?");
        $stmt->execute([$idPret]);
        $remboursements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $remboursements[] = new Remboursement(
                $row['id'],
                $row['id_pret'],
                $row['date_remboursement'],
                $row['mois_rembourse'],
                $row['annee_rembourse'],
                $row['montant_rembourse']
            );
        }
        return $remboursements;
    }

    public static function getByPeriode($mois, $annee) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM remboursement WHERE mois_rembourse = ? AND annee_rembourse = ?");
        $stmt->execute([$mois, $annee]);
        $remboursements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $remboursements[] = new Remboursement(
                $row['id'],
                $row['id_pret'],
                $row['date_remboursement'],
                $row['mois_rembourse'],
                $row['annee_rembourse'],
                $row['montant_rembourse']
            );
        }
        return $remboursements;
    }

    /**
     * Enregistre un remboursement avec l'intérêt correspondant de manière transactionnelle
     */
    public static function enregistrerRemboursement(
        Remboursement $remboursement, 
        InteretPretPeriode $interet
    ): bool {
        $db = getDB();
        $db->beginTransaction();

        try {
            // Enregistrer le remboursement
            $stmtRemb = $db->prepare("INSERT INTO remboursement 
                                    (id_pret, date_remboursement, mois_rembourse, annee_rembourse, montant_rembourse) 
                                    VALUES (?, ?, ?, ?, ?)");
            $stmtRemb->execute([
                $remboursement->getIdPret(),
                $remboursement->getDateRemboursement(),
                $remboursement->getMoisRembourse(),
                $remboursement->getAnneeRembourse(),
                $remboursement->getMontantRembourse()
            ]);

            // Enregistrer l'intérêt
            $stmtInteret = $db->prepare("INSERT INTO interet_pret_periode 
                                        (id_pret, montant, mois, annee) 
                                        VALUES (?, ?, ?, ?)");
            $stmtInteret->execute([
                $interet->getIdPret(),
                $interet->getMontant(),
                $interet->getMois(),
                $interet->getAnnee()
            ]);

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function update(Remboursement $remboursement) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE remboursement SET 
                            id_pret = ?,
                            date_remboursement = ?,
                            mois_rembourse = ?,
                            annee_rembourse = ?,
                            montant_rembourse = ?
                            WHERE id = ?");
        $stmt->execute([
            $remboursement->getIdPret(),
            $remboursement->getDateRemboursement(),
            $remboursement->getMoisRembourse(),
            $remboursement->getAnneeRembourse(),
            $remboursement->getMontantRembourse(),
            $remboursement->getId()
        ]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM remboursement WHERE id = ?");
        $stmt->execute([$id]);
    }
}
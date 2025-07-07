<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/Pret.php';

class InteretPretPeriode {
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
        $stmt = $db->query("SELECT * FROM interet_pret_periode");
        $interets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $interets[] = new InteretPretPeriode(
                $row['id_pret'],
                $row['montant'],
                $row['mois'],
                $row['annee']
            );
        }
        return $interets;
    }

    public static function getByPret($idPret) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM interet_pret_periode WHERE id_pret = ?");
        $stmt->execute([$idPret]);
        $interets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $interets[] = new InteretPretPeriode(
                $row['id_pret'],
                $row['montant'],
                $row['mois'],
                $row['annee']
            );
        }
        return $interets;
    }

    public static function getByPeriode($mois, $annee) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM interet_pret_periode WHERE mois = ? AND annee = ?");
        $stmt->execute([$mois, $annee]);
        $interets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $interets[] = new InteretPretPeriode(
                $row['id_pret'],
                $row['montant'],
                $row['mois'],
                $row['annee']
            );
        }
        return $interets;
    }

    public static function create(InteretPretPeriode $interet) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO interet_pret_periode 
                            (id_pret, montant, mois, annee) 
                            VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $interet->getIdPret(),
            $interet->getMontant(),
            $interet->getMois(),
            $interet->getAnnee()
        ]);
        return $db->lastInsertId();
    }

    public static function update(InteretPretPeriode $interet) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE interet_pret_periode SET 
                            montant = ? 
                            WHERE id_pret = ? AND mois = ? AND annee = ?");
        $stmt->execute([
            $interet->getMontant(),
            $interet->getIdPret(),
            $interet->getMois(),
            $interet->getAnnee()
        ]);
    }

    public static function delete($idPret, $mois, $annee) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM interet_pret_periode 
                            WHERE id_pret = ? AND mois = ? AND annee = ?");
        $stmt->execute([$idPret, $mois, $annee]);
    }

    public static function calculerInterets(Pret $pret, $mois, $annee): float {
        // Convertir la période (mois/année) en numéro de mois depuis le début
        $datePret = new DateTime($pret->getDateValidation());
        $dateCible = new DateTime("$annee-$mois-01");
        $diff = $datePret->diff($dateCible);
        $moisEcoules = $diff->y * 12 + $diff->m;

        if ($moisEcoules < 0 || $moisEcoules >= $pret->getDureeRemboursement()) {
            throw new InvalidArgumentException("Période invalide pour ce prêt");
        }

        return $pret->calculerInteretPourMois($moisEcoules + 1);
    }
    

    /**
     * Calcule le capital restant dû pour un prêt à une période donnée
     */
    private static function calculerCapitalRestant(Pret $pret, $mois, $annee): float {
        // Implémentez la logique de calcul du capital restant
        // Cette méthode est un exemple simplifié
        $mensualite = $pret->calculerMensualite();
        $nbMensualitesPayees = self::getNbMensualitesPayees($pret, $mois, $annee);
        
        $tauxMensuel = $pret->getTaux() / 12 / 100;
        $nbMensualitesTotal = $pret->getDureeRemboursement();
        
        if ($tauxMensuel == 0) {
            return $pret->getMontantPret() - ($nbMensualitesPayees * $mensualite);
        }
        
        $capitalRestant = $pret->getMontantPret() * 
                        (pow(1 + $tauxMensuel, $nbMensualitesTotal) - pow(1 + $tauxMensuel, $nbMensualitesPayees)) / 
                        (pow(1 + $tauxMensuel, $nbMensualitesTotal) - 1);
        
        return round($capitalRestant, 2);
    }

    private static function getNbMensualitesPayees(Pret $pret, $mois, $annee): int {
        // Implémentez la logique pour déterminer combien de mensualités ont été payées
        // jusqu'à la période donnée
        // Cette méthode est un exemple simplifié
        $datePret = new DateTime($pret->getDateValidation());
        $dateCible = new DateTime("$annee-$mois-01");
        $interval = $datePret->diff($dateCible);
        return $interval->m + ($interval->y * 12);
    }
}
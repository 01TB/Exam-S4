<?php
require_once __DIR__ . '/../models/Remboursement.php';
require_once __DIR__ . '/../models/Pret.php';
require_once __DIR__ . '/../models/InteretPretPeriode.php';

class RemboursementController {
    public static function getAll() {
        $remboursements = Remboursement::getAll();
        Flight::json(array_map(function($r) {
            return [
                'id' => $r->getId(),
                'id_pret' => $r->getIdPret(),
                'date_remboursement' => $r->getDateRemboursement(),
                'mois_rembourse' => $r->getMoisRembourse(),
                'annee_rembourse' => $r->getAnneeRembourse(),
                'montant_rembourse' => $r->getMontantRembourse()
            ];
        }, $remboursements));
    }

    public static function getById($id) {
        $remboursement = Remboursement::getById($id);
        if ($remboursement) {
            Flight::json([
                'id' => $remboursement->getId(),
                'id_pret' => $remboursement->getIdPret(),
                'date_remboursement' => $remboursement->getDateRemboursement(),
                'mois_rembourse' => $remboursement->getMoisRembourse(),
                'annee_rembourse' => $remboursement->getAnneeRembourse(),
                'montant_rembourse' => $remboursement->getMontantRembourse()
            ]);
        } else {
            Flight::halt(404, 'Remboursement non trouvé');
        }
    }

    public static function getByPret($idPret) {
        $remboursements = Remboursement::getByPret($idPret);
        Flight::json(array_map(function($r) {
            return [
                'id' => $r->getId(),
                'id_pret' => $r->getIdPret(),
                'date_remboursement' => $r->getDateRemboursement(),
                'mois_rembourse' => $r->getMoisRembourse(),
                'annee_rembourse' => $r->getAnneeRembourse(),
                'montant_rembourse' => $r->getMontantRembourse()
            ];
        }, $remboursements));
    }

    public static function getByPeriode($mois, $annee) {
        $remboursements = Remboursement::getByPeriode($mois, $annee);
        Flight::json(array_map(function($r) {
            return [
                'id' => $r->getId(),
                'id_pret' => $r->getIdPret(),
                'date_remboursement' => $r->getDateRemboursement(),
                'mois_rembourse' => $r->getMoisRembourse(),
                'annee_rembourse' => $r->getAnneeRembourse(),
                'montant_rembourse' => $r->getMontantRembourse()
            ];
        }, $remboursements));
    }

    public static function create() {
        $data = Flight::request()->data;
        
        // Créer l'objet Remboursement
        $remboursement = new Remboursement(
            null,
            $data->id_pret,
            $data->date_remboursement ?? date('Y-m-d H:i:s'),
            $data->mois_rembourse,
            $data->annee_rembourse,
            $data->montant_rembourse
        );

        // Récupérer le prêt pour calculer les intérêts
        $pret = Pret::getById($data->id_pret);
        if (!$pret) {
            Flight::halt(404, 'Prêt non trouvé');
        }

        // Calculer les intérêts pour la période
        $montantInteret = InteretPretPeriode::calculerInterets($pret, $data->mois_rembourse, $data->annee_rembourse);
        $interet = new InteretPretPeriode(
            $data->id_pret,
            $montantInteret,
            $data->mois_rembourse,
            $data->annee_rembourse
        );

        // Enregistrement transactionnel
        $success = Remboursement::enregistrerRemboursement($remboursement, $interet);
        
        if ($success) {
            Flight::json([
                'message' => 'Remboursement et intérêt enregistrés',
                'montant_rembourse' => $remboursement->getMontantRembourse(),
                'montant_interet' => $interet->getMontant()
            ], 201);
        } else {
            Flight::halt(500, 'Erreur lors de l\'enregistrement transactionnel');
        }
    }

    public static function update($id) {
        $data = Flight::request()->data;
        $remboursement = new Remboursement(
            $id,
            $data->id_pret,
            $data->date_remboursement,
            $data->mois_rembourse,
            $data->annee_rembourse,
            $data->montant_rembourse
        );
        Remboursement::update($remboursement);
        Flight::json(['message' => 'Remboursement mis à jour']);
    }

    public static function delete($id) {
        Remboursement::delete($id);
        Flight::json(['message' => 'Remboursement supprimé']);
    }
}
<?php
require_once __DIR__ . '/../models/InteretPretPeriode.php';
require_once __DIR__ . '/../models/Pret.php';

class InteretPretPeriodeController {
    public static function getByPret($idPret) {
        $interets = InteretPretPeriode::getByPret($idPret);
        Flight::json(array_map(function($i) {
            return [
                'id_pret' => $i->getIdPret(),
                'montant' => $i->getMontant(),
                'mois' => $i->getMois(),
                'annee' => $i->getAnnee()
            ];
        }, $interets));
    }

    public static function getByPeriode($mois, $annee) {
        $interets = InteretPretPeriode::getByPeriode($mois, $annee);
        Flight::json(array_map(function($i) {
            return [
                'id_pret' => $i->getIdPret(),
                'montant' => $i->getMontant(),
                'mois' => $i->getMois(),
                'annee' => $i->getAnnee()
            ];
        }, $interets));
    }

    public static function create() {
        $data = Flight::request()->data;
        $interet = new InteretPretPeriode(
            $data->id_pret,
            $data->montant,
            $data->mois,
            $data->annee
        );
        $id = InteretPretPeriode::create($interet);
        Flight::json(['message' => 'Intérêt enregistré'], 201);
    }

    public static function update($idPret, $mois, $annee) {
        $data = Flight::request()->data;
        $interet = new InteretPretPeriode(
            $idPret,
            $data->montant,
            $mois,
            $annee
        );
        InteretPretPeriode::update($interet);
        Flight::json(['message' => 'Intérêt mis à jour']);
    }

    public static function delete($idPret, $mois, $annee) {
        InteretPretPeriode::delete($idPret, $mois, $annee);
        Flight::json(['message' => 'Intérêt supprimé']);
    }

    public static function calculerInterets($idPret, $mois, $annee) {
        $pret = Pret::getById($idPret);
        if (!$pret) {
            Flight::halt(404, 'Prêt non trouvé');
        }

        $montant = InteretPretPeriode::calculerInterets($pret, $mois, $annee);
        Flight::json([
            'id_pret' => $idPret,
            'mois' => $mois,
            'annee' => $annee,
            'montant_interet' => $montant
        ]);
    }
}
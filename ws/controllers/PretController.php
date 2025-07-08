<?php
require_once __DIR__ . '/../models/Pret.php';
require_once __DIR__ . '/../models/Depot.php';

class PretController
{

    public static function getAllEnCours()
    {
        header('Content-Type: application/json');
        try {
            $data = Pret::getAllEncours();
            $sending = [];
            $i = 0;
            foreach ($data as $key) {
                $sending[$i] = $key;
                $i++;
            }
            Flight::json($sending);
        } catch (\Throwable $th) {
            Flight::json(['error' => $th->getMessage()]);
        }
    }

    public static function demanderPret()
    {
        $data = Flight::request()->data;
        $demandePret = new Pret(
            null,
            $data->id_client,
            $data->id_user_demandeur,
            null,
            $data->id_type_pret,
            $data->montant_pret,
            null,
            null,
            $data->duree_remboursement,
            null,
            $data->taux,
            $data->assurance,
            $data->date_demande ?? date('Y-m-d H:i:s'),
            null
        );
        $id = Pret::demanderPret($demandePret);
        Flight::json(['message' => 'Demande de prêt transféré', 'id' => $id], 201);
    }

    public static function validerPret()
    {
        $data = Flight::request()->data;
        $solde_actuelle = Depot::calculerSoldeDisponible($data->date_actuelle ?? date('Y-m-d H:i:s'));
        $pret = Pret::getById($data->id_pret);
        if ($solde_actuelle >= $pret->getMontantPret()) {
            $pret->validerPret($data->id_validateur);
            Flight::json(['message' => 'Validation du prêt réussi', "id" => $pret->getId()], 201);
        } else {
            Flight::halt(404, "Solde insuffisante de pour faire le prêt");
        }
    }
    public static function refuserPret()
    {
        $data = Flight::request()->data;
        $pret = Pret::getById($data->id_pret);
        if ($pret) {
            $pret->refuserPret($data->id_validateur);
            Flight::json(['message' => 'Prêt refusé avec succès', 'id' => $pret->getId()], 201);
        } else {
            Flight::halt(404, "Prêt non trouvé");
        }
    }
}

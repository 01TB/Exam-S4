<?php
    require_once __DIR__ . '/../models/Pret.php';
    require_once __DIR__ . '/../models/Depot.php';

    class PretController {

        public static function demanderPret(){
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
                $data->date_demande,
                null
            );
            $id = Pret::demanderPret($demandePret);
            Flight::json(['message' => 'Demande de prêt transféré', 'id' => $id], 201);
        }

        public static function validePret(){
            $data = Flight::request()->data;
            $solde_actuelle = Depot::calculerSoldeDisponible($data->date_actuelle);
            $pret = Pret::getById($data->id_pret);
            if($solde_actuelle>=$pret->getMontantPret()){
                $pret->validerPret($data->id_validateur);
                Flight::json(['message' => 'Validation du prêt réussi', "id" => $pret->getId()], 201);
            } else {
                Flight::halt(404, "Solde insuffisante de pour faire le prêt");
            }
        }

    }
?>
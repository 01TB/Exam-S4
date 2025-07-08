<?php
require_once __DIR__ . '/../models/Depot.php';

class DepotController
{
    public static function getAll()
    {
        $depots = Depot::getAll();
        $result = [];
        foreach ($depots as $depot) {
            $result[] = [
                'id' => $depot->getId(),
                'id_user' => $depot->getIdUser(),
                'nom_investisseur' => $depot->getNomInvestisseur(),
                'montant' => $depot->getMontant(),
                'date_depot' => $depot->getDateDepot(),
                'description' => $depot->getDescription()
            ];
        }
        Flight::json($result);
    }

    public static function getById($id)
    {
        $depot = Depot::getById($id);
        if ($depot) {
            Flight::json([
                'id' => $depot->getId(),
                'id_user' => $depot->getIdUser(),
                'nom_investisseur' => $depot->getNomInvestisseur(),
                'montant' => $depot->getMontant(),
                'date_depot' => $depot->getDateDepot(),
                'description' => $depot->getDescription()
            ]);
        } else {
            Flight::halt(404, 'Dépôt non trouvé');
        }
    }

    public static function create()
    {
        $data = Flight::request()->data;
        $depot = new Depot(
            null,
            $data->id_user,
            $data->nom_investisseur,
            $data->montant,
            $data->date_depot ?? date('Y-m-d H:i:s'),
            $data->description ?? null
        );
        $id = Depot::create($depot);
        Flight::json(['message' => 'Dépôt créé', 'id' => $id], 201);
    }

    public static function update($id)
    {
        $data = Flight::request()->data;
        $existingDepot = Depot::getById($id);
        if (!$existingDepot) {
            Flight::halt(404, 'Dépôt non trouvé');
        }

        $depot = new Depot(
            $id,
            $data->id_user ?? $existingDepot->getIdUser(),
            $data->nom_investisseur ?? $existingDepot->getNomInvestisseur(),
            $data->montant ?? $existingDepot->getMontant(),
            $data->date_depot ?? $existingDepot->getDateDepot(),
            $data->description ?? $existingDepot->getDescription()
        );

        Depot::update($depot);
        Flight::json(['message' => 'Dépôt mis à jour']);
    }

    public function calculerSoldeDisponible(string $date){
        $solde = Depot::calculerSoldeDisponible($date);
        Flight::json(['message' => 'test'.$solde]);
    }

    public static function montant_total_par_mois(){
        try {
            // Récupération et validation des paramètres
            $moisDebut = isset($_GET['mois_debut']) && $_GET['mois_debut'] !== '' ? (int)$_GET['mois_debut'] : null;
            $moisFin = isset($_GET['mois_fin']) && $_GET['mois_fin'] !== '' ? (int)$_GET['mois_fin'] : null;
            $anneeDebut = isset($_GET['annee_debut']) && $_GET['annee_debut'] !== '' ? (int)$_GET['annee_debut'] : null;
            $anneeFin = isset($_GET['annee_fin']) && $_GET['annee_fin'] !== '' ? (int)$_GET['annee_fin'] : null;

            // Validation supplémentaire
            if ($moisDebut !== null && ($moisDebut < 1 || $moisDebut > 12)) {
                throw new Exception('Mois début invalide');
            }
            if ($moisFin !== null && ($moisFin < 1 || $moisFin > 12)) {
                throw new Exception('Mois fin invalide');
            }

            // Force le content-type JSON
            header('Content-Type: application/json');

            $data = Depot::getMontantDispo($moisDebut, $moisFin, $anneeDebut, $anneeFin);
            
            Flight::json($data);
            
        } catch (Exception $e) {            
            // Retourne une réponse JSON en cas d'erreur
            header('Content-Type: application/json');
            http_response_code(400); // Bad Request
            Flight::json([
                'success' => false,
                'error' => "Erreur dans Depotcontroller: " . $e->getMessage()
            ]);
        }
    }

    public static function delete($id)
    {
        $depot = Depot::getById($id);
        if (!$depot) {
            Flight::halt(404, 'Dépôt non trouvé');
        }
        Depot::delete($id);
        Flight::json(['message' => 'Dépôt supprimé']);
    }
}

<?php
    require_once __DIR__ . '../models/Depot.php';

    class DepotController {
        public static function getAll() {
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

        public static function getById($id) {
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

        public static function create() {
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

        public static function update($id) {
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

        public static function delete($id) {
            $depot = Depot::getById($id);
            if (!$depot) {
                Flight::halt(404, 'Dépôt non trouvé');
            }
            Depot::delete($id);
            Flight::json(['message' => 'Dépôt supprimé']);
        }
    }
?>
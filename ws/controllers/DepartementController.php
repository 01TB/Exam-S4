<?php
    require_once __DIR__ . '/../models/Departement.php';

    class DepartementController {
        public static function getAll() {
            $departements = Departement::getAll();
            Flight::json(array_map(function($d) {
                return ['id' => $d->getId(), 'nom' => $d->getNom()];
            }, $departements));
        }

        public static function getById($id) {
            $departement = Departement::getById($id);
            if ($departement) {
                Flight::json(['id' => $departement->getId(), 'nom' => $departement->getNom()]);
            } else {
                Flight::halt(404, 'Département non trouvé');
            }
        }

        public static function create() {
            $data = Flight::request()->data;
            $departement = new Departement(null, $data->nom);
            $id = Departement::create($departement);
            Flight::json(['message' => 'Département créé', 'id' => $id], 201);
        }

        public static function update($id) {
            $data = Flight::request()->data;
            $departement = new Departement($id, $data->nom);
            Departement::update($departement);
            Flight::json(['message' => 'Département mis à jour']);
        }

        public static function delete($id) {
            Departement::delete($id);
            Flight::json(['message' => 'Département supprimé']);
        }
    }
?>
<?php
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../models/Departement.php';

    class UserController {
        public static function getAll() {
            $users = User::getAll();
            Flight::json(array_map(function($u) {
                return [
                    'id' => $u->getId(),
                    'departement' => Departement::getById($u->getIdDepartement())->getNom(),
                    'nom' => $u->getNom(),
                    'prenom' => $u->getPrenom()
                ];
            }, $users));
        }

        public static function getById($id) {
            $user = User::getById($id);
            if ($user) {
                Flight::json([
                    'id' => $user->getId(),
                    'departement' => Departement::getById($user->getIdDepartement())->getNom(),
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom()
                ]);
            } else {
                Flight::halt(404, 'Utilisateur non trouvé');
            }
        }

        public static function create() {
            $data = Flight::request()->data;
            $user = new User(
                null,
                $data->id_departement,
                $data->nom,
                $data->prenom,
                $data->password
            );
            $id = User::create($user);
            Flight::json(['message' => 'Utilisateur créé', 'id' => $id], 201);
        }

        public static function update($id) {
            $data = Flight::request()->data;
            $user = new User(
                $id,
                $data->id_departement,
                $data->nom,
                $data->prenom,
                $data->password
            );
            User::update($user);
            Flight::json(['message' => 'Utilisateur mis à jour']);
        }

        public static function delete($id) {
            User::delete($id);
            Flight::json(['message' => 'Utilisateur supprimé']);
        }
    }
?>
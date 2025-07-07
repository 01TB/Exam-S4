<?php
    require_once __DIR__ . '/../models/Client.php';

    class ClientController {
        public static function getAll() {
            $clients = Client::getAll();
            Flight::json(array_map(function($c) {
                return [
                    'id' => $c->getId(),
                    'nom' => $c->getNom(),
                    'prenom' => $c->getPrenom()
                ];
            }, $clients));
        }

        public static function getById($id) {
            $client = Client::getById($id);
            if ($client) {
                Flight::json([
                    'id' => $client->getId(),
                    'nom' => $client->getNom(),
                    'prenom' => $client->getPrenom()
                ]);
            } else {
                Flight::halt(404, 'Client non trouvé');
            }
        }

        public static function create() {
            $data = Flight::request()->data;
            $client = new Client(null, $data->nom, $data->prenom);
            $id = Client::create($client);
            Flight::json(['message' => 'Client créé', 'id' => $id], 201);
        }

        public static function update($id) {
            $data = Flight::request()->data;
            $client = new Client($id, $data->nom, $data->prenom);
            Client::update($client);
            Flight::json(['message' => 'Client mis à jour']);
        }

        public static function delete($id) {
            Client::delete($id);
            Flight::json(['message' => 'Client supprimé']);
        }
    }
?>
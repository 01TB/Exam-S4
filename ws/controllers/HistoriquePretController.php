<?php
    require_once __DIR__ . '/../models/HistoriquePret.php';
    require_once __DIR__ . '/../models/User.php';

    class HistoriquePretController {
        public static function getByPretId($idPret) {
            $historiques = HistoriquePret::getByPretId($idPret);
            $result = [];
            foreach ($historiques as $h) {
                $user = User::getById($h->getIdUser());
                $result[] = [
                    'id' => $h->getId(),
                    'user' => $user ? $user->getNom() . ' ' . $user->getPrenom() : 'Inconnu',
                    'etat' => $h->getEtat(),
                    'date_modif' => $h->getDateModif()
                ];
            }
            Flight::json($result);
        }

        public static function create() {
            $data = Flight::request()->data;
            $historique = new HistoriquePret(
                null,
                $data->id_user,
                $data->id_pret,
                $data->etat,
                date('Y-m-d H:i:s')
            );
            $id = HistoriquePret::create($historique);
            Flight::json(['message' => 'Historique enregistré', 'id' => $id], 201);
        }
    }
?>
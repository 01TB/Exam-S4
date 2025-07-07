<?php
    require_once __DIR__ . '/../models/TypePret.php';

    class TypePretController {
        public static function getAll() {
            $typesPret = TypePret::getAll();
            $result = [];
            foreach ($typesPret as $type) {
                $result[] = [
                    'id' => $type->getId(),
                    'nom' => $type->getNom(),
                    'montant_max' => $type->getMontantMax(),
                    'montant_min' => $type->getMontantMin(),
                    'duree_remboursement_max' => $type->getDureeRemboursementMax(),
                    'duree_remboursement_min' => $type->getDureeRemboursementMin(),
                    'taux' => $type->getTaux()
                ];
            }
            Flight::json($result);
        }

        public static function getById($id) {
            $typePret = TypePret::getById($id);
            if ($typePret) {
                Flight::json([
                    'id' => $typePret->getId(),
                    'nom' => $typePret->getNom(),
                    'montant_max' => $typePret->getMontantMax(),
                    'montant_min' => $typePret->getMontantMin(),
                    'duree_remboursement_max' => $typePret->getDureeRemboursementMax(),
                    'duree_remboursement_min' => $typePret->getDureeRemboursementMin(),
                    'taux' => $typePret->getTaux()
                ]);
            } else {
                Flight::halt(404, 'Type de prêt non trouvé');
            }
        }

        public static function create() {
            $data = Flight::request()->data;
            $typePret = new TypePret(
                null,
                $data->nom,
                $data->montant_max,
                $data->montant_min,
                $data->duree_remboursement_max,
                $data->duree_remboursement_min,
                $data->taux
            );
            $id = TypePret::create($typePret);
            Flight::json(['message' => 'Type de prêt créé', 'id' => $id], 201);
        }

        public static function update($id) {
            $data = Flight::request()->data;
            $existingType = TypePret::getById($id);
            if (!$existingType) {
                Flight::halt(404, 'Type de prêt non trouvé');
            }

            $typePret = new TypePret(
                $id,
                $data->nom ?? $existingType->getNom(),
                $data->montant_max ?? $existingType->getMontantMax(),
                $data->montant_min ?? $existingType->getMontantMin(),
                $data->duree_remboursement_max ?? $existingType->getDureeRemboursementMax(),
                $data->duree_remboursement_min ?? $existingType->getDureeRemboursementMin(),
                $data->taux ?? $existingType->getTaux()
            );
            
            TypePret::update($typePret);
            Flight::json(['message' => 'Type de prêt mis à jour']);
        }

        public static function delete($id) {
            $typePret = TypePret::getById($id);
            if (!$typePret) {
                Flight::halt(404, 'Type de prêt non trouvé');
            }
            TypePret::delete($id);
            Flight::json(['message' => 'Type de prêt supprimé']);
        }
    }
?>
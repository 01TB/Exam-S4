<?php
require_once __DIR__.'\..\models\Interet.php';

class InteretController {
    public static function getAllIntervall() {
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

            $data = Interet::getInteretInterval($moisDebut, $moisFin, $anneeDebut, $anneeFin);
            
            Flight::json($data);
            
        } catch (Exception $e) {            
            // Retourne une réponse JSON en cas d'erreur
            header('Content-Type: application/json');
            http_response_code(400); // Bad Request
            Flight::json([
                'success' => false,
                'error' => "Erreur dans InteretController: " . $e->getMessage()
            ]);
        }
    }
}
<?php
require_once __DIR__ . '/../controllers/PretController.php';

Flight::route('POST /pret/demande', function () {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        Flight::json(['error' => 'Invalid JSON payload: ' . json_last_error_msg()], 400);
        return;
    }
    // Optionnel : Vérifiez les champs requis
    $required_fields = ['id_client', 'id_user_demandeur', 'id_type_pret', 'montant_pret', 'duree_remboursement', 'taux', 'assurance'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field])) {
            Flight::json(['error' => "Missing required field: $field"], 400);
            return;
        }
    }
    Flight::request()->data->setData($data);
    PretController::demanderPret();
});
// Flight::route('POST /pret/valide', ['PretController', 'validerPret']);
// Flight::route('POST /pret/refuse', ['PretController', 'validerPret']);
Flight::route('GET /pret/enCours', ['PretController', 'getAllEnCours']);
Flight::route('POST /pret/valide', function () {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        Flight::json(['error' => 'Invalid JSON payload: ' . json_last_error_msg()], 400);
        return;
    }
    $required_fields = ['id_pret', 'id_validateur', 'date_actuelle'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field])) {
            Flight::json(['error' => "Missing required field: $field"], 400);
            return;
        }
    }
    // Ensure numeric values
    $data['id_pret'] = (int)$data['id_pret'];
    $data['id_validateur'] = (int)$data['id_validateur'];
    Flight::request()->data->setData($data);
    PretController::validerPret();
});

Flight::route('POST /pret/refuse', function () {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        Flight::json(['error' => 'Invalid JSON payload: ' . json_last_error_msg()], 400);
        return;
    }
    $required_fields = ['id_pret', 'id_validateur'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field])) {
            Flight::json(['error' => "Missing required field: $field"], 400);
            return;
        }
    }
    // Ensure numeric values
    $data['id_pret'] = (int)$data['id_pret'];
    $data['id_validateur'] = (int)$data['id_validateur'];
    Flight::request()->data->setData($data);
    PretController::refuserPret();
});

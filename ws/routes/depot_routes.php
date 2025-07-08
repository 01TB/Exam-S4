<?php
require __DIR__ . '\..\controllers\DepotController.php';

// Flight::route('GET /depots', ['DepotController', 'getAll']);
Flight::route('GET /depots/@id', ['DepotController', 'getById']);
Flight::route('GET /solde', ['DepotController', 'montant_total_par_mois']);
Flight::route('POST /depots', ['DepotController', 'create']);
Flight::route('POST /depots/@id', ['DepotController', 'update']);
Flight::route('DELETE /depots/@id', ['DepotController', 'delete']);

// Flight::route('GET /depots', ['DepotController', 'getAll']);
Flight::route('GET /depots', function () {
    DepotController::getAll();
});

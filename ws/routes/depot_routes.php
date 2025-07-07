<?php
require_once __DIR__ . '/../controllers/DepotController.php';

Flight::route('GET tp-flight/depots', ['DepotController', 'getAll']);
Flight::route('GET /depots/@id', ['DepotController', 'getById']);
Flight::route('POST /depots', ['DepotController', 'create']);
Flight::route('PUT /depots/@id', ['DepotController', 'update']);
Flight::route('DELETE /depots/@id', ['DepotController', 'delete']);
<?php
require_once __DIR__ . '\..\controllers\TypePretController.php';

// Flight::route('GET /types_pret', ['TypePretController', 'getAll']);
Flight::route('GET /types_pret/@id', ['TypePretController', 'getById']);
Flight::route('POST /types_pret', ['TypePretController', 'create']);
Flight::route('POST /types_pret/@id', ['TypePretController', 'update']);
Flight::route('DELETE /types_pret/@id', ['TypePretController', 'delete']);


Flight::route('GET /types_pret', function () {
    TypePretController::getAll();
});

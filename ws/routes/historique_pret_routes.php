<?php
require_once __DIR__ . '/../controllers/HistoriquePretController.php';

Flight::route('GET /historique-pret/pret/@id', ['HistoriquePretController', 'getByPretId']);
Flight::route('POST /historique-pret', ['HistoriquePretController', 'create']);
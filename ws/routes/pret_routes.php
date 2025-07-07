<?php
require_once __DIR__ . '/../controllers/PretController.php';

Flight::route('POST /pret/demande', ['PretController', 'demanderPret']);
Flight::route('POST /pret/valide', ['PretController', 'validerPret']);
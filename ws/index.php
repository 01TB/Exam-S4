<?php
require 'vendor/autoload.php';
require 'inc/db.php';
$routes = [
    'depot_routes',
    'type_pret_routes',
    'departement_routes',
    'client_routes',
    'historique_pret_routes',
    'user_routes',
    'pret_routes',
    'interet_routes',
    'interet_pret_periode_routes',
    'remboursement_routes'
];

foreach ($routes as $route) {
    require 'routes/'.$route.'.php';
}


Flight::start();
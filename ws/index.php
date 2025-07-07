<?php
require 'vendor/autoload.php';
require 'inc/db.php';
$routes = [
    'depot_routes',
    'type_pret_routes'
];

foreach ($routes as $route) {
    require 'routes/'.$route.'.php';
}

require 'routes';

Flight::start();
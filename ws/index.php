<?php
require 'vendor/autoload.php';
require 'inc/db.php';
$controllers = [
    'IndexController',
    'EtudiantController'
];

foreach ($controllers as $c){
    require 'app/controllers/'.$c.'.php';
}

Flight::start();
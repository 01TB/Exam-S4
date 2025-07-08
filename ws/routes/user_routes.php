<?php
require __DIR__ . '\..\controllers\UserController.php';

Flight::route('GET /users', ['UserController', 'getAll']);
Flight::route('GET /users/@id', ['UserController', 'getById']);
Flight::route('POST /users', ['UserController', 'create']);
Flight::route('POST /users/@id', ['UserController', 'update']);
Flight::route('DELETE /users/@id', ['UserController', 'delete']);

Flight::route('POST /login', function () {
    UserController::checkLogin();
});

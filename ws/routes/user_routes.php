<?php
require __DIR__.'\..\controllers\UserController.php';

Flight::route('POST /login', function() {
    UserController::checkLogin();
});
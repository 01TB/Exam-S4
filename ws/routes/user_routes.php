<?php
require '../controllers/UserController.php';

Flight::route('POST /login', function() {
    UserController::checkLogin();
});
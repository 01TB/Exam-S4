<?php
header('Content-Type: application/json');
require __DIR__.'/../models/User.php';

class UserController {
    public static function checkLogin() {
        $user = User::checkUser($_POST['nom'],$_POST['password']);
        $message='Connexion reussie';
        if($user){
            $_SESSION['user'] = $user;
        }
        else{
            $message = 'User not found!';
        }
        Flight::json($message);
    }
}
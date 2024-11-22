<?php 

session_start();
require_once './config/config.php';
require_once './models/getUser.php';

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = getUser($username, $dpo);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
            ];
            $message = 'Connexion réussie';
        } else {
            http_response_code(401);
            $message = "Identifiants invalides";
        }
    } catch (Exception $err) {
        error_log($err->getMessage());
        $message = "Une erreur est survenue";
    }
}
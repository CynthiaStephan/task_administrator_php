<?php 

session_start();
require_once '../config/config.php';
require_once '../models/addUser.php';
require_once '../models/getUser.php';

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = $_POST['username'];
        $password = $_POST['password'];
        // if empty throw error message
        if(empty($username) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }
        // verify if user doesn't exist
        $user = getUser($username, $pdo);

        if($user){
            $message = "Ce nom d'utilisateur est deja pris.";
            // The HTTP 409 Conflict. Conflicts are most likely to occur in response to a PUT request.
            http_response_code(409);
        } else {
            // hash the password
            $password = password_hash($password, PASSWORD_DEFAULT, ['cost'=> 12]);

            addUser($username, $password, $pdo);
            
            $_SESSION['user'] = [
                'user_id' => $pdo ->lastInsertId(),
            ];

            $message = 'Inscription réussie';
        }

        
    } catch (Exception $err) {
        error_log($err->getMessage());
        $message = "Une erreur est survenue";
    }
}
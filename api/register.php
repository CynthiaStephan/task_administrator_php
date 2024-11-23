<?php

session_start();
require_once './config/config.php';
require_once './models/addUser.php';
require_once './models/getUser.php';

header('Access-Control-Allow-Origin: *');

$response = [
    'message' => 'Requête invalide',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        if (empty($username) || empty($password)) {
            http_response_code(400);
            throw new Exception("Tous les champs sont obligatoires.");
        }
        
        // check if user exist
        $user = getUser($username, $pdo);


        if (!empty($user)) {
            http_response_code(409);
            $response['message'] = "Ce nom d'utilisateur est déjà pris.";
        } else {
            // hash password
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

            // send user info the the addUser function
            addUser(username: $username, password: $passwordHashed, pdo: $pdo);
            // save user_id into session data
            $_SESSION = [
                'user_id' => $pdo->lastInsertId(),
            ];

            http_response_code(200);
            $response['message'] = 'Inscription réussie.';
        }

    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = "Une erreur est survenue lors de l'inscription.";
    }
}

// sendback $response to the front
echo json_encode($response);
exit;

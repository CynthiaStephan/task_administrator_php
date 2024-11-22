<?php 

session_start();
require_once './config/config.php';
require_once './models/addUser.php';
require_once './models/getUser.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$response = [
    'message'=> 'Requête invalide',
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
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
            $response['message'] = "Cet nom est déjà pris";
        } else {
            // hash the password
            $password = password_hash($password, PASSWORD_DEFAULT, ['cost'=> 12]);

            addUser($username, $password, $pdo);
            
            $_SESSION['user'] = [
                'user_id' => $pdo ->lastInsertId(),
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
<?php 

session_start();
require_once './config/config.php';
require_once './models/getUser.php';

header('Access-Control-Allow-Origin: *');

$response = [
    'message' => 'Requête invalide',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $user = getUser($username, $pdo);
        
        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'username'=> $user['username'],
            ];
            http_response_code(200);
            $response['message'] = 'Connexion réussie';
        } else {
            http_response_code(401);
            $response['message'] = "Identifiants invalides";
        }
    } catch (Exception $err) {
        error_log($err->getMessage());
        $response['message'] = "Une erreur est survenue";
    }
    
}
echo json_encode($response);
    exit;
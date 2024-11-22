<?php 

session_start();
require_once './config/config.php';
require_once './models/getUser.php';


$response = [
    'message' => 'Requête invalide',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        print_r($_POST);
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = getUser($username, $dpo);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
            ];
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
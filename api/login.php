<?php 

session_start();
require_once './config/config.php';
require_once './models/getUser.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/x-www-form-urlencoded');


$response = [
    'message' => 'Requête invalide',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le type de contenu est JSON
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (strpos($contentType, 'application/json') !== false) {
        // Décoder le contenu JSON brut
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $_POST = $data; // Remplir $_POST avec les données JSON décodées
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Données JSON invalides.']);
            exit;
        }
    }

    echo '<pre>';
    echo "Méthode HTTP : {$_SERVER['REQUEST_METHOD']}\n";
    echo "Contenu brut reçu :\n";
    echo file_get_contents('php://input');
    echo "\nTableau \$_POST :\n";
    print_r($_POST);
    echo '</pre>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {
        // Vérifier si les paramètres 'username' et 'password' sont dans la requête POST
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = getUser($username, $pdo);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                ];
                http_response_code(200);
                $response['message'] = 'Connexion réussie';
            } else {

                http_response_code(401);
                $response['message'] = "Identifiants invalides";
            }
        } else {

            http_response_code(400);
            $response['message'] = "Paramètres manquants (username ou password)";
        }
    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = "Une erreur est survenue";
    }
}

// Retourner la réponse JSON
echo json_encode($response);
exit;

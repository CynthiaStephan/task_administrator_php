<?php 

session_start();
require_once './config/config.php';
require_once './models/getUser.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$response = [
    'message' => 'Requête invalide',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    try {
        // Lecture des données POST au format JSON ou x-www-form-urlencoded
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            // Données envoyées au format JSON
            $username = $data['username'] ?? null;
            $password = $data['password'] ?? null;
        } else {
            // Données envoyées en x-www-form-urlencoded
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
        }

        // Vérifier si les paramètres sont fournis
        if (!empty($username) && !empty($password)) {
            // Appel à la fonction pour récupérer l'utilisateur
            $user = getUser($username, $pdo);

            if ($user && password_verify($password, $user['password'])) {
                // Stockage de l'utilisateur en session
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                ];
                http_response_code(200);
                $response['message'] = 'Connexion réussie';
            } else {
                // Identifiants incorrects
                http_response_code(401);
                $response['message'] = "Identifiants invalides";
            }
        } else {
            // Paramètres manquants
            http_response_code(400);
            $response['message'] = "Paramètres manquants (username ou password)";
        }
    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = "Une erreur est survenue";
    }
}

// Retour de la réponse JSON
echo json_encode($response);
exit;
?>

<?php 

session_start();
require_once './config/config.php';
require_once './models/getUser.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

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
    echo json_encode($response);
    exit;
} ?>
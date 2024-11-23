<?php 
session_start();

require_once './config/config.php';
require_once './models/getTasks.php';
require_once './models/addTasks.php';
require_once './models/deleteTask.php';

header('Access-Control-Allow-Origin: *');

$user_id = $_SESSION['user']['user_id'];
$response = [];


// add task

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    try{

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ??'');
        
        addTask($user_id, $title, $description, $pdo);

        http_response_code(200);
        $response['message'] = "Tâche ajoutée avec succès";

    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = "Une erreur est survenue lors de la création de la tâches";
    }
}

// Delete Task

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        parse_str(file_get_contents('php://input'), $data);
        if (isset($data['task_id'])) {
            $task_id = (int) $data['task_id'];
            deleteTask($task_id, $pdo);
        } else {
            throw new Exception("Error");
        }

    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = "Une erreur est survenue lors de la suppression de la tâches";
    }
}


// get tasks
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $tasks = getTasks($user_id, $pdo);
        // TODO: Une fois que j'ai des tâches crée faire une boucle avec la réponse.
    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = "Une erreur est survenue lors de la récupération des tâches";
    }
}

echo json_encode($response);
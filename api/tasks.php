<?php 
session_start();

require_once './config/config.php';
require_once './models/getTasks.php';
require_once './models/addTasks.php';
require_once './models/deleteTask.php';
require_once './models/editTask.php';

header('Access-Control-Allow-Origin: *');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['message' => 'Utilisateur non connecté.']);
    exit;
}

$user_id = $_SESSION['user_id'];


$response = [];

// get tasks
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $tasks = getTasks($user_id, $pdo);
        http_response_code(200);
        $response['tasks'] = $tasks;
        
    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = "Une erreur est survenue lors de la récupération des tâches";
    }
}

// add task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

// Edit task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === "complete"){
    try{
        $task_id = intval($_POST['id']);
        $completed = intval($_POST['completed']);
        editTask($task_id, $completed, $pdo);
        http_response_code(200);
        $response['message'] = "Tâche mise à jour avec succès";

    } catch (Exception $err) {  
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = 'Une erreur est survenue lors de la modification de la tâches';
    }
}

// Delete Task

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    try {
            $task_id = (int) $_GET['id'];
            deleteTask($task_id, $pdo);

            http_response_code(200);
            $response['message'] ="Tâche supprimée avec succès";


    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500);
        $response['message'] = "Une erreur est survenue lors de la suppression de la tâches";
    }
}


echo json_encode($response);
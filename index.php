<?php
require 'connectDB.php';
require 'functions.php';

header('Content-Type: application/json');

if (!isset($_GET['q'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$params = explode('/', $_GET['q']);
$type = $params[0];
$id = isset($params[1]) ? $params[1] : null;

switch ($method)
{
    case 'GET':
        if ($type === 'posts') {
            if ($id) {
                getPost($pdo, $id);
            } else {
                getPosts($pdo);
            }
        }
        break;

    case 'POST':
        if ($type === 'posts') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid JSON data']);
                exit;
            }
            addPost($pdo, $data);
        }
        break;

    case 'PATCH':
        if ($type === 'posts') {
            if ($id) {
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$data) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid JSON data']);
                    exit;
                }
                UpdatePost($pdo, $id, $data);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required']);
            }
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
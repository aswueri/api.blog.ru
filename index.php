
<?php
require 'connectDB.php';
require 'functions.php';
//die(print_r($_POST));

header('Content-Type: application/json');
$method= $_SERVER['REQUEST_METHOD'];

$params = explode( '/' , $_GET['q']);
$type = $params[0];
if (isset($params[1])){
    $id = $params[1];
}


switch ($method)
{
    case 'GET':
        if ($type==='posts') {
            if(isset($id)){
                getPost($pdo, $id);
            }else{
                getPosts($pdo);
            }
        }
        break;
    case 'POST':
        if ($type==='posts') {
            addPost($pdo, $_POST);
        }
        break;

    case 'PATCH':
        if ($type ==='posts') {
            if(isset($id)){
                $data = file_get_contents('php://input');
                $data = json_decode($data, true);
                die($data['title']);
                UpdatePost($pdo, $id, $data);
            }
        }
        break;

   case 'DELETE':
       if ($type === 'posts') {
       if (isset($id)){
       deletePost($pdo, $id);
            }
       }
       break;
}

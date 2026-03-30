<?php
function getPosts($pdo){
    $sql="SELECT * FROM `posts`";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $posts=$stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($posts, JSON_UNESCAPED_UNICODE);
}

function getPost($pdo, $id){
    $sql = "SELECT * FROM `posts` WHERE `id` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 1){
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($post, JSON_UNESCAPED_UNICODE);
    }else{
        http_response_code(404);
        $response = [
            'status' => false,
            'message' => 'post not found.'
        ];
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}

function addPost($pdo, $data){
    $sql = "INSERT INTO `posts` (`title`, `body`) VALUES (:title, :body)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    http_response_code(201);
    $response = [
        'status' => true,
        'post_id' => $pdo->lastInsertId()
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

function UpdatePost($pdo, $id, $data)
{
    $sql = "UPDATE `posts`"
        . " SET `title` = :title, `body` = :body"
        . " WHERE `id` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title' => $data['title'],
        'body' => $data['body'],
        'id' => $id
    ]);
    http_response_code(200);
    $response = [
        'status' => true,
        'post_id' => $id
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
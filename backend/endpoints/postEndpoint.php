<?php
require_once(realpath(dirname(__FILE__) . '/../services/postService.php'));

// header('Content-Type: application/json');

// $phpInput = json_decode(file_get_contents('php://input'), true);

$postService = new PostService();

function getPosts($postService) {
    return $postService->getAllPosts();
}


// echo json_encode([
//     "success" => true,
//     "message" => "List of all posts.",
//     "value" => getPosts($postService)
// ], JSON_UNESCAPED_UNICODE);

echo json_encode([
    "success" => true,
    "message" => "List of all posts.",
    "value" => getPosts($postService)
]);

?>
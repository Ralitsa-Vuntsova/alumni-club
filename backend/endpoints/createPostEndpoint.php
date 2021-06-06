<?php

require_once(realpath(dirname(__FILE__) . '/../services/postService.php'));

// session_start();

$postService = new PostService();

function getPosts($postService) {
    return $postService->getAllPosts();
}


$phpInput = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');

// function validateHours($hourFrom, $hourTo) {
//     return $hourFrom != $hourTo && $hourTo > $hourFrom 
//         && $hourFrom >= 7 && $hourFrom <= 20 && $hourTo>= 7 && $hourTo <= 20;
// }

// function validateDate($date){
//     if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
//         return false;
//     }
//     $dateSplit = explode('-', $date);
//     $myDate = strtotime($date);
//     $minDate = date('Y-m-d');
//     return checkdate($dateSplit[1], $dateSplit[2], $dateSplit[0]) && $myDate > $minDate;
// }

// if (!isset($_SESSION['username'])) {
//     echo json_encode([
//         'success' => false,
//         'message' => "Потребителят не е влязъл в системата.",
//     ]);
// } else {
//     $username = $_SESSION['username'];

//     if (empty($phpInput['hallsId']) || empty($phpInput['usersSubjectsId']) || empty($phpInput['date']) 
//     || empty($phpInput['hourFrom']) || empty($phpInput['hourTo'])) {
//         echo json_encode([
//             'success' => false,
//             'message' => "Моля, попълнете всички полета.",
//         ]);
//     } else {

$occasion = $phpInput['occasion'];
$privacy = $phpInput['privacy'];
$occasionDate = $phpInput['occasionDate'];
$location = $phpInput['location'];
$content = $phpInput['content'];

        // if(!validateHours($hourFrom, $hourTo) || !validateDate($date)) {
        //     echo json_encode([
        //         'success' => false,
        //         'message' => "Въведените данни не са валидни.",
        //     ]);
        //     exit();
        // }

        
   
            // for every hour reserve hall

$post = new Post(null, $occasion, $privacy, $occasionDate, $location, $content);
try {
    $postService->createPost($post);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
    exit();
}

echo json_encode([
    'success' => true,
    'message' => "The post is created successfuly.",
]);
 
?>
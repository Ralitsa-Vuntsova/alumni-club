<?php

// session_start();

require_once(realpath(dirname(__FILE__) . '/../entities/user.php'));
require_once(realpath(dirname(__FILE__) . '/../services/userService.php'));

// $_SESSION['test'] = "test";
// print_r($_SESSION);

$userService = new UserService();

$phpInput = json_decode(file_get_contents('php://input'), true);

if (!isset($phpInput['username']) || !isset($phpInput['password'])) {
    echo json_encode([
        'success' => false,
        'message' => "Моля, попълнете потребителско име и парола.",
    ]);
} else {

    if (empty($phpInput['username']) || empty($phpInput['password'])) {
        echo json_encode([
            'success' => false,
            'message' => "Моля, попълнете потребителско име и парола.",
        ]);
    }
    else {

        $username = $phpInput['username'];
        $password = $phpInput['password'];

        try {

            $userId = $userService->checkLogin($username, $password);
          //  echo $userId;
            $_SESSION['userId'] = $userId;
            $_SESSION['username'] = $phpInput['username'];


            echo json_encode([
                'success' => true,
                'username' => $_SESSION['username'],
            ]);
            
        } catch (Exception $e) {
            
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }  
}
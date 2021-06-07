<?php

session_start();

require_once(realpath(dirname(__FILE__) . '/../entities/user.php'));
require_once(realpath(dirname(__FILE__) . '/../services/userService.php'));

$userService = new UserService();

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

$password = $phpInput['password'];
$firstName = $phpInput['firstName'];
$lastName = $phpInput['lastName'];
$email = $phpInput['email'];

        // if(!validateHours($hourFrom, $hourTo) || !validateDate($date)) {
        //     echo json_encode([
        //         'success' => false,
        //         'message' => "Въведените данни не са валидни.",
        //     ]);
        //     exit();
        // }

        
   
            // for every hour reserve hall

$user = new User(null, null, $password, $email, $firstName, $lastName, null);
try {
    $userService->updateUser($user);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
    exit();
}

echo json_encode([
    'success' => true,
    'message' => "The user information is updated successfully.",
]);
 
?>
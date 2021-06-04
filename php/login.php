<?php
    require_once 'user.php';

    session_start();

    header('Content-Type: application/json');

    $errors = [];
    $response = [];

    if (isset($_POST)) {
        $data = json_decode($_POST['data'], true);

        $username = isset($data['username']) ? testInput($data['username']) : '';
        $password = isset($data['password']) ? testInput($data['password']) : '';

        if(!$data['username']) {
            $errors[] = 'Please enter user name';
        }

        if(!$data['password']) {
            $errors[] = 'Please enter password';
        }

        if($data['username'] && $data['password']) {
            $user = new User($data['username'], $data['password']);
            $isValid = $user->isValid();

            if($isValid['success']) {
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['userId'] = $user->getUserId();

                if ($data['remember']) {
                    $tokenUtility = new TokenUtility();
                    $token = bin2hex(random_bytes(8)); // generates random 8 bytes (random string)
                    $epxires = time() + 30 * 24 * 60 * 60; // valid time (30 days x 24 hours x 60 mins x 60 secs)
                    setcookie('token', $token, $expires, '/');
                    $tokenUtility->createToken($token, $_SESSION['userId'], $expires);
                }
            } else {
                $errors[] = $isValid['error'];
            }
        }
    } else {
        $errors[] = 'Invalid request';
    }

    if($errors) {
        $response = ['success' => false, 'data' => $errors];
    } else {
        $response = ['success' => true];
    }

    echo json_encode($response); // sending it to login.js
?>
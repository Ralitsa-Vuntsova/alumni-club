<?php
    session_start();

    if ($_SESSION) {
        session_unset();
        session_destroy();

        setcookie('token', '', time() - 60 * 30, '/'); // set the cookie in the past

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
?>
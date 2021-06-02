<?php
    require_once 'mark.php';
    // require_once 'post.php';

    header('Content-Type: application/json'); // pointing out the type of data

    // these will hold the info that we will be sending to the user
    $errors = [];
    $response = [];

    $requestUrl = $_SERVER['REQUEST_URI'];

    if(preg_match("/students$/", $requestUrl)) {
        if ($_SESSION) {
            if ($_SESSION['username']) {
                $mark = new Mark(0, 0);
                $marks = $mark->getAllMarksWithStudents();

                echo json_encode(['success' => true, 'data' => $marks);
            } else {
                echo json_encode(['success' => false, 'data' => 'Unauthorized']);
            }
        } else {
            if ($_COOKIE['token']) {
                $tokenUtility = new TokenUtility();
                $isValid = $tokenUtility->checkToken($_COOKIE['token']);

                if ($isValid) {
                    $_SESSION['username'] = $isValid['user']->getUsername();
                    $_SESSION['userId'] = $isValid['user']->getUserId();
                    $_SESSION['email'] = $isValid['user']->getEmail();

                    $mark = new Mark(0, 0);
                    $marks = $mark->getAllMarksWithStudents();

                    echo json_encode(['success' => true, 'data' => $marks);
                } else {
                    echo json_encode(['success' => false, 'data' => $isValid['error']]);
                }
            } else {
                echo json_encode(['success' => false, 'data' => 'Session expired']);
            }
        }
    } else if (preg_match("/addStudent$/", $requestUrl)) { // accepts the info from sendForm in index.js and validates it
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode($_POST['data'], true); // JSON -> associative array

            // checks if field is set, if not => empty string/number/etc
            // testInput removes all whitespaces and handles special characters
            $firstName = isset($data['firstName']) ? testInput($data['firstName']) : '';
            $lastName = isset($data['lastName']) ? testInput($data['lastName']) : '';
            $fn = isset($data['fn']) ? testInput($data['fn']) : 0;
            $mark = isset($data['mark']) ? testInput($data['mark']) : 0;

            validateData($data);
        } else {
            $errors[] = 'Invalid request';
        }
    } else {
        $errors[] = 'Invalid endpoint';
    }

    if ($errors) {
        http_response_code(400); // error

        echo json_encode($errors); // echos the errors in JSON format
    } else {
        // Create DB record
        $studentMark = new Mark($fn, $mark); // will work with the DB
        
        // TODO:
        // * If the student already has a mark, do not add second
        // * If there is no student with such names and fn, do not add marks
        // * Handle DB errors

        http_response_code(200); // success

        echo json_encode($response); // echos the response in JSON format
    }

    /*
    if(preg_match("/students$/", $requestUrl)) { // oshte ne sme stignali dotuk sus zapisite
        if ($_SESSION) {
            if ($_SESSION['username']) {
                $mark = new Mark(0, 0);
                $marks = $mark->getAllMarksWithStudents();

                echo json_encode(['success' => true, 'data' => $marks);
            } else {
                echo json_encode(['success' => false, 'data' => 'Unauthorized']);
            }
        } else {
            if ($_COOKIE['token']) {
                $tokenUtility = new TokenUtility();
                $isValid = $tokenUtility->checkToken($_COOKIE['token']);

                if ($isValid) {
                    $_SESSION['username'] = $isValid['user']->getUsername();
                    $_SESSION['userId'] = $isValid['user']->getUserId();
                    $_SESSION['email'] = $isValid['user']->getEmail();

                    $mark = new Mark(0, 0);
                    $marks = $mark->getAllMarksWithStudents();

                    echo json_encode(['success' => true, 'data' => $marks);
                } else {
                    echo json_encode(['success' => false, 'data' => $isValid['error']]);
                }
            } else {
                echo json_encode(['success' => false, 'data' => 'Session expired']);
            }
        }
    } else if (preg_match("/addPost$/", $requestUrl)) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode($_POST['data'], true);

            // TODO: check if all variables are string
            $occasion = isset($data['occasion']) ? testInput($data['occasion']) : '';
            $privacy = isset($data['privacy']) ? testInput($data['privacy']) : '';
            $occasionDate = isset($data['occasionDate']) ? testInput($data['occasionDate']) : '';
            $location = isset($data['location']) ? testInput($data['location']) : '';
            $content = isset($data['content']) ? testInput($data['content']) : '';

            validateData($data);
        } else {
            $errors[] = 'Invalid request';
        }
    } else {
        $errors[] = 'Invalid endpoint';
    }

    if ($errors) {
        http_response_code(400);

        echo json_encode($errors);
    } else {
        // Create DB record
        $post = new Post(); // oshte ne sme stignali dotuk sus zapisite
        
        // TODO: Handle DB errors

        http_response_code(200);

        echo json_encode($response);
    }
    */

    // same for our system
    function testInput($input) {
        $input = trim($input); // removes whitespaces from beginning and end
        $input = htmlspecialchars($input); // replaces all special characters with entities
        $input = stripslashes($input); // removes slashes

        return $input;
    }

    function validateData($data) {
        if (!$firstName) {
            $errors[] = 'Please enter first name';
        } elseif (mb_strlen($firstName) > 20) { // mb supports bulgarian
            $errors[] = 'First Name can not be longer than 20 characters';
        } else {
            $response['firstName'] = $firstName;
        }

        if (!$lastName) {
            $errors[] = 'Please enter last name';
        } elseif (mb_strlen($lastName) > 20) {
            $errors[] = 'Last Name can not be longer than 20 characters';
        } else {
            $response['lastName'] = $firstName;
        }

        if (!$fn) {
            $errors[] = 'Please enter faculty number';
        } elseif (!ctype_digit($fn)) {
            $errors[] = 'Faculty Number must be an integer';
        } elseif (intval($fn) < 62000 || intval($fn) > 62999) {
            $errors[] = 'Faculty Number must be between 62000 and 62999';
        } else {
            $response['fn'] = $fn;
        }

        if (!$mark) {
            $errors[] = 'Please enter mark';
        } elseif (!is_numeric($mark)) {
            $errors[] = 'Mark must be a number';
        } elseif (floatval($mark) < 2.0 || floatval($mark) > 6.0) {
            $errors[] = 'Mark must be between 2.0 and 6.0';
        } else {
            $response['mark'] = $mark;
        }
    }

    /*
    function validateData($data) {
        // TODO: chech if all variables are string
        if (!$occasion) {
            $errors[] = 'Please enter occasion';
        } elseif (mb_strlen($occasion) > 20) {
            $errors[] = 'Occasion can not be longer than 20 characters';
        } else {
            $response['occasion'] = $occasion;
        }

        if (!$privacy) {
            $errors[] = 'Please enter privacy';
        } else {
            $response['privacy'] = $privacy;
        }

         if (!$occasionDate) {
            $errors[] = 'Please enter occasion date';
        } else {
            $response['occasionDate'] = $occasionDate;
        }

         if (!$location) {
            $errors[] = 'Please enter occasion';
        } elseif (mb_strlen($location) > 50) { 
            $errors[] = 'Location can not be longer than 20 characters';
        } else {
            $response['location'] = $location;
        }

         if (!$content) {
            $errors[] = 'Please enter occasion';
        } elseif (mb_strlen($occasion) > 100) {
            $errors[] = 'Content can not be longer than 20 characters';
        } else {
            $response['content'] = $content;
        }
    }
    */
?>
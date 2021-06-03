<?php
    require_once 'post.php';

    header('Content-Type: application/json'); // pointing out the type of data

    // these will hold the info that we will be sending to the user
    $errors = [];
    $response = [];

    $requestUrl = $_SERVER['REQUEST_URI'];
    
    if(preg_match("/posts$/", $requestUrl)) {
        if ($_SESSION) {
            if ($_SESSION['username']) {
                $post = new Post('', '', '', '', '');
                $posts = $post->getAllPosts();

                echo json_encode(['success' => true, 'data' => $posts);
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

                    $post = new Post('', '', '', '', '');
                    $posts = $post->getAllPosts();

                    echo json_encode(['success' => true, 'data' => $posts);
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
        $post = new Post(); 
        // TODO: create post, add it to the DB, handle DB errors, show to the client

        http_response_code(200);

        echo json_encode($response);
    }

    function testInput($input) {
        $input = trim($input); // removes whitespaces from beginning and end
        $input = htmlspecialchars($input); // replaces all special characters with entities
        $input = stripslashes($input); // removes slashes

        return $input;
    }
    
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
?>
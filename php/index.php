<?php
    require_once 'post.php';

    header('Content-Type: application/json'); // pointing out the type of data

    // these will hold the info that we will be sending to the user
    $errors = [];
    $response = [];

    $requestUrl = $_SERVER['REQUEST_URI'];
    
    if(preg_match("/posts$/", $requestUrl)) {
        if ($_SESSION) { // is there a started session?
            if ($_SESSION['username']) { // is there a record of the user 
                $post = new Post('', '', '', '', '');
                $posts = $post->getAllPosts();

                echo json_encode(['success' => true, 'data' => $posts]); // sending it to index.js
            } else {
                echo json_encode(['success' => false, 'data' => 'Unauthorized']); // sending it to index.js
            }
        } else { // if no session is started, check if a cookie is set
            if ($_COOKIE['token']) {
                $tokenUtility = new TokenUtility();
                $isValid = $tokenUtility->checkToken($_COOKIE['token']);

                if ($isValid) {
                    $_SESSION['username'] = $isValid['user']->getUsername();
                    $_SESSION['userId'] = $isValid['user']->getUserId();
                    $_SESSION['email'] = $isValid['user']->getEmail();

                    $post = new Post('', '', '', '', '');
                    $posts = $post->getAllPosts();

                    echo json_encode(['success' => true, 'data' => $posts]); // sending it to index.js
                } else {
                    echo json_encode(['success' => false, 'data' => $isValid['error']]); // sending it to index.js
                }
            } else {
                echo json_encode(['success' => false, 'data' => 'Session expired']); // sending it to index.js
            }
        }
    } else if (preg_match("/addPost$/", $requestUrl)) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode($_POST['data'], true);

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

        echo json_encode($errors); // sending it to index.js
    } else {
        $post = new Post($data['occasion'], $data['privacy'], $data['occasionDate'], $data['location'], $data['content']); 
        $post->addPost();
        
        // TODO: handle DB errors

        http_response_code(200);

        echo json_encode($response); // sending it to index.js
    }

    function testInput($input) {
        $input = trim($input); // removes whitespaces from beginning and end
        $input = htmlspecialchars($input); // replaces all special characters with entities
        $input = stripslashes($input); // removes slashes

        return $input;
    }
    
    function validateData($data) {
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
            $errors[] = 'Please enter location';
        } elseif (mb_strlen($location) > 50) { 
            $errors[] = 'Location can not be longer than 50 characters';
        } else {
            $response['location'] = $location;
        }

         if (!$content) {
            $errors[] = 'Please enter content';
        } elseif (mb_strlen($occasion) > 100) {
            $errors[] = 'Content can not be longer than 100 characters';
        } else {
            $response['content'] = $content;
        }
    }
?>
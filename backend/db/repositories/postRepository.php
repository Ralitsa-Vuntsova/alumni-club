<?php
require_once(realpath(dirname(__FILE__) . '/../dbConnection.php'));
require_once(realpath(dirname(__FILE__) . '/../../entities/post.php'));
/**
 * All the statements about the posts
 */
class PostRepository {

        private $insertPost;
        private $selectPosts;
        private $selectUser;
        private $selectUserById;
        private $insertToken;
        private $selectToken;

        private $database;

        public function __construct()
        {
            $this->database = new Database();
            $this->prepareStatements();
        }

        private function prepareStatements() {
            $sql = "INSERT INTO posts(occasion, privacy, occasionDate, location, content) VALUES(:occasion, :privacy, :occasionDate, :location, :content)";
            $this->insertPost = $this->database->getConnection()->prepare($sql);

            // $sql = "SELECT occasion, privacy, occasionDate, location, content FROM posts";
            $sql = "SELECT * FROM posts";
            $this->selectPosts = $this->database->getConnection()->prepare($sql);

            $sql = "SELECT * FROM users WHERE username = :user";
            $this->selectUser = $this->database->getConnection()->prepare($sql);

            $sql = "SELECT * FROM users WHERE id=:id";
            $this->selectUserById = $this->database->getConnection()->prepare($sql);

            $sql = "INSERT INTO tokens(token, userId, expires) VALUES (:token, :userId, :expires)";
            $this->insertToken = $this->database->getConnection()->prepare($sql);

            $sql = "SELECT * FROM tokens WHERE token=:token";
            $this->selectToken = $this->database->getConnection()->prepare($sql);
        }

        // public function insertPostQuery($data) {
        //     try {
        //         $this->insertPost->execute($data);
        //         return ["success" => true];
        //     } catch(PDOException $e) {
        //         $this->database->getConnection()->rollBack();
        //         return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
        //     }
        // }

    public function insertPostQuery($data)
    {
        try {
            $this->insertPost->execute($data);
            return ["success" => true];
        } catch (PDOException $e) {
            $this->database->getConnection()->rollBack();
            return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
        }
    }

        // $this->selectPosts->execute();
        //         $posts = array();
        //         while ($row = $this->selectPosts->fetch())
        //         {
        //             $post = new Post($row['id'], $row['occasion'], $row['privacy'], $row['occasionDate'], $row['location'], $row['content']);
        //             array_push($posts, $post);
        //         }
        //         return $posts;

        public function selectPostsQuery() {
            try {
                $this->selectPosts->execute();

                $posts = array();
                while ($row = $this->selectPosts->fetch())
                {
                    $post = new Post($row['id'], $row['occasion'], $row['privacy'], $row['occasionDate'], $row['location'], $row['content']);
                    array_push($posts, $post);
                }
                return $posts;
            } catch(PDOException $e) {
                $this->database->getConnection()->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectUserQuery($data) {
            try {
                $this->selectUser->execute($data);
                return ["success" => true, "data" => $this->selectUser];
            } catch(PDOException $e) {
                $this->database->getConnection()->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectUserByIdQuery($data) {
            try{
                $this->selectUserById->execute($data);
                return array("success" => true, "data" => $this->selectUserById);
            } catch(PDOException $e){
                $this->database->getConnection()->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function insertTokenQuery($data) {
            try{
                $this->insertToken->execute($data);
                return array("success" => true, "data" => $this->insertToken);
            } catch(PDOException $e){
                $this->database->getConnection()->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectTokenQuery($data) {
            try{
                $this->selectToken->execute($data);
                return array("success" => true, "data" => $this->selectToken);
            } catch(PDOException $e){
                $this->database->getConnection()->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

    }

?>
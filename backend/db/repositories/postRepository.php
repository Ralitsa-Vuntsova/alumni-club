<?php
require_once(realpath(dirname(__FILE__) . '/../dbConnection.php'));
require_once(realpath(dirname(__FILE__) . '/../../entities/post.php'));

/**
 * All the statements about the posts
 */
class PostRepository {
        private $insertPost;
        private $selectPosts;
        private $countPosts;

        private $database;

        public function __construct()
        {
            $this->database = new Database();
        }

        public function insertPostQuery($data)
        {
            $this->database->getConnection()->beginTransaction();   
            try {
                $sql = "INSERT INTO posts(userId, occasion, privacy, occasionDate, location, content) VALUES('{$_SESSION['userId']}', :occasion, :privacy, :occasionDate, :location, :content)";
                $this->insertPost = $this->database->getConnection()->prepare($sql);
                $this->insertPost->execute($data);
                $this->database->getConnection()->commit();   
                return ["success" => true];
            } catch (PDOException $e) {
                echo "exception test";
                $this->database->getConnection()->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectPostsQuery() {
            $this->database->getConnection()->beginTransaction();
            try {
                $sql = "SELECT * FROM posts";
                $this->selectPosts = $this->database->getConnection()->prepare($sql);
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

        public function selectPostsCountQuery()
        {
            $this->database->getConnection()->beginTransaction();   
            try {
                $sql = "SELECT COUNT(id) FROM posts";
                $this->countPosts = $this->database->getConnection()->prepare($sql);
                $this->countPosts->execute();
                $this->database->getConnection()->commit();   
                return ["success" => true, "data" => $this->countPosts];
            } catch (PDOException $e) {
                echo "exception test";
                $this->database->getConnection()->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }
    }
?>
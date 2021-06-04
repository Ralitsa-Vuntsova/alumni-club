<?php
    class Database {
        private $connection;

        private $insertPost;
        private $selectPosts;
        private $selectUser;
        private $selectUserById;
        private $insertToken;
        private $selectToken;

        // data base info is in config file because the data can be changed easily that way
        public function __construct() {
            $config = parse_ini_file('../config/config.ini', true);

            $type = $config['db']['type'];
            $host = $config['db']['host'];
            $name = $config['db']['name'];
            $user = $config['db']['user'];
            $password = $config['db']['password'];

            $this->init($type, $host, $name, $user, $password);
        }

        // coonect to the DB, prepare the sql statements
        private function init($type, $host, $name, $user, $password) {
            try {
                $this->connection = new PDO("$type:host=$host;dbname=$name", $user, $password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

                $this->prepareStatements();
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        private function prepareStatements() {
            $sql = "INSERT INTO posts(occasion, privacy, occasionDate, location, content) VALUES(:occasion, :privacy, :occasionDate, :location, :content)";
            $this->insertPost = $this->connection->prepare($sql);

            $sql = "SELECT occasion, privacy, occasionDate, location, content FROM posts";
            $this->selectMarks = $this->connection->prepare($sql);

            $sql = "SELECT * FROM users WHERE username = :user";
            $this->selectUser = $this->connection->prepare($sql);

            $sql = "SELECT * FROM users WHERE id=:id";
            $this->selectUserById = $this->connection->prepare($sql);

            $sql = "INSERT INTO tokens(token, userId, expires) VALUES (:token, :userId, :expires)";
            $this->insertToken = $this->connection->prepare($sql);

            $sql = "SELECT * FROM tokens WHERE token=:token";
            $this->selectToken = $this->connection->prepare($sql);
        }

        public function insertPostQuery($data) {
            try {
                $this->insertPost->execute($data);
                return ["success" => true];
            } catch(PDOException $e) {
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectPostsQuery() {
            try {
                $this->selectPosts->execute();
                return ["success" => true];
            } catch(PDOException $e) {
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectUserQuery($data) {
            try {
                $this->selectUser->execute($data);
                return ["success" => true, "data" => $this->selectUser];
            } catch(PDOException $e) {
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectUserByIdQuery($data) {
            try{
                $this->selectUserById->execute($data);
                return array("success" => true, "data" => $this->selectUserById);
            } catch(PDOException $e){
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function insertTokenQuery($data) {
            try{
                $this->insertToken->execute($data);
                return array("success" => true, "data" => $this->insertToken);
            } catch(PDOException $e){
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectTokenQuery($data) {
            try{
                $this->selectToken->execute($data);
                return array("success" => true, "data" => $this->selectToken);
            } catch(PDOException $e){
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        // close the connection to the DB
        function __destruct() {
            $this->connection = null;
        }
    }
?>
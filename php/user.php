<?php
    require_once "db.php";

    class User {
        private $username;
        private $password;
        private $email;
        private $userId;

        private $db;

        public function __construct($username, $password) {
            $this->username = $username;
            $this->password = $password;

            $this->db = new Database();
        }

        public function getUsername() {
            return $this->username;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getUserId() {
            return $this->userId;
        }

        public function setUsername($username) {
            $this->username = $username;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setUserId($userId) {
            $this->userId = $userId;
        }

        public function isValid() { 
            $query = $this->db->selectUserQuery(["user" => $this->username]);

            if ($query["success"]) {
                $user = $query["data"]->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    if (password_verify($this->password, $user["password"])) {
                        $this->password = $user["password"];
                        $this->email = $user["email"];
                        $this->userId = $user["id"];

                        return ["success" => true];
                    } else {
                        return ["success" => false, "error" => "Invalid password"];
                    }
                } else {
                    return ["success" => false, "error" => "Invalid username"];
                }
            } else {
                return $query;
            }
        }
    }
?>
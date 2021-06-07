<?php
require_once(realpath(dirname(__FILE__) . '/../dbConnection.php'));
require_once(realpath(dirname(__FILE__) . '/../../entities/user.php'));
/**
 * All the statements about the users
 */
class UserRepository {

        private $selectUserById;
        private $insertToken;
        private $selectToken;
        private $updateUser;
        private $selectUsers;
        private $selectUser;

        private $database;

        public function __construct()
        {
            $this->database = new Database();
            $this->prepareStatements();
        }

        private function prepareStatements() {

            $sql = "INSERT INTO tokens(token, userId, expires) VALUES (:token, :userId, :expires)";
            $this->insertToken = $this->database->getConnection()->prepare($sql);

            $sql = "SELECT * FROM tokens WHERE token=:token";
            $this->selectToken = $this->database->getConnection()->prepare($sql);
        }

        public function updateUserQuery($data)
        {
            $this->database->getConnection()->beginTransaction();   
            try {
                $sql = "UPDATE users SET password = :password, firstName = :firstName, 
                        lastName = :lastName, email = :email WHERE id = '{$_SESSION['userId']}'";
                $this->updateUser = $this->database->getConnection()->prepare($sql);
                $this->updateUser->execute($data);
                $this->database->getConnection()->commit();   
                return ["success" => true];
            } catch (PDOException $e) {
                echo "exception test";
                $this->database->getConnection()->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

    // public function updateUserQuery($data)
    // {
    //     $this->database->getConnection()->beginTransaction();   
    //     try {
    //         $sql = "UPDATE users SET username = :username, password = :password, firstName = :firsName, 
    //                 lastName = :lastName, email = :email, role = :role, speciality = :speciality, graduationYear = :graduationYear,
    //                 groupUni = :groupUni, faculty = :faculty) WHERE id = '{$_SESSION['userId']}'";
    //         $this->updateUser = $this->database->getConnection()->prepare($sql);
    //         $this->updateUser->execute($data);
    //         $this->database->getConnection()->commit();   
    //         return ["success" => true];
    //     } catch (PDOException $e) {
    //         $this->database->getConnection()->rollBack();
    //         return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    //     }
    // }

    public function selectUsersQuery() {
        $this->database->getConnection()->beginTransaction();
        try {
            $sql = "SELECT * FROM users";
            $this->selectUsers = $this->database->getConnection()->prepare($sql);
            $this->selectUsers->execute();

            $users = array();
            while ($row = $this->selectUsers->fetch())
            {
                $user = new User($row['id'], $row['username'], $row['password'], $row['firstName'], $row['lastName'], $row['email'], $row['role']);
                array_push($users, $user);
            }
            $this->database->getConnection()->commit();
            return $users;
        } catch(PDOException $e) {
            $this->database->getConnection()->rollBack();
            return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
        }
    }

    public function selectUserByIdQuery($data) {
        $this->database->getConnection()->beginTransaction();
        try{
            $sql = "SELECT * FROM users WHERE id=:id";
            $this->selectUserById = $this->database->getConnection()->prepare($sql);
            $this->selectUserById->execute(["id" => $data]);
            $this->database->getConnection()->commit();
            return array("success" => true, "data" => $this->selectUserById);
        } catch(PDOException $e){
            $this->database->getConnection()->rollBack();
            return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
        }
    }

    public function selectUserByUsernameQuery($username) {
        $this->database->getConnection()->beginTransaction();
        try {
            $sql = "SELECT * FROM users WHERE username=:username";
            $this->selectUser = $this->database->getConnection()->prepare($sql);
            $this->selectUser->execute(["username" => $username]);
            $this->database->getConnection()->commit();
            // $user = $query["data"]->fetch(PDO::FETCH_ASSOC);
            return array("success" => true, "data" => $this->selectUser);
        } catch(PDOException $e) {
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
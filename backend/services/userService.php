<?php
    require_once(realpath(dirname(__FILE__) . '/../db/repositories/userRepository.php'));

    class UserService {
        private $userRepository;

        public function __construct()
        {
            $this->userRepository = new UserRepository();
        }

        public function getAllUsers()
        {
            return $this->userRepository->selectUsersQuery();
        }

        public function updateUser($user)
        {
            $query = $this->userRepository->updateUserQuery([
                "password" => $user->password,
                "firstName" => $user->firstName,
                "lastName" => $user->lastName,
                "email" => $user->email
            ]);
        }

        public function getUser()
        {
            $result = $this->userRepository->selectUserByIdQuery($_SESSION['userId']);
            return $result["data"]->fetch(PDO::FETCH_ASSOC);
        }

        public function checkLogin($username, $password) {
            $result = $this->userRepository->selectUserByUsernameQuery($username);
            
            if (!$result["success"]) {
                throw new Exception("Wrong username.");
            } else if ($password != $result["success"]) {  // check with ISSET  
                throw new Exception("Wrong password.");
            }
            session_start();
            return $result["data"]->fetch(PDO::FETCH_ASSOC)["id"];
        }
    }
?>
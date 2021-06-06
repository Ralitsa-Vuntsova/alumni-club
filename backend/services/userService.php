<?php
require_once(realpath(dirname(__FILE__) . '/../db/repositories/userRepository.php'));

class UserService
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getAllUsers()
    {
        return $this->userRepository->selectUsersQuery();
    }

    public function createUser($user)
    {
        $query = $this->userRepository->insertUserQuery([
            "occasion" => $user->occasion,
            "privacy" => $user->privacy,
            "occasionDate" => $user->occasionDate,
            "location" => $user->location,
            "content" => $user->content
        ]);
    }

    public function checkLogin($username, $password) {
		
        $result = $this->userRepository->selectUserByUsernameQuery($username);
        
		if (!$result["success"]) {
            throw new Exception("Грешно потребителско име.");
		} else if ($password != $result["success"]) {  // check with ISSET  
            throw new Exception("Грешна парола.");
        }
        session_start();
        return $result["data"]->fetch(PDO::FETCH_ASSOC)["id"];
	}
}
?>
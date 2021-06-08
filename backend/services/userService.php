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

        public function updateCoordinates($longitude, $latitude){
            $this->userRepository->updateCoordinatesQuery([
                "longitude" => $longitude,
                "latitude" => $latitude
            ]);
        }

        private function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {  
            $earth_radius = 6371;
          
            $dLat = deg2rad($latitude2 - $latitude1);  
            $dLon = deg2rad($longitude2 - $longitude1);  
          
            $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
            $c = 2 * asin(sqrt($a));  
            $d = $earth_radius * $c;  
          
            return $d;  
          }

          public function getAllNearbyUsers(){
            $radius = 5;
            $allUsers = $this->userRepository->selectNearbyUsersInfoQuery();
            $currentUser = $this->getUser();
            $result = array();

            foreach ($allUsers as $user) {
                $distance = $this->getDistance($currentUser["latitude"], $currentUser["longitude"], $user->latitude, $user->longitude);
                if($distance < $radius){
                    array_push($result, $user);
                }
            }
            
            return $result;
        }
    }
?>
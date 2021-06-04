<?php
    require_once "db.php";

    class Post{
        private $id;
        private $occasion;
        private $privacy;
        private $occasionDate;
        private $location;
        private $content;

        private $db;

        public function __construct($occasion, $privacy, $occasionDate, $location, $content) {
            $this->db = new Database();

            this->occasion = $occasion;
            this->privacy = $privacy;
            this->occasionDate = $occasionDate;
            this->location = $location;
            this->content = $content;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setOccasion($occasion) {
            $this->occasion = $occasion;
        }

        public function getOccasion() {
            return $this->occasion;
        }

        public function setPrivacy($privacy) {
            $this->privacy = $privacy;
        }

        public function getPrivacy() {
            return $this->privacy;
        }

        public function setOccasionDate($occasionDate) {
            $this->occasionDate = $occasionDate;
        }

        public function getOccasionDate() {
            return $this->occasionDate;
        }

        public function setLocation($location) {
            $this->location = $location;
        }

        public function getLocation() {
            return $this->location;
        }

        public function setContent($content) {
            $this->content = $content;
        }

        public function getContent() {
            return $this->content;
        }

        public function getAllPosts() {
            $query = $this->db->selectPosts();

            if ($query["success"]) {
                return $query["data"]->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $query;
            }
        }

        public function addPost() {
            $query = $this->db->insertPost(["occasion" => $this->occasion, 
                                            "privacy" => $this->privacy,
                                            "occasionDate" => $this->occasionDate,
                                            "location" => $this->location,
                                            "content" => $this->content
                                        ]);
        }
    }
?>
<?php
    require_once "db.php";

    class Post{
        private $id;
        private $privacy;
        private $occasion;
        private $location;
        private $content;
        private $occasionDate;

        private $db;

        public function __construct($privacy, $occasion, $location, $content, $occasionDate) {
            $this->db = new Database();

            this->privacy = $privacy;
            this->occasion = $occasion;
            this->location = $location;
            this->content = $content;
            this->occasionDate = $occasionDate;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        // TODO: getters and setters

        public function getAllPosts() {
            $query = $this->db->selectPosts();

            if ($query["success"]) {
                return $query["data"]->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $query;
            }
        }

        public function addPost() {
            $query = $this->db->insertPost(["privacy" => $this->privacy, 
                                            "occasion" => $this->occasion,
                                            "location" => $this->location;
                                            "content" => $this->content,
                                            "occasionDate" => $this->occasionDate,
                                        ]);
        }
    }
?>
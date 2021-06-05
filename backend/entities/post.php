<?php
    class Post {
        public $id;
        public $occasion;
        public $privacy;
        public $occasionDate;
        public $location;
        public $content;

        public function __construct($id, $occasion, $privacy, $occasionDate, $location, $content) {
            $this->id = $id;
            $this->occasion = $occasion;
            $this->privacy = $privacy;
            $this->occasionDate = $occasionDate;
            $this->location = $location;
            $this->content = $content;
        }

        // public function setId($id) {
        //     $this->id = $id;
        // }

        // public function getId() {
        //     return $this->id;
        // }

        // public function setOccasion($occasion) {
        //     $this->occasion = $occasion;
        // }

        // public function getOccasion() {
        //     return $this->occasion;
        // }

        // public function setPrivacy($privacy) {
        //     $this->privacy = $privacy;
        // }

        // public function getPrivacy() {
        //     return $this->privacy;
        // }

        // public function setOccasionDate($occasionDate) {
        //     $this->occasionDate = $occasionDate;
        // }

        // public function getOccasionDate() {
        //     return $this->occasionDate;
        // }

        // public function setLocation($location) {
        //     $this->location = $location;
        // }

        // public function getLocation() {
        //     return $this->location;
        // }

        // public function setContent($content) {
        //     $this->content = $content;
        // }

        // public function getContent() {
        //     return $this->content;
        // }
    }
?>
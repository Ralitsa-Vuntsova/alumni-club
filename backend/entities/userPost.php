<?php
    class UserPost {
        public $occasion;
        public $privacy;
        public $occasionDate;
        public $location;
        public $content;
        public $speciality;
        public $groupUni;
		public $faculty;
        public $graduationYear;

        public function __construct($occasion, $privacy, $occasionDate, $location,
         $content, $speciality, $groupUni, $faculty, $graduationYear) {
            $this->occasion = $occasion;
            $this->privacy = $privacy;
            $this->occasionDate = $occasionDate;
            $this->location = $location;
            $this->content = $content;
            $this->speciality = $speciality;
			$this->groupUni = $groupUni;
            $this->faculty = $faculty;
            $this->graduationYear = $graduationYear;
        }
    }
?>
<?php
    require_once(realpath(dirname(__FILE__) . '/../db/repositories/postRepository.php'));

    class PostService {
        private $postRepository;

        public function __construct()
        {
            $this->postRepository = new PostRepository();
        }

        public function getAllPosts()
        {
            return $this->postRepository->selectPostsQuery();
        }

        public function createPost($post)
        {
            $query = $this->postRepository->insertPostQuery([
                "occasion" => $post->occasion,
                "privacy" => $post->privacy,
                "occasionDate" => $post->occasionDate,
                "location" => $post->location,
                "content" => $post->content
            ]);
        }

        public function filterPosts()
        {
            $allUserPosts = $this->postRepository->selectPostUserQuery();
           
            $result = array();
            foreach ($allUserPosts as $post) {
                if($post->privacy == "faculty" && $_SESSION['faculty'] == $post->faculty){
                    array_push($result, $post);
                }
                else if($post->privacy == "speciality" && $_SESSION['speciality'] == $post->speciality){
                    array_push($result, $post);
                }
                else if($post->privacy == "group"
                                    && $_SESSION['graduationYear'] == $post->graduationYear
                                    && $_SESSION['faculty'] == $post->faculty 
                                    && $_SESSION['speciality'] == $post->speciality
                                    && $_SESSION['groupUni'] == $post->groupUni){
                    array_push($result, $post);
                }
                else if($post->privacy == "all"){
                    array_push($result, $post); // privacy: all users
                }
            }

            return $result;
        }

    }
?>
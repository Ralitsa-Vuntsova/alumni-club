<?php
require_once(realpath(dirname(__FILE__) . '/../db/repositories/postRepository.php'));

class PostService
{

    private $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function getAllPosts()
    {
        $query = $this->postRepository->selectPostsQuery();

        return $query;
        // if ($query["success"]) {
        //     $posts = array();
        //     while ($row = $this->selectPosts->fetch()) {
        //         $post = new Post($row['id'], $row['occasion'], $row['privacy'], $row['occasionDate'], $row['location'], $row['content']);
        //         array_push($posts, $post);
        //     }
        //     return $posts;
        // } else {
        //     return $query;
        // }
    }

    public function addPost()
    {
        $query = $this->db->insertPostQuery([
            "occasion" => $this->occasion,
            "privacy" => $this->privacy,
            "occasionDate" => $this->occasionDate,
            "location" => $this->location,
            "content" => $this->content
        ]);
    }

    
}
?>
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

    
}
?>
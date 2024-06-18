<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */



    
class Comment {
     // Composition: Comment "has" a User
     // Composition: Comment "has" a Post
     private ? int $id = null;

    public function __construct(private string $content, private User $user, Post $post) {}


    public function getId(): ?int // id int ou null
    {
        return $this->id;
    }

    public function setId(?int $id) :void
    {
        $this->id = $id;
    }


    public function getContent() :string
    {
        return $this->content;
    }

    public function setContent(string $content) :void
    {
        $this->content = $content;
    }


    public function getUser() : User 
    {
        return $this->user;
    }

    public function setUserId(User $user):void  
    {
        $this->user = $user;
    }


    public function getPost() {
        return $this->post;
    }

    public function setPostId(Post $post): void 
    {
        $this->post = $post;
    }
}
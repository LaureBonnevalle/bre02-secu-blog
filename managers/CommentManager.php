<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class CommentManager extends AbstractManager
{

    public function __construct()
    {
         parent::__construct();
        
    }
    // retrouver un post par son id
    public function findByPost(int $postId) : array
    {
    // instancier nouveau Usemanager et nouveau postmanager
    $um = new UserManager();
    $pm = new PostManager();
    
        $query = $this->db->prepare("SELECT * FROM comments WHERE post_id = :postId");
        $query->execute(['postId' => $postId]);
        $result= $query->fetchAll(PDO::FETCH_ASSOC);
        $comments = [];
        
        foreach($result as $item)
        {
            $user = $um->findOne($item["user_id"]);
            $post = $pm->findOne($item["post_id"]);

            $comment = new Comment($item["content"], $user, $post);
            $comment->setId($item["id"]);

            $comments[] = $comment;
        }

        return $comments;
    }
    
    
    // Crée un nouveau commentaire dans la base de données
    public function create(Comment $comment) : void
    {  //insere le commentaire dans la base de données
        $dquery = $this->db->prepare('INSERT INTO comments (id, content, user_id, post_id) VALUES (NULL, :content, :user_id, :post_id)');
        $query->execute([
            'content' => $comment->getContent(),  
            'user_id' => $comment->getUser()->getId(),
            'post_id' => $comment->getPost()->getId()]);
        
        $comment->setId($this->db->lastInsertId());
    }
}


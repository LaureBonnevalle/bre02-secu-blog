<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class PostManager extends AbstractManager
{

public function __construct()
    {
         parent::__construct();
        
    }
    
    public function findLatest() : array  //retourne un tableau
    {
        
        $um = new UserManager();
        $cm = new CategoryManager();

        $query = $this->db->prepare('SELECT * FROM posts ORDER BY created_at LIMIT 4');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $posts = [];
       
       foreach ($result as $item) 
       {
           $categories = $cm->findByPost($item["id"]);
            $user = $um->findOne($item["author"]);
            $post = new Post($item["title"], $item["excerpt"], $item["content"], $user, DateTime::createFromFormat('Y-m-d H:i:s', $item["created_at"]));
            $post->setId($item["id"]);
            $post->setCategories($categories);
            $posts[] = $post;
       }
       
       return $posts;
        
    }

    public function findOne(int $id)
    {
        $um = new UserManager();
        $cm = new CategoryManager();
        
       $query = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
       $query->execute(['id'=>$id]);
       
       $result = $query->fetch(PDO::FETCH_ASSOC);
       
       if ($result) 
       {
            
        
           $categories = $cm->findByPost($result["id"]);
            $user = $um->findOne($result["author"]);
            $post = new Post($result["title"], $result["excerpt"], $result["content"], $user, DateTime::createFromFormat('Y-m-d H:i:s', $result["created_at"]));
            $post->setId($result["id"]);
            $post->setCategories($categories);

            return $post;
        } 
        else 
        {
                return null; // Aucun article trouvé avec cet ID
        }
    }
    
    
    public function findByCategory(int $categoryId) : array
    {
        $um = new UserManager();
        $cm = new CategoryManager();
        
        $query = $this->db->prepare('SELECT posts.* FROM posts JOIN posts_categories ON posts_categories.post_id=posts.id WHERE posts_categories.category_id=:category_id');
        $query->execute(['category_id'=>$categoryId]);
       
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $posts = [];
        
     foreach($result as $item)
        {
            $categories = $cm->findByPost($item["id"]);
            $user = $um->findOne($item["author"]);
            $post = new Post($item["title"], $item["excerpt"], $item["content"], $user, DateTime::createFromFormat('Y-m-d H:i:s', $item["created_at"]));
            $post->setId($item["id"]);
            $post->setCategories($categories);
            $posts[] = $post;
        }

        return $posts;
    }
}
<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class Post 
{
    private ? int $id = null;
    private array $categories = [];

    public function __construct(private string $title, private string $excerpt, private string $content, private User $author, private DateTime $createdAt = new DateTime()) 
    {
        
    }

    // Getters and setters for all attributes
    public function getID(): ? int  // retourne int qui peut etre null
    {
        return $this->id;
    }
    public function setId(? int $id):void 
    {
        $this->id = $id;
    }


    public function getTitle(): string // retourne string
    {
        return $this->title;
    }
    public function setTitle(string $title):void 
    {
        $this->title = $title;
    }
    
    
    public function getExcerpt(): string // retourne string    
    {
        return $this->excerpt;
    }
    public function setExcerpt(string $excerpt):void 
    {
        $this->excerpt = $excerpt;
    }
    
    
    public function getContent(): string  //retourne string
    {
        return $this->content;
    }
    public function setContent(string $content):void 
    {
        $this->content = $content;
    }
    
    //attention un autheur est un User
    public function getAuthor(): User // retourne un User
    {
        return $this->author;
    }
    public function setAuthor(User $author):void // param de User $author
    {
        $this->author = $author;
    }
    
    // date
    public function getCreatedAt(): DateTime // retourne la date 
    {
        return $this->createdAt;
    }
    public function setCreatedAt(DateTime $createdAt):void // param pour $createdAt
    {
        $this->createdAt = $createdAt;
    }
    
    // retourne un tableau
    public function getCategories(): array
    {
        return $this->categories;
    }
    //param du tableau $categories
    public function setCategories(array $categories):void
    {
       $this->categories = $categories;
    }
    
    
}


    

    

    

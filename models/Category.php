<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class Category 
{
    private ?int $id = null;

    public function __construct(private string $title, private string $description) {}

    // Getters and setters for all attributes
    public function getId(): ?int 
    {
        return $this->id;
    }
    public function setId(?int $id):void 
    {
        $this->id = $id;
    }
    
    

    public function getTitle(): string 
    {
        return $this->title;
    }
    public function setTitle(string $title):void 
    {
        $this->title = $title;
    }



    public function getDescription(): string 
    {
        return $this->description;
    }
    public function setDescription(string $title):void
    {
        $this->description = $description;
    }


}

?>
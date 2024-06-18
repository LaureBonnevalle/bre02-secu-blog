<?php


class User 
{
    private ?int $id = null;     

    public function __construct(private string $username, private string $email, private string $password, private string $role = "USER") {}

    // Getters and setters for all attributes
    public function getId(): ?int 
    {
        return $this->user_id;
    }
    public function setId($id):void 
    {
        $this->id = $id;
    }
    
    
    public function getUsername(): string 
    {
        return $this->username;
    }
    public function setUsername($username):void 
    {
        $this->username = $username;
    }
    
    
    public function getEmail(): string 
    {
        return $this->email;
    }
    public function setEmail($email):void 
    {
        $this->email = $email;
    }
    
    
    public function getPassword(): string 
    {
        return $this->password;
    }
    public function setPassword(string $password) :void
    {
        $this->password = $password;
    }
    

    public function getRole(): string 
    {
        return $this->role;
    }
    public function setRole($role):void 
    {
        $this->role = $role;
    }
    
    
   // public function getCreatedAt(): DateTime 
   // {
   //     return $this->created_at;
   // }
   // public function setCreatedAt($created_at):void 
    //{
    //    $this->created_at = $created_at;
   // }
}

    

    

    

    

    

    

    

    

    

    

    

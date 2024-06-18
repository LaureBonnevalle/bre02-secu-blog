<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class UserManager extends AbstractManager
{
public function __construct()
    {
         parent::__construct();
        
    }

// Trouve l'utilisateur par son email
    public function findByEmail(string $email) {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result)
        {
            $user = new User($result["username"], $result["email"], $result["password"], $result["role"]);
            $user->setId($result["id"]);

            return $user;
        }

        return null;
    }

    // trouve utilisateur à partir de son id
    public function findOne(int $id) : ? User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id=:id');
        $query->execute(['id'=>$id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $user = new User($result["username"], $result["email"], $result["password"], $result["role"]);
            $user->setId($result["id"]);

            return $user;
        }

        return null;
    }







    /// Crée un nouvel utilisateur dans la base de données
    public function create(User $user) {
        $currentDateTime = date('Y-m-d H:i:s');

        $query = $this->db->prepare('INSERT INTO users (id, username, email, password, role, created_at) VALUES (NULL, :username, :email, :password, :role, :created_at)');
        $query->execute([
            'username' => $user->getUsername(),
            'password' =>$user->getPassword(),
            'email' => $user->getEmail(),
            'role'=>$user->getRole(),
            'created_at'=> $currentDateTime,
        ]);
        $user->setId($this->db->lastInsertId());
    }
    
}

//$user1=[
//    'id'=> null,
//    'username'=> 'lbonneva',
//    'email' => 'lbonneva@hotmail.com',
//    'hashedPassword' => password_hash('EvolutionBlog1@', PASSWORD_DEFAULT),
//    'role'=>'administrateur',
//    'created_at'=> new datetime()
//    ];
    
//    $utilisateur= new User($user1);
    


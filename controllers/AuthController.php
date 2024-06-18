<?php


class AuthController extends AbstractController
{ //connecter un utilisateur deja existant
    public function login() : void
    {
        $this->render("login", []);
        
        /*echo"<pre";
        var_dump($_SESSION['csrf-token']);
        echo"</pre>";*/
       
       
        
        
    }


// verifier le loggin d'un utilisateur existant
    public function checkLogin() : void
    {
        
           /*echo"<pre>";
            var_dump($_POST['csrf-token']);
            var_dump($_SESSION["csrf-token"]);
            echo"</pre>";
            die();*/
            
        // si le login est valide email et password alors genere un token de session qui sera verif pour chaque envoi de post ou formulaire
    if (isset($_POST["email"]) && isset($_POST["password"]))
    {
        $tokenManager = new CSRFTokenManager();
        
        if(isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
        {
            /*echo"<pre>";
            var_dump($_POST['csrf-token']);
            echo"</pre>";*/
            
            
            $um = new UserManager(); // recup utilisateur par son mail
            $user = $um->findByEmail($_POST["email"]);

            if($user !== null)
            {  // si user exist avec son mail on verif son password
                if(password_verify($_POST["password"], $user->getPassword()))
                { // si password verif on ouvre une session et on recup id de utilisateur
                    $_SESSION["user"] = $user->getId();
                    //permet d enlever les messages d'eerreur à la tentative de connexion suivante
                    unset($_SESSION["error-message"]);

                    $this->redirect("index.php"); // on redirige vers la page d'acceuil
                }
                else
                {// si password pas verif
                    $_SESSION["error-message"] = "Erreur login information";
                    $this->redirect("index.php?route=login");
                }
            }
            else
            { // si user pas trouvé avec son mail
                $_SESSION["error-message"] = "Erreur login information";
                $this->redirect("index.php?route=login");
            }
        }
        else
        {// si user n'existe pas
            $_SESSION["error-message"] = "Invalide CSRF token";
            $this->redirect("index.php?route=login");
        }
    }
    else
    {// si les champs du login sont vides
        $_SESSION["error-message"] = "Champs vides";
        $this->redirect("index.php?route=login");
    }
    }

//enregistrer un nouvel utilisateur

    public function register() : void
    {
        $this->render("register", []);
        
            /*echo"<pre>";
            var_dump($_SESSION["csrf-token"]);
            echo"</pre>";*/
            
    }
    
    
// valider l'enregistrement d'un nouvel utilisateur
    public function checkRegister() : void
    {
       /*echo"<pre>";
            var_dump($_POST['csrf-token']);
            var_dump($_SESSION["csrf-token"]);
            echo"</pre>";
            //die();*/
       
        // si username et email contiennent bien les info username email password et confirmpassword
        if(isset($_POST["username"]) && isset($_POST["email"])
            && isset($_POST["password"]) && isset($_POST["confirm-password"]))
        {
            // on verif le token
            $tokenManager = new CSRFTokenManager();
            if(isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
                if($_POST["password"] === $_POST["confirm-password"])
                {//si password confirm on verif qu'il est assez fort on demande au moins 8caracteres une minuscule une majuscule un chiffre un caractere special
                    
/*Code généré par l'IA  :   /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[?!@$%^&*-]).{8,}$/ 
^ : Début de la chaîne.
(?=.*?[A-Z]) : Recherche d’au moins une lettre majuscule.
(?=.*?[a-z]) : Recherche d’au moins une lettre minuscule.
(?=.*?[0-9]) : Recherche d’au moins un chiffre.
(?=.*?[#?!@$%^&*-]) : Recherche d’au moins un caractère spécial parmi ceux-ci : #?!@$%^&*-.
.{8,} : La chaîne doit contenir au moins 8 caractères.
En résumé, cette expression régulière garantit que le mot de passe a au moins 8 caractères, avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial.*/
                    //$password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])[A-Za-z\d^\w\s]{8,}$/';
                    //$password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])[A-Za-z\d^\w\s]{8,}$/";
                    $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
                 
                 
                 
                    if (preg_match($password_pattern, $_POST['password'])===1)
                    {
                    
                        
                        $um = new UserManager();
                        $user = $um->findByEmail($_POST["email"]);
                        
                        if($user === null)
                        {// si user n'existe pas et il rempli les champs et nettoie les champs pour securite (enlmever les morceaux de codes qui pourraient etre introduits)
                            $username = htmlspecialchars($_POST["username"]);
                            $email = htmlspecialchars($_POST["email"]);
                            // on chiffre le mot de passe pour le stocker
                            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                            //on crée un nouveau user et on lui ouvre une session user
                            $user = new User($username, $email, $password);
                            // on utilise uneinstance de UserManager pour creer un nouvel utilisateur
                            $um->create($user);
                            //on enregitstre sa session et recupere id
                            $_SESSION["user"] = $user->getId();
                            // on enleve les messages d'erreur precedent
                            unset($_SESSION["error-message"]);
                            // on redirige vers page acceuil
                            $this->redirect("index.php");
                        }
                        else
                        {// si utilisateur deja existant avec son username et/ou son mail opn redirige vers la page login
                            $_SESSION["error-message"] = "User already exists";
                            $this->redirect("index.php?route=register");
                        }
                        
                    }
                    else 
                    {//si le password n'a pas les caracteristiques demandées on redirige vers formulaire inscription
                        $_SESSION["error-message"] = "Password is not strong enough";
                        $this->redirect("index.php?route=register");
                    }
                }
                else
                {// si password n'est pas verif on redirige vers formulaire inscription
                    $_SESSION["error-message"] = "The passwords do not match";
                    $this->redirect("index.php?route=register");
                }
            }
            else
            { // si token pas verif on redirige vers le formulaire d insciption
                $_SESSION["error-message"] = "Invalid CSRF token";
                $this->redirect("index.php?route=register");
            }
        }
        else
        {// si champs pas remplis erreur on redirige vers le formulaire d'inscription
            $_SESSION["error-message"] = "Missing fields";
            $this->redirect("index.php?route=register");
        }
    }


// fonction logout detruit la session utilisateur et redirige vers page accueil
    public function logout() : void
    {
        session_destroy();

        $this->redirect("index.php");
    }
}
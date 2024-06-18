<?php



class BlogController extends AbstractController
{
    public function home() : void
    {
        //instancier un postmanager et un categorymanager
        $pm = new PostManager();
        $cm =new CategoryManager();
        
        $posts = $pm->findLatest();
        $categories= $cm->findAll();

        $this->render("home", [ "posts" => $posts, "categories" => $categories]);
        
        
    }

    public function category(string $categoryId) : void
    {
        //on instancie un category manager
        $cm = new CategoryManager();
        // on lui applique un findOne() pour trouver l'id de la categorie
        $category= $cm->findOne(intval($categoryId));
        
            // si la catégorie existe
             if($category !== null)
            {// on recup tous les posts de la categorie avec l'id
            $pm = new PostManager();
            $posts = $pm->findByCategory($category->getId());
            $categories = $cm->findAll();
            //on retourne les posts de la categorie concernee
            $this->render("category", ["category" => $category, "posts" => $posts, "categories" => $categories]);
            }
            // sinon on redirige vers page d 'accueil
            else
            {
            $this->redirect("index.php");
            }
    }
    
    
    // mettre un commentaire
    public function post(string $postId) : void
    {
        //on instancie un postmanager un categorymanager et un commentmanager
        $pm = new PostManager();
        $cm = new CategoryManager();
        $com = new CommentManager();
        
        //on recup un post par son id via le postmanager
        $post = $pm->findOne(intval($postId));
        //on recupere les categories via le categorymanager
        $categories = $cm->findAll();
        //on recup les commentaires du post repere par son id
        $comments = $com->findByPost(intval($postId));
        
        //si le post existe
        if($post !== null)
        {
            $this->render("post", [
                "post" => $post,
                "categories" => $categories,
                "comments" => $comments
            ]);
        }
        else //sinon on redirige vers la page d'accueil
        {
            $this->redirect("index.php");
        }
    }

    public function checkComment() : void
    {
    if(isset($_POST["csrf-token"]) && isset($_POST["content"]) && isset($_POST["post-id"]) && isset($_SESSION["user"]))
        {
            $tokenManager = new CSRFTokenManager();

            if($tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
                $um = new UserManager();
                $pm = new PostManager();
                $cm = new CommentManager();

                $post = $pm->findOne(intval($_POST["post-id"]));
                $user = $um->findOne($_SESSION["user"]);
                $comment = new Comment(htmlspecialchars($_POST["content"]), $user, $post);
                $cm->create($comment);
            }
        }
        $this->redirect("index.php?route=post&post_id={$_POST["post-id"]}");
    }
}
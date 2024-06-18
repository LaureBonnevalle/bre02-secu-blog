<?php

session_start();

require "config/autoload.php";

//d'abord on verif si y'a deja un token pour la session des qu on est sur le site si n'existe pas on en creer un. on instancie un tokenmanager via le CRSTFTokenManager.php du dossier service
if(!isset($_SESSION["csrf-token"]))
{
    $tokenManager = new CSRFTokenManager();
    $token = $tokenManager->generateCSRFToken();

    $_SESSION["csrf-token"] = $token;
    
   /*echo"<pre>";
    var_dump ($token);
    echo"</pre>";*/
}



$router = new Router();

$router->handleRequest($_GET);
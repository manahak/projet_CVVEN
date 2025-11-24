<?php
session_start();
    include 'csrf.class.php';
        $csrf = new csrf();
        $token_id = $csrf->get_token_id();
        $token_value = $csrf->get_token($token_id);
        if($csrf->check_valid('get')){
            // affichage du jeton
            echo "Le jeton est bon : ";
            var_dump($_GET[$token_id]);
            echo "</br>";
            echo "Nom : ".$_GET[fullname];
            echo "</br>";
            echo "email : ".$_GET[email];
           }else{
            // affichage message d'erreur
            echo "Le jeton n'est pas bon !";
        }
?>


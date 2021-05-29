<?php
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=pass;charset=utf8', 'collegedesetoiles', 'clg');
        }    
        catch(PDOException $e)
        {
            die('Erreur'.$e -> getMessage());
        }
    ?>
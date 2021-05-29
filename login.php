<?php 
    session_start();
    require_once 'config.php';

    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $check = $bdd->prepare('SELECT pseudo, qrcode, cat, email, password FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $sata2 = $check->fetch();
        $row = $check->rowCount();

        if($row == 1)
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                
                if(password_verify($password, $data['password']))
                {
                    if($data['cat'] ===  "eleve" || $data['cat'] === "Eleve" || $data['cat'] === "élève" || $data['cat'] === "Elève"|| $data['cat'] === "elève" || $data['cat'] === "éleve")
                    {
                        $_SESSION['user'] = $data['qrcode']  ;
                       
                   
                    header('Location: qrcodeuser.php');
                    die(); 
                    }elseif($data['cat'] === "professeur" || $data['cat'] === "Professeur" )
                    {
                        $_SESSION['user'] = $data['pseudo'];
                   
                    header('Location: scannerQRcode.php');
                    die(); 
                    }
                    
                   
                }else{ header('Location: connection.php?login_err=password'); die(); }
            }else{ header('Location: connection.php?login_err=email'); die(); }
        }else{ header('Location: connection.php?login_err=already'); die(); }
    }
    ?>
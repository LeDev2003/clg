
  
<?php 
    require_once 'config.php';

    if(!empty($_POST['pseudo']) && !empty($_POST['categorie']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_retype']) && !empty($_POST['qrcode']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $cat = htmlspecialchars($_POST['categorie']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);
        $qrcode = htmlspecialchars($_POST['qrcode']);

        $check = $bdd->prepare('SELECT pseudo, cat, email, qrcode, password FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        if($row == 0){ 
            if(strlen($pseudo) <= 100){
                if(strlen($email) <= 100){
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        if($password === $password_retype){

                            $cost = ['cost' => 12];
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                            
                            $ip = $_SERVER['REMOTE_ADDR'];

                            /*
                                Pour ceux qui souhaite mettre en place un système de mot de passe oublié, pensez à mettre le champ token dans votre requête
                                $insert = $bdd->prepare('INSERT INTO utilisateurs(pseudo, email, password, ip, token) VALUES(:pseudo, :email, :password, :ip, :token)');
                                $insert->execute(array(
                                    'pseudo' => $pseudo,
                                    'email' => $email,
                                    'password' => $password,
                                    'ip' => $ip,
                                    'token' =>  bin2hex(openssl_random_pseudo_bytes(24))
                                ));
                              */
                            
                            $insert = $bdd->prepare('INSERT INTO utilisateurs(pseudo, cat, email, password, ip, qrcode) VALUES(:pseudo, :cat, :email, :password, :ip, :qrcode)');
                            $insert->execute(array(
                                'pseudo' => $pseudo,
                                'cat' => $cat,
                                'email' => $email,
                                'password' => $password,
                                'ip' => $ip,
                                'qrcode' => $qrcode
                            ));

                            header('Location:connection.php?reg_err=success');
                            die();
                        }else{ header('Location: popup.php?reg_err=password'); die();}
                    }else{ header('Location: popup.php?reg_err=email'); die();}
                }else header('Location: popup.php?reg_err=email_length'); die();
            }else{ header('Location: popup.php?reg_err=pseudo_length'); die();}
        }else{ header('Location: popup.php?reg_err=already'); die();}
    }

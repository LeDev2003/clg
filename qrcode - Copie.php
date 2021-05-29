<?php
    require_once "login.php";
    require_once "config.php";
$server = 'localhost';
        $username = "collegedesetoiles";
        $password = "clg";
        $dbname = "pass";

        $conn = new mysqli($server, $username, $password, $dbname);

        if($conn->connect_error){
            die('connexion failed' .$conn->connect_error);
        } 
        $input = $_POST['input'];
        
if(!empty($_POST['input']))
        {
          
            $input = $_POST['input'];
          $sql  = "INSERT INTO presence(STUDENTID, timemin, present) VALUES('$input', NOW(), 'oui')" ;
          $check = $bdd->prepare('SELECT qrcode FROM utilisateurs');
          $data = $check->fetch();
          if($conn ->query($sql) === TRUE)
          {
              echo "connect succesfull";
              
              if($input !== $_SESSION['user'] )
              {
                header('Location: scannerQRcode.php?'.$input.'_connect'); 
                
            }
              elseif($input === $_SESSION['user'])
              {header('Location: scannerQRcode.php?'.$input.'_disconnect');} 
          }
          else{
              echo "error:".$sql."<br>".$conn->error;
                      }
        }$conn->close();

        ?>
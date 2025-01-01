<?php

class Change extends Database{
    protected function update_password($user_id, $email, $odlPass, $newPass){
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE user_id = ? OR user_password = ?;");

        if(!$stmt ->execute(array($user_id, $odlPass))){
            $stmt = null;
            echo"error updating password";
            exit();
        }
       
        if($stmt -> rowCount() == 0){
            $stmt = null;
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'> Error occur</p>";
        
            exit();
        }
        $hash = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $verifiedpassword = password_verify($odlPass, $hash[0]['user_password']);

        if($verifiedpassword == false){
            $stmt = null;
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'> Wrong password</p>";
        
            
            exit();
        }
        /*if($verifiedpassword !== $newPass){
            $stmt = null;
            header("location: ../menu/profile.php?error=old-password-is-matching-with-new-password");
            exit();
        }*/
        elseif($verifiedpassword == true){
            $stmt = $this->connect()->prepare("UPDATE users SET user_password = ? WHERE  user_id = ?");
            $hash = password_hash($newPass, PASSWORD_DEFAULT);
            if(!$stmt ->execute(array($hash, $user_id))){
                $stmt = null;
                
                exit();
            }
             echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'>  password updated</p>";
        
           
        }
       
    }
}
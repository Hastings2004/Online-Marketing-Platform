<?php

class Login extends Database{
    protected function verify_user($username ,$password){
        $stmt = $this -> connect() -> prepare("SELECT * FROM users WHERE username = ? OR user_email = ?");
        if(!$stmt -> execute(array($username, $username))){
            $stmt = null;
            echo "error";
            exit();
        }

        if($stmt -> rowCount() == 0){
            $stmt = null;
            echo "Username Or email does not exist";
            exit();
        }

        $hashedPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!password_verify($password, $hashedPassword[0]["user_password"])){
            $stmt = null;
            echo "wrong password try again";
            exit();
        }
        else{
            $stmt = $this -> connect() -> prepare("SELECT * FROM users WHERE user_email = ? OR username = ? AND user_password = ?");
            if(!$stmt -> execute(array($username, $username ,$password))){
                $stmt = null;
                echo "error";
                exit();
            }

            $userdetails = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            session_start();

            $_SESSION['user_id'] = $userdetails[0]['user_id'];
            $_SESSION['first_name'] = $userdetails[0]['first_name'];
            $_SESSION['last_name'] = $userdetails[0]['last_name'];
            $_SESSION['user_email'] = $userdetails[0]['user_email'];
            $_SESSION['username'] = $userdetails[0]['username'];
        }
    }
}
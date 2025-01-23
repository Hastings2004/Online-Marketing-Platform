<?php

class Authentication extends Database{
    protected function insert_users($firstName, $lastName, $email, $username, $password, $user_type){
        $stmt = $this->connect()->prepare("INSERT INTO users (first_name,last_name,user_password,email,username) 
        VALUES (?,?,?,?,?)");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        if(!$stmt->execute(array($firstName, $lastName, $hashedPassword, $email, $username))){
            $stmt = null;
            echo "error";
            exit();
        }        
       
        $message = "You have new application from ".$firstName."";
        $stmt = $this -> connect() -> prepare("INSERT INTO notifications (user_id,message_created, is_read) VALUES (?, ?,?)");
            if(!$stmt -> execute(array(1, $message, 0))){
                $stmt = null;
                echo "error";
                exit();
        }
               
     
    }

    protected function check_users($email, $username){
        $stmt = $this -> connect() -> prepare("SELECT * FROM users WHERE user_email = ? OR username = ?");

        if(!$stmt -> execute(array($email, $username))){
            $stmt = null;
            echo "error";
            exit();
        }

        $result = false;
        if($stmt -> rowCount() > 0){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    protected function verify_user($username ,$password){
        $stmt = $this -> connect() -> prepare("SELECT * FROM users WHERE user_email = ? OR username = ?");
        if(!$stmt -> execute(array($username, $password))){
            $stmt = null;
            echo "error";
            exit();
        }

        if($stmt -> rowCount() == 0){
            $stmt = null;
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Username  does not exist!!</p>";
            exit();
        }

        $hashedPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!password_verify($password, $hashedPassword[0]["user_password"])){
            $stmt = null;
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>wrong password try again!!</p>";
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
            $_SESSION['last_name'] = $userdetails[0]['last_name'];
            $_SESSION['user_email'] = $userdetails[0]['user_email'];
            $_SESSION['username'] = $userdetails[0]['username'];
            $_SESSION['first_name'] = $userdetails[0]['first_name'];

           
            $stmt = $this-> connect() -> prepare('SELECT * FROM user_roles WHERE user_id = ?');
            if(!$stmt -> execute(array($userdetails[0]['user_id']))){
                $stmt = null;
                echo 'error';
                exit();
            }

            if($stmt -> rowCount() == 0){
                $stmt = null;
                echo 'OOPS!! Wait for admin to approve your application ';
                $message = "You have new application from ".$userdetails[0]['first_name']."";
                $stmt = $this -> connect() -> prepare("INSERT INTO notifications (user_id,message_created, is_read) VALUES (?, ?, ?)");

                if(!$stmt -> execute(array(1, $message, 0))){
                    $stmt = null;
                    echo "error";
                    exit();
                }

                
            }
           
            $roles = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            if($roles[0]['role_id'] == 2){
                header("Location: admin/admin-dash.php");
            }
            elseif($roles[0]["role_id"] == 1){
                $stmt = $this -> connect() -> prepare("SELECT user_id FROM customers WHERE user_id = ?");
                
                    if(!$stmt -> execute(array($userdetails[0]["user_id"]) )){
                        $stmt = null;
                        echo "";
                        exit();

                    }

                    if($stmt -> rowCount() == 0){
                        $stmt = $this -> connect() -> prepare("INSERT INTO customers (user_id) VALUES (?)");

                        if($stmt -> execute(array($userdetails[0]["user_id"]) )){
                            $stmt = null;
                            echo "";
                            exit();
                        }

                    }
               
                header("Location: customer/home.php");
            }
             elseif($roles[0]["role_id"] == 3){
                $stmt = $this -> connect() -> prepare("SELECT user_id FROM merchants WHERE user_id = ?");
                    if(!$stmt -> execute(array($userdetails[0]["user_id"]) )){
                        $stmt = null;
                        echo "";
                        exit();

                    }

                    if($stmt -> rowCount() == 0){
                        $stmt = $this -> connect() -> prepare("INSERT INTO merchants (user_id) VALUES (?)");

                        if(!$stmt -> execute(array($userdetails[0]["user_id"]) )){
                            $stmt = null;
                            echo "";
                            exit();
                        }

                    }

                    
                    header("location: merchant/dash-merch.php");

            }
            else{
                
            }
        }
    }
    public function assign_roles($email, $role_name, $username) {
        $stmt = $this -> connect() -> prepare("SELECT * FROM users WHERE user_email = ? OR username = ?");
        if(!$stmt -> execute(array($email, $username))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }

        if($stmt -> rowCount() == 0) {
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Username not found </p>";
       
            exit();
        }

        $users = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM roles WHERE role_name = ?");
        if(!$stmt -> execute(array($role_name))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }

        if($stmt -> rowCount() == 0) {
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Role name not found </p>";
       
            exit();
        }

        $roles = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?,?)");

        if(!$stmt -> execute(array($users[0]['user_id'], $roles[0]['role_id']))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }
        //echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'>Role successfully assigned </p>";
       
    }

    
}
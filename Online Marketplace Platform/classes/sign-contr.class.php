<?php

class Sign_contr extends Signup_Validation{
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $username;
    private $cpassword;

    public function __construct($firstName, $lastName, $email, $username, $password, $cpassword){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->cpassword = $cpassword;
    }

    public function set_user(){
        $this -> isvalidation($this->firstName, $this->lastName, $this->email,$this->username ,$this->password, $this->cpassword);
    }
    public function get_user(){
        $this -> validUser($this->email, $this->username, $this->password);
    }
    
    protected function isvalidation($firstName, $lastName, $email, $username, $password, $cpassword){
        if($this -> validateName($firstName, $lastName) == false){
            echo "Please enter use letter only.";
            exit();
        }
        if($this -> validateEmail($email) == false){
            echo "Please enter a valid email.";
            exit();
        }
      /*  if($this -> validatePassword($password) == false){
            echo "Please enter a strong password with letters and numbers or symbol.";
            exit();
        }*/
        if($this -> validateCpassword($password,$cpassword) == false){
            echo "Password does not match";
            exit();
        }
        if($this -> validateUsername( $username) == false){
            echo "Please username must have letters and numbers.";
            exit();
        }
        if($this -> checking_user($email,$username) == false){
            echo "Email or Username already exists.";
            exit();
        }
        $this -> insert_users($firstName, $lastName, $email, $username, $password, $cpassword);
        echo"Successfully inserted";
    }

    public function validUser($username, $password){
        $this -> verify_user($username, $password);
    }

    private function emptyFields($firstName, $lastName, $email, $username, $password, $cpassword){

    }
    private function validateEmail($email){
        $result = false;
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    //checking strength of password
    private function validatePassword($password){
        $result = false;

        if(!preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9!@#$%^&*()_+=[\]{}|;':\\<>,.?/-]*$/", $password)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    // checking if username has letters and numbers
    private function validateUsername($username){
        $result = false;

        if(!preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9])/", $username)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;

    }

    // chcking if first name and last name has letters only
    private function validateName($firstname, $lastname){
        $result = false;
        if(!preg_match("/^[A-Za-z]{3,20}$/", $firstname) || !preg_match("/^[A-Za-z]{3,20}$/", $lastname)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    // check if password is equal to confirm password
    private function validateCpassword($password,$cpassword){
        $result = false;

        if($cpassword !== $password ){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function checking_user($email, $username){
        $result = false;
        if($this -> check_users($email,$username) === false){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    protected function insert_users($firstName, $lastName, $email, $username, $password){
        $stmt = $this->connect()->prepare("INSERT INTO users (first_name,last_name,user_email,username,user_password) 
        VALUES (?,?,?,?,?)");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        if(!$stmt->execute(array($firstName, $lastName, $email, $username, $hashedPassword))){
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
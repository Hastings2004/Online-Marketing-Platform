<?php

class Signup_Validation extends Authontication{

    // this function used to validate the data from the input fields
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
        echo "<p style='background-color: green; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                        You have successfully registered</p>";
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
}
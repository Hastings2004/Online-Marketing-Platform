<?php

class Update extends Change{
    private $email;
    private $oldpass;
    private $newPass;
    private $cPass;
    private $user_id;


    public function __construct($user_id,$email, $oldpass, $newPass, $cPass)
    {
        $this -> email = $email;
        $this -> oldpass = $oldpass;
        $this -> newPass = $newPass;
        $this ->user_id = $user_id;
        $this -> cPass = $cPass;
    }
    public function changePassword(){
       
        if($this -> validatePassword($this->newPass) == false){
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'>Please enter a strong password with letters and numbers</p>";
           
            exit();
        }
        if($this -> validatePasswordLength($this ->newPass) == false){
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'>Password should have atleast six characters</p>";
           
            exit();
        }
        if($this -> validateCpassword($this->newPass,$this->cPass) == false){
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'> Confirm password does not match</p>";
        
           
            exit();
        }
        
         $this -> update_password($this ->user_id,$this-> email, $this -> oldpass, $this -> newPass);
       
          
    }
    public function reset_password(){
         if($this -> validatePassword($this->newPass) == false){
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'>Please enter a strong password with letters and numbers</p>";
           
            exit();
        }
        if($this -> validatePasswordLength($this ->newPass) == false){
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'>Password should have atleast six characters</p>";
           
            exit();
        }
        if($this -> validateCpassword($this->newPass,$this->cPass) == false){
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'> Password does not match</p>";
        
           
            exit();
        }
        $this -> resert_password($this -> email,$this-> user_id, $this -> newPass);
    }
   
   
    //checking strength of password
    private function validatePassword($password){
        $result = false;

        if(!preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9])/", $password) ){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function validatePasswordLength($password){
        $result = false;

        if(strlen($password) < 6){
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

    
}
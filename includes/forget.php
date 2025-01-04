<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget password</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <div>
                <h3>Reset Password</h3>
            </div>
            <form action="forget.php" method="post" id="form">
                <div class="form-content">
                    <div class="form-details">
                        <label for="username">Username</label> <br>
                        <input type="text" name="username" id="username" class="input" placeholder="John5"> <br>
                        <span id="username-error" style="color: red;"></span>
                     </div>
                    <div class="form-details">
                        <label for="email">Email</label> <br>
                        <input type="email" name="email" id="email" class="input" placeholder="johndoe@gmail.com"> <br>
                        <span id="email-error" style="color: red;"></span>
                    </div>
                    <div class="form-details">
                       <label for="password">Password</label> <br>
                       <input type="password" name="password" id="password" class="input" placeholder="password1234"> <br>
                       <span id="password-error" style="color: red;"></span>
                    </div>
                    <div class="form-details">
                        <label for="password">Confirm Password</label> <br>
    
                        <input type="password" name="cpassword" id="cpassword" class="input" placeholder="password1234"> <br>
                        <span id="cpassword-error" style="color: red;"></span>
                     </div>
                  
                    <div class="form-details">
                        <button type="submit" name="update-password">Register</button>
                    </div>
                    <div class="account">
                        <div>
                            <p>Already have account? <span> <a href="../index.php">Sign in</a></span></p>
                        </div>                       
                    </div>
                    <div class="validation">
                        <?php

                        if(isset($_POST['update-password'])){
                            $email = $_POST['email'];
                            $username = $_POST['username'];
                            $password = $_POST['password'];
                            $cpassword = $_POST['cpassword'];


                            include("../database/database.php");
                            include '../classes/change.class.php';
                            include '../classes/change-contr.class.php';
                           

                           $reset = new Update($username,$email,$password,$password,$cpassword);
						   $reset -> reset_password();
                        }
                        ?>
                    </div>
                </div>                
            </form>

        </div>
        
    </div>
    <script>
      
        let email = document.getElementById("email");

        let password = document.getElementById("password");

        let username = document.getElementById("username");

        let cpassword = document.getElementById("cpassword");
                
        let username_error = document.getElementById("username-error");

        let password_error = document.getElementById("password-error");   

        let cpassword_error = document.getElementById("cpassword-error");

        let email_error = document.getElementById("email-error");

        let form = document.getElementById("form");
        
        let email_pattern = /^[A-Za-z\._\-0-9]*[@][A-Za-z.]*[\.][a-z]{2,4}$/;

        let name_pattern = /^[A-Za-z]{3,20}$/;

        let username_pattern = /^(?=.*[a-zA-Z])(?=.*[0-9])/;

        let password_pattern = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9!@#$%^&*()_+=[\]{}|;':"\\<>,.?/-]*$/;


        form.addEventListener("submit",(e)=>{
            if(email.value === ""){
                e.preventDefault();
                email_error.textContent = "Please enter your email";
            }
            else{
                    if(!email.value.match(email_pattern)){
                        e.preventDefault();
                        email_error.textContent = "Please enter an valid email";
                    }
                    else if(email.value.length < 5 || email.value.length > 255) {
                        e.preventDefault();
                        email_error.textContent = "Email should have atleast 5 to 20 characters";
                    }
                    else{
                        email_error.textContent = "";
                    }
            }
            if(password.value === ""){
                e.preventDefault();
                password_error.textContent = "Please enter password";
            }
            else{
                if(password.value.length < 6){
                    e.preventDefault();
                    password_error.textContent = "Please enter six characters";
                }
                else if(!password.value.match(password_pattern)){
                    e.preventDefault();
                    password_error.textContent = "Please enter strong  password with letters and numbers or symbols";
                }
                else{
                password_error.textContent = "";
                }
                
            }
            if(cpassword.value === ""){
                e.preventDefault();
                cpassword_error.textContent = "Please enter confirm password";
            }
            else{
                if(cpassword.value !== password.value){
                    e.preventDefault();
                    cpassword_error.textContent = "Password does not matches";
                }
                else{
                    cpassword_error.textContent = "";
                }
            }

            if(username.value === ""){
                e.preventDefault();
                username_error.textContent = "Please enter username";
            }
            else{
                if(!username.value.match(username_pattern)){
                    e.preventDefault();
                    username_error.textContent = "Username must have letters and numbers";
                }
                else if(username.value.length < 4 || username.value.length > 25) {
                    e.preventDefault();
                    username_error.textContent = "Username should have atleast 4 to 20 characters";
                }
                else{
                    username_error.textContent = "";
                }
            }

        });

    </script>
</body>
</html>
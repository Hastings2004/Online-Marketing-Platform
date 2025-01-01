<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <div>
                <h3>Create Account</h3>
            </div>
            <form action="sign-up.php" method="post" id="form">
                <div class="form-content">
                    <div class="form-details">
                        <label for="fname">First Name</label> <br>
                        <input type="text" name="fname" id="fname" class="input" placeholder="John"> <br>
                        <span id="fname-error" style="color: red;"></span>
                    </div>
                    <div class="form-details">
                       <label for="lname">Last Name</label> <br>
                       <input type="text" name="lname" id="lname" class="input" placeholder="Doe"> <br>
                       <span id="lname-error" style="color: red;"></span>
                    </div>
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
                        <button type="submit" name="register">Register</button>
                    </div>
                    <div class="account">
                        <div>
                            <p>Already have account? <span> <a href="../index.php">Sign in</a></span></p>
                        </div>                       
                    </div>
                    <div class="validation">
                        <?php

                        if(isset($_POST['register'])){
                            $firstname = $_POST['fname'];
                            $lastname = $_POST['lname'];
                            $email = $_POST['email'];
                            $username = $_POST['username'];
                            $password = $_POST['password'];
                            $cpassword = $_POST['cpassword'];


                            include("../database/database.php");
                            include("../classes/authntication.class.php");
                            include("../classes/signup-validation.class.php");
                            include("../classes/sign-contr.class.php");

                            $signUp = new Sign_contr($firstname, $lastname, $email, $username, $password, $cpassword);
                            $signUp -> set_user();
                            header('Location: ../user_type.php');
                        }
                        ?>
                    </div>
                </div>                
            </form>

        </div>
        
    </div>
    <script src="../js/index.js"></script>
</body>
</html>
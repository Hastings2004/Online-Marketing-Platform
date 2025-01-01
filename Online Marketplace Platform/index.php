<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/index.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="head">
        <marquee behavior="" direction="left-right"><h1>Online <br> Marketing Platform</h1></marquee>
            
        </div>
        <div class="content">
            <div>
                <h3>Login</h3>
            </div>
            <form action="" method="post" id="form">
                <div class="form-content">
                    <div class="form-details">
                        <label for="email">Username</label> <br>
                        <i class="fa-solid fa-user" id="icon"></i>
                        <input type="text" name="username" id="username" class="input" placeholder="example@gmail.com"> <br>
                        <span id="username-error" style="color: red;"></span>
                    </div>
                    <div class="form-details">
                       <label for="password">Password</label> <br>
                       <div style="display: flex;">
                            <i class="fa-sharp fa-solid fa-lock" id="icon"></i>
                            <input type="password" name="password" id="password" class="input" placeholder="password1234"> <br>
                       </div>
                      
                       <span id="password-error" style="color: red;"></span>
                    </div>
                    <div class="forget">
                       
                        <p> <input type="checkbox" name="checkbox"> Remember me <span><a href="">Forget Password?</a></span></p>
                    </div>
                    <div class="form-details">
                        <button type="submit" name="login">Login</button>
                    </div>
                    <div class="account">
                        <div>
                            <p>Don't have account? <span> <a href="includes/sign-up.php">Create account</a></span></p>
                        </div>                       
                    </div>
                    <div class="validation">
                        <?php
                            if(isset($_POST["login"])){
                                $username = $_POST["username"];
                                $password = $_POST["password"];

                                include("database/database.php");
                                include("classes/authntication.class.php");
                                include("classes/signup-validation.class.php");
                                include("classes/users.class.php");

                                $login = new Signup_Validation();
                                $login-> validUser($username, $password);                               
                            }
                        
                        ?>
                    </div>
                </div>                
            </form>
        </div>
    </div>
    <script>
        let username = document.getElementById("username");
        let password = document.getElementById("password");
        let password_error = document.getElementById("password-error");
        let username_error = document.getElementById("username-error");
        let form = document.getElementById("form");
        form.addEventListener("submit",(e)=>{

            if (username.value === "") {
                e.preventDefault();
                username_error.textContent = "Please enter a username";
            }
            else{
                username_error.textContent ="";
            }

            if(password.value === ""){
                e.preventDefault();
                password_error.textContent = "Please enter password";
            }
            else{
                username_error.textContent = "";
            }
        });
        
    </script>
</body>
</html>
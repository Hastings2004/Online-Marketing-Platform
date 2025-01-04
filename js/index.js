let fname = document.getElementById("fname");

let lname = document.getElementById("lname");

let email = document.getElementById("email");

let password = document.getElementById("password");

let username = document.getElementById("username");

let cpassword = document.getElementById("cpassword");

let username_error = document.getElementById("username-error");

let password_error = document.getElementById("password-error");   

let cpassword_error = document.getElementById("cpassword-error");

let fname_error = document.getElementById("fname-error");

let lname_error = document.getElementById("lname-error");

let email_error = document.getElementById("email-error");

let form = document.getElementById("form");

let email_pattern = /^[A-Za-z\._\-0-9]*[@][A-Za-z.]*[\.][a-z]{2,4}$/;

let name_pattern = /^[A-Za-z]{3,20}$/;

let username_pattern = /^(?=.*[a-zA-Z])(?=.*[0-9])/;

let password_pattern = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9!@#$%^&*()_+=[\]{}|;':"\\<>,.?/-]*$/;


form.addEventListener('submit', (e)=>{

    if(fname.value === ""){
        e.preventDefault();
        fname_error.textContent = "Please enter a name";
    }
    else {
        
        if(!fname.value.match(name_pattern)){
            e.preventDefault();
            fname_error.textContent = "Please enter a letter only";
        }
        else if(fname.value.length < 4 || fname.value.length > 20) {
            e.preventDefault();
            fname_error.textContent = "Name should have atleast 4 to 20 characters";
        }

        else{
            fname_error.textContent = "";
        }
    }

    if(lname.value === ""){
        e.preventDefault();
        lname_error.textContent = "Please enter a name";
    }
    else {
        
        if(!lname.value.match(name_pattern)){
            e.preventDefault();
            lname_error.textContent = "Please enter a letter only";
        }
        else if(lname.value.length < 4 || lname.value.length > 20) {
            e.preventDefault();
            lname_error.textContent = "Name should have atleast 4 to 20 characters";
        }
        else{
            lname_error.textContent = "";
        }
    }

    if(email.value === ""){
        e.preventDefault();
        email_error.textContent = "Please enter an email";
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
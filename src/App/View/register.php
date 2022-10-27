<?php
    defined('BASEPATH') OR exit('No direct access to script allowed');
    if (isset($_SESSION["user_id"])) {
        header("Location: "."/");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./layout/assets/css/register-2.css" />
        <title>Binotify</title>
    </head>

    <body>
        <div class="flex">
            <img src="./layout/assets/img/binotify.png" width=100>
            <h1 class="title">Binotify</h1>
        </div>
        <h1>Sign up for free to start <br/> listening.</h1>
        
        <form method="POST">
            <section>
                <label for="email"><b>What's your email?</b></label><p id="errorEmail"></p>
                <input type="text" id="email" name="email" onkeyup={processChange()} placeholder="Enter your email.">
            </section>
            <section>
                <label for="email"><b>Confirm your email</b></label>
                <input class="margintop" type="text" id="emailagain" name="email" placeholder="Enter your email again.">
            </section>
            <section>
                <label for="password"><b>Create a password</b></label>
                <input class="margintop" type="password" id="password" name="password" placeholder="Create a password.">
            </section>
            <section>
                <label for="username"><b>What should we call you?</b></label><p id="errorUsername"></p>
                <input type="text" id="username" name="username" onkeyup={processChange()} placeholder="Enter a username.">
            </section>
        </form>
        <p>By clicking on sign-up, you agree to Spotify's Terms and Conditions of Use.</p>
        <button type="button" onclick={register(event)} ><b>Sign up</b></button>
        <p>Have account? <a href="/login" class="button-text">Log in</a> </p>
        
    </body>

    <script>
        let usernameIsAvailable = false;
        let emailIsAvailable = false;
    
        function debounce(func, timeout = 500){
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }
        function check(){
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const xhr = new XMLHttpRequest();
            const xhr2 = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                let res = JSON.parse(xhr.responseText);
                if (res.status==404) {
                    // Username not found, hence can be used
                    usernameIsAvailable = true;
                    document.getElementById('username').style.border = "1px solid green";
                    document.getElementById('errorUsername').innerHTML = '';
                } else if(res.status==200){
                    // Username found, hence cannot be used
                    usernameIsAvailable = false;
                    document.getElementById('username').style.border = "1px solid red";
                    document.getElementById('errorUsername').innerHTML = "Username already exists";
                }
            }

            xhr2.onreadystatechange = function() {
                let res2 = JSON.parse(xhr2.responseText);
                console.log(res2)
                if (res2.status==404) {
                    // Email not found, hence can be used
                    emailIsAvailable = true;
                    document.getElementById('email').style.border = "1px solid green";
                    document.getElementById('errorEmail').innerHTML = '';
                } else if(res2.status==200){
                    // Email found, hence cannot be used
                    emailIsAvailable = false;
                    document.getElementById('email').style.border = "1px solid red";
                    document.getElementById('errorEmail').innerHTML = "Email already exists";
                }
            }

            xhr2.open("GET", `/email?email=${email}`);
            xhr.open("GET", `/username?username=${username}`);
            
            xhr.send();
            xhr2.send();
        }

        const processChange = debounce(() => check());

        const register = (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const emailagain = document.getElementById('emailagain').value;
            const password = document.getElementById('password').value;
            const username = document.getElementById('username').value;

            let emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            let usernameRegex = /^[a-zA-Z0-9_]+$/;
            
            if (email===emailagain) {
                if (emailRegex.test(email) && emailIsAvailable) {
                    if (usernameRegex.test(username) && usernameIsAvailable) {
                        if (password.length >= 8) {
                            const payload = {
                                email,
                                password,
                                username
                            }

                            const xhr = new XMLHttpRequest();

                            xhr.onload = function() {
                                if (xhr.status==201){
                                    window.location.href="/login";
                                }
                            }

                            xhr.open("POST", "/register");
                            xhr.setRequestHeader("Content-type", "application/json");
                            xhr.send(JSON.stringify(payload));
                        } else {
                            alert("Password must be at least 8 characters long.");
                        }
                    } else {
                        alert("Invalid username characters")
                    }
                } else {
                    alert("Invalid email");
                }
            } else{
                alert("Please enter the same email for confirmation");
            }
        }
    </script>
</html>
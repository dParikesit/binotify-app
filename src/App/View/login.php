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
        <link rel="stylesheet" href="./layout/assets/css/login.css" />
        <title>Binotify</title>
    </head>

    <body>
        <div class="flex">
            <img src="./layout/assets/img/binotify.png" width=100>
            <h1 class="title">Binotify</h1>
        </div>
        <hr class="solid first-divider">

        <p><b>To continue, login to Spotify.</b></p>
        
        <form method="POST">
            <section>
                <span for="username"><b>Username</b></span>
                <input type="text" id="username" name="username" placeholder="Username">
            </section>
            
            <section>
                <label for="password"><b>Password</b></label>
                <input type="password" id="password" name="password" placeholder="Password">
            </section>
        </form>

        <div class="submit-container">
            <!-- <section class="submit-remember">
                <input type="checkbox" name="rememberme" id="rememberme">
                <label for="rememberme">Remember me</label>
            </section> -->
            
            <button type="button" onclick={login(event)} ><b>LOG IN</b></button>
        </div>

        <hr class="solid second-divider">

        <div class="register-redirect">
            <p><b>Don't have an account?</b></p>
            <button onclick={location.href="/register"} class="button-register">
                SIGN UP FOR SPOTIFY
            </button>
        </div>
        
    </body>

    <script>
        const login = (e) => {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            const payload = {
                username,
                password
            }

            const xhr = new XMLHttpRequest();

            xhr.onload = function() {
                if (xhr.status==200){
                    window.location.href="/";
                } else{
                    let res = JSON.parse(xhr.responseText);
                    alert(res.error)
                }
            }

            xhr.open("POST", "/login");
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send(JSON.stringify(payload));
        }
    </script>
</html>
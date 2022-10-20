<?php defined('BASEPATH') OR exit('No direct access to script allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./app/style/style.css" />
        <title>Notes App</title>
    </head>

    <body>

        <h3>Register as User</h3>
        
        <div>
            <form method="POST">
                <label for="fname">Email</label>
                <input type="text" id="femail" name="email" placeholder="Your name..">

                <label for="lname">Password</label>
                <input type="text" id="lpassword" name="password" placeholder="Your password..">

                <label for="lname">Username</label>
                <input type="text" id="lusername" name="username" placeholder="Your username..">

            </form>
            <button type="button" onclick={register(event)} >Submit</button>
            <div class="flex">
                <p>Have account? </p>
                <a href="/login" class="button-text">Login</a>
            </div>
        </div>
        
    </body>

    <script>
        const register = (e) => {
            e.preventDefault();
            const email = document.getElementById('femail').value;
            const password = document.getElementById('lpassword').value;
            const username = document.getElementById('lusername').value;
            const payload = {
                email,
                password,
                username
            }

            const xmlhttp = new XMLHttpRequest();
            // xmlhttp.onload = () => {
            //     if (xmlhttp.status != 200){
            //     return;      
            //     }
            //     window.location.href = '/';
            // }
            // xmlhttp.onreadystatechange = function() {
            //     console.log(this.responseText)
            // };

            xmlhttp.open("POST", "/App/Controller/Register.php");
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(payload));
        }
    </script>
</html>
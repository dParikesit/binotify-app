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
                <label for="fname">Name</label>
                <input type="text" id="fname" name="fullname" placeholder="Your name..">

                <label for="lname">Username</label>
                <input type="text" id="lname" name="username" placeholder="Your username..">

                <label for="lname">Password</label>
                <input type="text" id="lname" name="password" placeholder="Your password..">

                <input type="submit" name="submit" value="Submit">
            </form>
            <div class="flex">
                <p>Have account? </p>
                <a href="/login" class="button-text">Login</a>
            </div>
        </div>
        
        </body>
</html>
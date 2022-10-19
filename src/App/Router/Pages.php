<?php

namespace App\Router;

$route = new Router();

$route->add('/', function () {
    include "register.php";
});

$route->add('/register', function() {
    include "register.php";
});

$route->add('/login', function() {
    include "login.php";
});

$route->listen();

?>
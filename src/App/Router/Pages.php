<?php

namespace App\Router;

$route = new Router();

$route->add('/', function () {
    include "login.php";
});

$route->add('/register', function() {
    include "register.php";
});

$route->add('/login', function() {
    include "login.php";
});

$route->add('/search', function() {
    include "search.php";
});

$route->add('/home', function() {
    include "home.php";
});

$route->add('/detailsong', function() {
    include "detailsong.php";
});

$route->add('/detailalbum', function() {
    include "detailalbum.php";
});

$route->add('/addsong', function() {
    include "addsong.php";
});

$route->add('/addalbum', function() {
    include "addalbum.php";
});

$route->add('/listalbum', function() {
    include "listalbum.php";
});

$route->add('/users', function() {
    include "users.php";
});

$route->listen();

?>
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

$route->add('/listalbum', function() {
    include "listalbum.php";
});

$route->listen();

?>
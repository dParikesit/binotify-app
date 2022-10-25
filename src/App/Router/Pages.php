<?php

use App\Router\Router;
use App\Controller\{HomeController, UserController, SearchSongController};

$router = new Router();
$router->get("/", function(){
    $home = new HomeController();
    $home->index();
});

$router->get("/login", function(){
    $home = new UserController();
    $home->viewLogin();
});
$router->get("/register", function(){
    $home = new UserController();
    $home->viewRegister();
});

$router->post("/login", function(){
    $home = new UserController();
    $home->login();
});
$router->post("/register", function(){
    $home = new UserController();
    $home->register();
});

$router->post("/search", function(){
    $home = new SearchSongController();
    $home->searchSong();
});

$router->run();

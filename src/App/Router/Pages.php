<?php

use App\Router\Router;
use App\Controller\{HomeController, UserController, SongController, AlbumController};

$router = new Router();
$router->get("/", function(){
    $home = new HomeController();
    $home->index();
});
// AUTH
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

//SONG
$router->get(`/detailsong?id=$id`, function(){
    $home = new SongController();
    $home->viewDetailSong($id);
});

$router->delete(`/deletesong?id=$id`, function(){
    $home = new SongController();
    $home->deleteSong();
});

$router->patch(`/updateSongToAlbum?id=$id`, function(){
    $home = new SongController();
    $home->updateSongToAlbum();
});

$router->patch(`/deleteSongFromAlbum?id=$id`, function(){
    $home = new SongController();
    $home->deleteSongFromAlbum();
});

//ALBUM

$router->delete(`/deletealbum?id=$id`, function(){
    $home = new AlbumController();
    $home->deleteAlbum();
});

$router->run();

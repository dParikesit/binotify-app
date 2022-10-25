<?php

use App\Router\Router;
use App\Controller\{HomeController, UserController, SearchSongController, SongController, AlbumController};

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
$router->post("/search", function(){
    $home = new SearchSongController();
    $home->searchSong();
});

$router->get(`/detailsong?id=$id`, function(){
    $home = new SongController();
    $home->viewDetailSong();
});

$router->get(`/addsong`, function(){
    $home = new SongController();
    $home->viewAddSong();
});

$router->post(`/addsong`, function(){
    $home = new SongController();
    $home->addSong();
});

$router->put(`/updatesong?id=$id`, function(){
    $home = new SongController();
    $home->updateSong();
});

$router->delete(`/deletesong?id=$id`, function(){
    $home = new SongController();
    $home->deleteSong();
});

$router->patch(`/updatesongtoalbum?id=$id`, function(){
    $home = new SongController();
    $home->updateSongToAlbum();
});

$router->patch(`/deletesongfromalbum?id=$id`, function(){
    $home = new SongController();
    $home->deleteSongFromAlbum();
});

//ALBUM

$router->get(`/detailalbum?id=$id`, function(){
    $home = new AlbumController();
    $home->viewDetailAlbum();
});

$router->get(`/addalbum`, function(){
    $home = new AlbumController();
    $home->viewAddAlbum();
});

$router->post(`/addalbum`, function(){
    $home = new AlbumController();
    $home->addAlbum();
});

$router->put(`/updatealbum?id=$id`, function(){
    $home = new AlbumController();
    $home->updateAlbum();
});

$router->delete(`/deletealbum?id=$id`, function(){
    $home = new AlbumController();
    $home->deleteAlbum();
});

$router->run();

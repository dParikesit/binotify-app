<?php

use App\Router\Router;
use App\Controller\{HomeController, UserController, SearchSongController, SongController, AlbumController};
use App\Utils\FileServer;

$router = new Router();
$router->get("/", function(){
    $obj = new HomeController();
    $obj->index();
});

$router->get("/images", function(){
    $obj = new FileServer();
    $obj->image();
});

$router->get("/audios", function(){
    $obj = new FileServer();
    $obj->audio();
});

// AUTH
$router->get("/login", function(){
    $obj = new UserController();
    $obj->viewLogin();
});
$router->get("/register", function(){
    $obj = new UserController();
    $obj->viewRegister();
});
$router->get("/username", function(){
    $obj = new UserController();
    $obj->checkUsername();
});
$router->get("/email", function(){
    $obj = new UserController();
    $obj->checkEmail();
});
$router->get("/logout", function(){
    $obj = new UserController();
    $obj->logout();
});

$router->post("/login", function(){
    $obj = new UserController();
    $obj->login();
});
$router->post("/register", function(){
    $obj = new UserController();
    $obj->register();
});

$router->get("/users", function() {
    $obj = new UserController();
    $obj->viewListUser();
});

//SONG
$router->get("/search", function(){
    $obj = new SearchSongController();
    $obj->viewSearch();
});

$router->get("/detailsong", function(){
    $obj = new SongController();
    $obj->viewDetailSong();
});

$router->get("/getsong", function(){
    $obj = new SongController();
    $obj->detailSong();
});

$router->get("/addsong", function(){
    $obj = new SongController();
    $obj->viewAddSong();
});

$router->post("/addsong", function(){
    $obj = new SongController();
    $obj->addSong();
});

$router->post("/updatesong", function(){
    $obj = new SongController();
    $obj->updateSong();
});

$router->delete("/deletesong", function(){
    $obj = new SongController();
    $obj->deleteSong();
});

$router->patch("/updatesongtoalbum", function(){
    $obj = new SongController();
    $obj->updateSongToAlbum();
});

$router->patch("/deletesongfromalbum", function(){
    $obj = new SongController();
    $obj->deleteSongFromAlbum();
});

//ALBUM

$router->get("/detailalbum", function(){
    $obj = new AlbumController();
    $obj->viewDetailAlbum();
});

$router->get("/getalbum", function(){
    $obj = new AlbumController();
    $obj->detailAlbum();
});

$router->get("/addalbum", function(){
    $obj = new AlbumController();
    $obj->viewAddAlbum();
});

$router->post("/addalbum", function(){
    $obj = new AlbumController();
    $obj->addAlbum();
});

$router->post("/updatealbum", function(){
    $obj = new AlbumController();
    $obj->updateAlbum();
});

$router->delete("/deletealbum", function(){
    $obj = new AlbumController();
    $obj->deleteAlbum();
});

$router->get("/listalbum", function(){
    $obj = new AlbumController();
    $obj->viewAllAlbum();
});

$router->run();

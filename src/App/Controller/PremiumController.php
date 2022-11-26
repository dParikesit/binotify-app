<?php 
namespace App\Controller;

final class PremiumController {
    public function viewSinger(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/listpenyanyi.php";
    }

    public function viewSingerSong() {
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/listsong.php";
    }
}
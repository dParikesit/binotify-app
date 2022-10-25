<?php 
namespace App\Controller;

final class HomeController {
    public function index(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/home.php";
    }
}

?>
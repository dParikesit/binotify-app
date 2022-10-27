<?php 

namespace App\Utils;
require_once "HTTPException.php";

class FileServer {
    public function __construct() {
        $this->base_url = $_SERVER['DOCUMENT_ROOT']."/uploads";
    }

    public function image(){
        $requestedFile = $_GET["name"];
        $file = $this->base_url . "/images/" . $requestedFile;

        $contentType = mime_content_type($file);
        header("Content-type: $contentType");
        header('Content-Disposition: inline');
        header('Cache-Control: max-age=2600000');
        readfile($file);
    }

    public function audio(){
        if ($_SESSION["count"] >= 3 && !$_SESSION["user_id"]) {
            $res = new Response("You have reached the maximum number of downloads", 403);
            $res->sendJSON();
            return;
        } else{
            $requestedFile = $_GET["name"];
            $file = $this->base_url . "/audios/" . $requestedFile;
            $_SESSION["count"] += 1;

            $contentType = mime_content_type($file);
            header("Content-type: $contentType");
            header('Content-Disposition: inline');
            header('Cache-Control: max-age=2600000');
            readfile($file);
        } 
    }
}

?>
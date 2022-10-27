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
        session_start();
        if ($_SESSION["count"] < 3 || isset($_SESSION["user_id"])) {
            $_SESSION["count"] += 1;
            $requestedFile = $_GET["name"];
            $file = $this->base_url . "/audios/" . $requestedFile;

            $contentType = mime_content_type($file);
            header("Content-type: $contentType");
            header('Content-Disposition: inline');
            header('Cache-Control: max-age=2600000');
            readfile($file);
        }
    }
}

?>
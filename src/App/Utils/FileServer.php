<?php 

namespace App\Utils;

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
        $requestedFile = $_GET["name"];
        $file = $this->base_url . "/audios/" . $requestedFile;

        $contentType = mime_content_type($file);
        header("Content-type: $contentType");
        header('Content-Disposition: inline');
        header('Cache-Control: max-age=2600000');
        readfile($file);
    }
}

?>
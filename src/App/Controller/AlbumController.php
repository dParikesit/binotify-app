<?php 
namespace App\Controller;
use App\Service\AlbumService;
use App\Utils\{HTTPException, Response};

final class AlbumController {
    public function viewDetailAlbum(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/detailalbum.php";
    }

    public function viewAddAlbum(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/addalbum.php";
    }

    public function viewAllAlbum(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/listalbum.php";
    }

    public function detailAlbum() {
        try {
            $album_service = new AlbumService();
            $query = $_GET["id"];
            $result = $album_service->getAlbumById($query);
        
            if ($data) {
                $res = new Response('Success', 200, $result);
            } else {
                throw new HTTPException('Album not found', 404);
            }
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function deleteAlbum(){
        $_DELETE = json_decode(file_get_contents('php://input'), true);
        $album_id = isset($_DELETE['album_id']) ? $_DELETE['album_id'] : '';

        if (!$album_id){
            throw new HTTPException('Empty fields', 400);
        }


        try {
            $album_service = new AlbumService();
            $result = $album_service->delete($album_id);

            $res = new Response($result, 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function addAlbum() {
        try {
            $judul = isset($_POST['judul']) ? $_POST['judul'] : '';
            $penyanyi = isset($_POST['penyanyi']) ? $_POST['penyanyi'] : '' ;
            $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
            $tanggal_terbit = isset($_POST['tanggal_terbit']) ? $_POST['tanggal_terbit'] : '';
            
            if (!$judul || !$penyanyi || !$tanggal_terbit || !$genre){
                throw new HTTPException("Empty fields", 400);
            }
            
            // Image File
            if (!isset($_FILES['cover_file']['error']) || is_array($_FILES['cover_file']['error'])) {
                throw new HTTPException("Invalid parameters", 400);
            } else if ($_FILES['cover_file']['size'] > 10000000) { //10MB
                throw new HTTPException("Image file is too large", 400);
            } else if ($_FILES['cover_file']['error'] != 0) {
                throw new HTTPException("Image file upload error", 400);
            }
            
            $full_image_path = "";
            $image_target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/images/";
            if (!is_dir($image_target_dir)) {
                mkdir($image_target_dir,755, true);
            }
            
            $image_file_extension_allowed = ['jpg','jpeg','png'];
            $image_file_name = $_FILES['cover_file']['name'];
            $image_file_size = $_FILES['cover_file']['size'];
            $image_file_tmpname  = $_FILES['cover_file']['tmp_name'];
            $image_file_namefrag = explode('.',$image_file_name);
            $image_file_ext = strtolower(end($image_file_namefrag));
            $image_target_file = floor(microtime(true)).".".$image_file_ext;
            
            if (!in_array($image_file_ext,$image_file_extension_allowed)) {
                throw new HTTPException("Image file extension not allowed", 400);
            }
            
            $image_did_upload = move_uploaded_file($image_file_tmpname, $image_target_dir.$image_target_file);
            $full_image_path = "";
            if ($image_did_upload) {
                // image_path in database
                $full_image_path = $image_target_file;
            } else {
                throw new HTTPException("Image file save error", 400);
            }
        
            $album_service = new AlbumService();
            $result = $album_service->create($judul, $penyanyi, $full_image_path, $tanggal_terbit, $genre);
            $res = new Response($result, 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }        
    }

    public function updateAlbum() {
        $_PUT = json_decode(file_get_contents('php://input'), true);
        $judul = isset($_PUT['judul']) ? $_PUT['judul'] : '';
        $penyanyi = isset($_PUT['penyanyi']) ? $_PUT['penyanyi'] : '' ;
        $genre = isset($_PUT['genre']) ? $_PUT['genre'] : '';
        $tanggal_terbit = isset($_PUT['tanggal_terbit']) ? $_PUT['tanggal_terbit'] : '';
        $total_duration = isset($_POST['total_duration']) ? $_POST['total_duration'] : '';
        $album_id = isset($_PUT['album_id']) ? $_PUT['album_id'] : '';
        
        if (!$album_id || !$judul || !$penyanyi || !$genre || !$tanggal_terbit || !$total_duration){
            throw new HTTPException('Empty fields', 400);
        }
        
        // Image File
        $image_errors = [];
        $image_file_error = false;
        if (!isset($_FILES['image_file']['error']) || is_array($_FILES['image_file']['error'])) {
            $image_errors[] = 'Invalid parameters.';
            $image_file_error = true;
        } else if ($_FILES['image_file']['size'] > 10000000) { //10MB
            $image_errors[] = 'Image file is too large.';
            $image_file_error = true;
        } else if ($_FILES['image_file']['error'] != 0) {
            $image_errors[] = 'Image file upload error.';
            $image_file_error = true;
        }
        
        $full_image_path = "";
        $image_target_dir = dirname(ROOT, 2)."uploads/images/";
        if (!is_dir($image_target_dir)) {
            mkdir($image_target_dir,0777, true);
        }
        
        $image_file_extension_allowed = ['mp3','wav','ogg'];
        $image_file_name = $_FILES['image_file']['name'];
        $image_file_size = $_FILES['image_file']['size'];
        $image_file_tmpname  = $_FILES['image_file']['tmp_name'];
        $image_file_namefrag = explode('.',$image_file_name);
        $image_file_ext = strtolower(end($image_file_namefrag));
        $image_target_file = floor(microtime(true)).".".$image_file_ext;
        
        if (!in_array($image_file_ext,$image_file_extension_allowed)) {
            $image_errors[] = "This file extension is not allowed. Please upload a MP3 or WAV or OGG file";
            $image_file_error = true;
        }
        
        if ($image_file_error) {
            throw new HTTPException("Image file error", 400);
        }
        
        
        try {
            $album_service = new AlbumService();
            $result = $album_service->update($album_id, $judul, $penyanyi, $total_duration, $full_image_path, $tanggal_terbit, $genre);
        
            $res = new Response($result, 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }                
    }

    public function getAllAlbum() {
        try {
            $album_service = new AlbumService();
            $result = $album_service->readAll();
        
            if ($data) {
                $res = new Response('Success', 200, $result);
                $res->sendJSON();
            } else {
                throw new HTTPException('Album no found', 404);
            }
        
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }
}

?>
<?php 
namespace App\Controller;
use App\Service\AlbumService;
use App\Service\SongService;
use App\Utils\{HTTPException, Response};

final class SongController {
    public function viewDetailSong(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/detailsong.php";
    }

    public function viewAddSong() {
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/addsong.php";
    }

    public function detailSong() {
        try {
            $song_service = new SongService();
            $query = $_GET["id"];
            $result = $song_service->getSongById($query);
        
            if ($data) {
                $res = new Response('Success', 200, $result);
                $res->sendJSON();
            } else {
                throw new HTTPException('Song not found', 404);
            }
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function deleteSong(){
        $_DELETE = json_decode(file_get_contents('php://input'), true);
        $song_id = isset($_DELETE['song_id']) ? $_DELETE['song_id'] : '';
        
        if (!$song_id){
            throw new HTTPException('Empty fields', 400);
        }

        try {
            $song_service = new SongService();
            $result = $song_service->delete($song_id);

            $res = new Response($result, 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function deleteSongFromAlbum() {
        $_PATCH = json_decode(file_get_contents('php://input'), true);
        $song_id = isset($_PATCH['song_id']) ? $_PATCH['song_id'] : '';

        if (!$song_id){
            throw new HTTPException('Empty fields', 400);
        }

        try {
            $song_service = new SongService();
            $result = $song_service->deleteSongFromAlbum($song_id);

            $res = new Response($result, 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function updateSongToAlbum() {
        $_PATCH = json_decode(file_get_contents('php://input'), true);
        $song_id = isset($_PATCH['song_id']) ? $_PATCH['song_id'] : '';
        $album_id = isset($_PATCH['album_id']) ? $_PATCH['album_id'] : '';

        if (!$song_id || !$album_id){
            throw new HTTPException('Empty fields', 400);
        }

        try {
            $song_service = new SongService();
            $album_service = new AlbumService();
            
            $penyanyi = $song_service->getSongById($song_id)['penyanyi'];
            $penyanyi_compare = $album_service->getAlbumById($album_id)['penyanyi'];

            $total_duration =  $song_service->getSongById($song_id)['duration'] + $album_service->getAlbumById($album_id)['total_duration'];
            if ($penyanyi != $penyanyi_compare){
                throw new HTTPException('Penyanyi song and album not match', 400);
            }
            $result = $song_service->updateSongToAlbum($song_id, $album_id, $total_duration);

            $res = new Response($result, 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function addSong() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $judul = isset($_POST['judul']) ? $_POST['judul'] : '';
        $penyanyi = isset($_POST['penyanyi']) ? $_POST['penyanyi'] : '' ;
        $tanggal_terbit = isset($_POST['tanggal_terbit']) ? $_POST['tanggal_terbit'] : '';
        $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
        $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
        $album_id = isset($_POST['album_id']) ? $_POST['album_id'] : '';
        
        if (!$judul || !$penyanyi || !$tanggal_terbit || !$genre || !$duration){
            throw new HTTPException('Empty fields', 400);
        }
        
        // --- Audio File Upload ---
        $audio_errors = [];
        $audio_file_error = false;
        if (!isset($_FILES['audio_file']['error']) || is_array($_FILES['audio_file']['error'])) {
            $audio_errors[] = 'Invalid parameters.';
            $audio_file_error = true;
        } else if ($_FILES['audio_file']['size'] > 10000000) { //10MB
            $audio_errors[] = 'Audio file is too large.';
            $audio_file_error = true;
        } else if ($_FILES['audio_file']['error'] != 0) {
            $audio_errors[] = 'Audio file upload error.';
            $audio_file_error = true;
        }
        
        $full_audio_path = "";
        $audio_target_dir = dirname(ROOT, 2)."uploads/audios/";
        if (!is_dir($audio_target_dir)) {
            mkdir($audio_target_dir,0777, true);
        }
        
        $audio_file_extension_allowed = ['mp3','wav','ogg'];
        $audio_file_name = $_FILES['audio_file']['name'];
        $audio_file_size = $_FILES['audio_file']['size'];
        $audio_file_tmpname  = $_FILES['audio_file']['tmp_name'];
        $audio_file_namefrag = explode('.',$audio_file_name);
        $audio_file_ext = strtolower(end($audio_file_namefrag));
        $audio_target_file = floor(microtime(true)).".".$audio_file_ext;
        
        if (!in_array($audio_file_ext,$audio_file_extension_allowed)) {
            $audio_errors[] = "This file extension is not allowed. Please upload a MP3 or WAV or OGG file";
            $audio_file_error = true;
        }
        
        if ($audio_file_error) {
            throw new HTTPException('Image file error', 400);
        }
        
        $audio_did_upload = move_uploaded_file($audio_file_tmpname, $audio_target_dir.$audio_target_file);
        if ($audio_did_upload) {
            // audio_path in database
            $full_audio_path = URL."/uploads/audios/".$audio_target_file."\n";
        } else {
            throw new HTTPException('Audio file upload error', 400);
        }
        // --- End Audio File Upload ---
        
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
        
        $image_file_extension_allowed = ['jpg','jpeg','png'];
        $image_file_name = $_FILES['image_file']['name'];
        $image_file_size = $_FILES['image_file']['size'];
        $image_file_tmpname  = $_FILES['image_file']['tmp_name'];
        $image_file_namefrag = explode('.',$image_file_name);
        $image_file_ext = strtolower(end($image_file_namefrag));
        $image_target_file = floor(microtime(true)).".".$image_file_ext;
        
        if (!in_array($image_file_ext,$image_file_extension_allowed)) {
            $image_errors[] = "This file extension is not allowed. Please upload a JPG, JPEG, or PNG file";
            $image_file_error = true;
        }
        
        if ($image_file_error) {
            throw new HTTPException("Image file error", 400);
        }
        
        $image_did_upload = move_uploaded_file($image_file_tmpname, $image_target_dir.$image_target_file);
        if ($image_did_upload) {
            // image_path in database
            $full_image_path = URL."/uploads/images/".$image_target_file."\n";
        } else {
            throw new HTTPException('Image file upload error', 400);
        }
        
        try {
            $song_service = new SongService();
            $album_service = new AlbumService();
            $result = null;
            $result = $song_service->create($judul, $penyanyi, $tanggal_terbit, $genre, $duration, $full_audio_path, $full_image_path);
            if ($album_id != "") {
                $penyanyi_compare = $album_service->getAlbumById($album_id)['penyanyi'];
                if ($penyanyi != $penyanyi_compare){
                    throw new HTTPException('Penyanyi song and album is not match', 400);
                }
                $total_duration = $duration + $album_service->getAlbumById($album_id)['total_duration'];
                $result = $song_service->updateSongToAlbum($song_id, $album_id, $total_duration);
            }
            
            $res = new Response($result, 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }        
    }

    public function updateSong() {
        $_PUT = json_decode(file_get_contents('php://input'), true);
        $judul = isset($_PUT['judul']) ? $_PUT['judul'] : '';
        $penyanyi = isset($_PUT['penyanyi']) ? $_PUT['penyanyi'] : '' ;
        $tanggal_terbit = isset($_PUT['tanggal_terbit']) ? $_PUT['tanggal_terbit'] : '';
        $genre = isset($_PUT['genre']) ? $_PUT['genre'] : '';
        $duration = isset($_PUT['duration']) ? $_PUT['duration'] : '';
        $song_id = isset($_PUT['song_id']) ? $_PUT['song_id'] : '';

        if (!$song_id || !$judul || !$penyanyi || !$tanggal_terbit || !$genre || !$duration){
            throw new HTTPException('Empty fields', 400);
        }
        // --- Audio File Upload ---
        $audio_errors = [];
        $audio_file_error = false;
        if (!isset($_FILES['audio_file']['error']) || is_array($_FILES['audio_file']['error'])) {
            $audio_errors[] = 'Invalid parameters.';
            $audio_file_error = true;
        } else if ($_FILES['audio_file']['size'] > 10000000) { //10MB
            $audio_errors[] = 'Audio file is too large.';
            $audio_file_error = true;
        } else if ($_FILES['audio_file']['error'] != 0) {
            $audio_errors[] = 'Audio file upload error.';
            $audio_file_error = true;
        }

        $full_audio_path = "";
        $audio_target_dir = dirname(ROOT, 2)."uploads/audios/";
        if (!is_dir($audio_target_dir)) {
            mkdir($audio_target_dir,0777, true);
        }

        $audio_file_extension_allowed = ['mp3','wav','ogg'];
        $audio_file_name = $_FILES['audio_file']['name'];
        $audio_file_size = $_FILES['audio_file']['size'];
        $audio_file_tmpname  = $_FILES['audio_file']['tmp_name'];
        $audio_file_namefrag = explode('.',$audio_file_name);
        $audio_file_ext = strtolower(end($audio_file_namefrag));
        $audio_target_file = floor(microtime(true)).".".$audio_file_ext;

        if (!in_array($audio_file_ext,$audio_file_extension_allowed)) {
            $audio_errors[] = "This file extension is not allowed. Please upload a MP3 or WAV or OGG file";
            $audio_file_error = true;
        }

        if ($audio_file_error) {
            throw new HTTPException('Audio file error', 400);
        }

        $audio_did_upload = move_uploaded_file($audio_file_tmpname, $audio_target_dir.$audio_target_file);
        if ($audio_did_upload) {
            // audio_path in database
            $full_audio_path = URL."/uploads/audios/".$audio_target_file."\n";
        } else {
            throw new HTTPException('Audio file upload error', 400);
        }
        // --- End Audio File Upload ---

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

        $image_file_extension_allowed = ['jpg','jpeg','png'];
        $image_file_name = $_FILES['image_file']['name'];
        $image_file_size = $_FILES['image_file']['size'];
        $image_file_tmpname  = $_FILES['image_file']['tmp_name'];
        $image_file_namefrag = explode('.',$image_file_name);
        $image_file_ext = strtolower(end($image_file_namefrag));
        $image_target_file = floor(microtime(true)).".".$image_file_ext;

        if (!in_array($image_file_ext,$image_file_extension_allowed)) {
            $image_errors[] = "This file extension is not allowed. Please upload a JPG, JPEG, or PNG file";
            $image_file_error = true;
        }

        if ($image_file_error) {
            throw new HTTPException('Image file error', 400);
        }

        $image_did_upload = move_uploaded_file($image_file_tmpname, $image_target_dir.$image_target_file);
        if ($image_did_upload) {
            // image_path in database
            $full_image_path = URL."/uploads/images/".$image_target_file."\n";
        } else {
            throw new HTTPException('Image file upload error', 400);

        }

        try {
            $song_service = new SongService();
            $result = $song_service->update($song_id, $judul, $penyanyi, $tanggal_terbit, $genre, $duration, $full_audio_path, $full_image_path);

            $res = new Response($result, 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function getSong() {
        try {
            $songs_service = new SongService();
            $result = $songs_service->getSong();
        
            $res = new Response('Success', 200, $result);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }
}

?>
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
            $query = isset($_GET['id']) ? $_GET['id'] : '';
            if (!$query) {
                throw new HTTPException('Empty fields', 400);
            }

            $result = $song_service->getSongById($query);

            $res = new Response('Success', 200, $result);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function deleteSong(){
        try {
            $song_id = isset($_GET["id"]) ? $_GET["id"] : '';
            
            if (!$song_id){
                throw new HTTPException('Empty fields', 400);
            }
            $song_service = new SongService();
            $album_service = new AlbumService();
            $song = $song_service->getSongById($song_id);
            $album_id = $song['album_id'];
            $album = $album_service->getAlbumById($album_id)['album'];

            $total_duration =  $album['total_duration'] - $song['duration'];
            $result = $song_service->delete($song_id, $album_id, $total_duration);

            unlink($_SERVER['DOCUMENT_ROOT']."/uploads/images/".$song["image_path"]);
            unlink($_SERVER['DOCUMENT_ROOT']."/uploads/audios/".$song["audio_path"]);

            $res = new Response($result, 200);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function deleteSongFromAlbum() {
        try {
            $_PATCH = $GLOBALS['_PATCH'];
            $song_id = isset($_PATCH['song_id']) ? $_PATCH['song_id'] : '';
            $album_id = isset($_PATCH['album_id']) ? $_PATCH['album_id'] : '';

            if (!$song_id){
                throw new HTTPException('Empty fields', 400);
            }

            $song_service = new SongService();
            $album_service = new AlbumService();
            $album = $album_service->getAlbumById($album_id)["album"];
            $song = $song_service->getSongById($song_id);
            $total_duration =  $album['total_duration'] - $song['duration'];
            echo $total_duration;
            $result = $song_service->deleteSongFromAlbum($song_id, $album_id, $total_duration);

            $res = new Response($result, 200);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function updateSongToAlbum() {
        try {
            $_PATCH = $GLOBALS['_PATCH'];
            $song_id = isset($_PATCH['song_id']) ? $_PATCH['song_id'] : '';
            $album_id = isset($_PATCH['album_id']) ? $_PATCH['album_id'] : '';

            if (!$song_id || !$album_id){
                throw new HTTPException(json_encode($_PATCH), 400);
            }

            $song_service = new SongService();
            $album_service = new AlbumService();

            $album = $album_service->getAlbumById($album_id)["album"];
            $song = $song_service->getSongById($song_id);
            
            $penyanyi = $song['penyanyi'];
            $penyanyi_compare = $album['penyanyi'];

            if ($penyanyi != $penyanyi_compare){
                throw new HTTPException('Penyanyi song and album not match', 400);
            }

            $total_duration =  $song['duration'] + $album['total_duration'];
            $result = $song_service->updateSongToAlbum($song_id, $album_id, $total_duration);

            $res = new Response($result, 200);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function addSong() {
        try {
            $judul = isset($_POST['judul']) ? $_POST['judul'] : '';
            $penyanyi = isset($_POST['penyanyi']) ? $_POST['penyanyi'] : '' ;
            $tanggal_terbit = isset($_POST['tanggal_terbit']) ? $_POST['tanggal_terbit'] : '';
            $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
            $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
            $album_id = isset($_POST['album_id']) ? $_POST['album_id'] : '';
            
            if (!$judul || !$penyanyi || !$tanggal_terbit || !$genre || !$duration){
                throw new HTTPException("Empty fields", 400);
            }
            
            // --- Audio File Upload ---
            if (!isset($_FILES['audio_file']['error']) || is_array($_FILES['audio_file']['error'])) {
                throw new HTTPException("Invalid parameters", 400);
            } else if ($_FILES['audio_file']['size'] > 10000000) { //10MB
                throw new HTTPException("Audio file is too large", 400);
            } else if ($_FILES['audio_file']['error'] != 0) {
                throw new HTTPException("Audio file upload error", 400);
            }
            
            $full_audio_path = "";
            $audio_target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/audios/";
            if (!is_dir($audio_target_dir)) {
                mkdir($audio_target_dir,755, true);
            }
            
            $audio_file_extension_allowed = ['mp3','wav','ogg'];
            $audio_file_name = $_FILES['audio_file']['name'];
            $audio_file_size = $_FILES['audio_file']['size'];
            $audio_file_tmpname  = $_FILES['audio_file']['tmp_name'];
            $audio_file_namefrag = explode('.',$audio_file_name);
            $audio_file_ext = strtolower(end($audio_file_namefrag));
            $audio_target_file = floor(microtime(true)).".".$audio_file_ext;
            
            if (!in_array($audio_file_ext,$audio_file_extension_allowed)) {
                throw new HTTPException("Audio file extension not allowed, please upload MP3, WAV, or OGG", 400);
            }
            
            $audio_did_upload = move_uploaded_file($audio_file_tmpname, $audio_target_dir.$audio_target_file);
            if ($audio_did_upload) {
                // audio_path in database
                $full_audio_path = $audio_target_file;
            } else {
                throw new HTTPException("Audio file save error", 400);
            }
            // --- End Audio File Upload ---
            
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
            if ($image_did_upload) {
                // image_path in database
                $full_image_path = $image_target_file;
            } else {
                throw new HTTPException("Image file save error", 400);
            }
        
        
            $song_service = new SongService();
            $album_service = new AlbumService();
            $result = "";
            $song_id = $song_service->create($judul, $penyanyi, $tanggal_terbit, $genre, $duration, $full_audio_path, $full_image_path);
            if ($album_id != "") {
                $penyanyi_compare = $album_service->getAlbumById($album_id)["album"]['penyanyi'];
                if ($penyanyi != $penyanyi_compare){
                    throw new HTTPException("Penyanyi doesn't match", 400);
                }
                $total_duration = $duration + $album_service->getAlbumById($album_id)["album"]['total_duration'];
                $result = $song_service->updateSongToAlbum($song_id, $album_id, $total_duration);
            }
            
            $res = new Response("Song sucessfully added", 201);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }        
    }

    public function updateSong() {
        try {
            $song_service = new SongService();
            $song_id = isset($_POST['id']) ? $_POST['id'] : '';
            if (!$song_id){
                throw new HTTPException(json_encode($_POST), 400);
            }
            $song = $song_service->getSongById($song_id);

            $judul = !empty($_POST['judul']) ? $_POST['judul'] : $song['judul'];
            $tanggal_terbit = !empty($_POST['tanggal_terbit']) ? $_POST['tanggal_terbit'] : $song['tanggal_terbit'];
            $genre = !empty($_POST['genre']) ? $_POST['genre'] : $song['genre'];
            $duration = !empty($_POST['duration']) ? $_POST['duration'] : $song['duration'];

            // --- Audio File Upload ---
            $full_audio_path = $song['audio_path'];
            if (isset($_FILES["audio_file"])) {
                if (!isset($_FILES['audio_file']['error']) || is_array($_FILES['audio_file']['error'])) {
                    throw new HTTPException("Invalid parameters", 400);
                } else if ($_FILES['audio_file']['size'] > 10000000) { //10MB
                    throw new HTTPException("Audio file is too large", 400);
                } else if ($_FILES['audio_file']['error'] != 0) {
                    throw new HTTPException("Audio file upload error", 400);
                }
                
                $audio_target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/audios/";
                if (!is_dir($audio_target_dir)) {
                    mkdir($audio_target_dir,755, true);
                }
                
                $audio_file_extension_allowed = ['mp3','wav','ogg'];
                $audio_file_name = $_FILES['audio_file']['name'];
                $audio_file_size = $_FILES['audio_file']['size'];
                $audio_file_tmpname  = $_FILES['audio_file']['tmp_name'];
                $audio_file_namefrag = explode('.',$audio_file_name);
                $audio_file_ext = strtolower(end($audio_file_namefrag));
                $audio_target_file = floor(microtime(true)).".".$audio_file_ext;
                
                if (!in_array($audio_file_ext,$audio_file_extension_allowed)) {
                    throw new HTTPException("Audio file extension not allowed, please upload MP3, WAV, or OGG", 400);
                }
                
                $audio_did_upload = move_uploaded_file($audio_file_tmpname, $audio_target_dir.$audio_target_file);

                if ($audio_did_upload) {
                    // audio_path in database
                    $full_audio_path = $audio_target_file;
                    unlink($_SERVER['DOCUMENT_ROOT']."/uploads/audios/".$song["audio_path"]);
                } else {
                    throw new HTTPException("Audio file save error", 400);
                }
            }
            
            // Image File
            $full_image_path = $song["image_path"];
            if(isset($_FILES["cover_file"])){
                if (!isset($_FILES['cover_file']['error']) || is_array($_FILES['cover_file']['error'])) {
                    throw new HTTPException("Invalid parameters", 400);
                } else if ($_FILES['cover_file']['size'] > 10000000) { //10MB
                    throw new HTTPException("Image file is too large", 400);
                } else if ($_FILES['cover_file']['error'] != 0) {
                    throw new HTTPException("Image file upload error", 400);
                }
                
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
                if ($image_did_upload) {
                    // image_path in database
                    $full_image_path = $image_target_file;
                    unlink($_SERVER['DOCUMENT_ROOT']."/uploads/images/".$song["image_path"]);
                } else {
                    throw new HTTPException("Image file save error", 400);
                }
            }
            $audio_path = $full_audio_path;
            $image_path = $full_image_path;
            $result = $song_service->update($song_id, $judul, $tanggal_terbit, $genre, $duration, $audio_path, $image_path);

            $res = new Response($result, 200);
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
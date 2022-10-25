<?php 
namespace App\Controller;
use App\Service\AlbumService;
use App\Service\SongService;

final class SongController {
    public function viewDetailSong(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/detailsong.php";
    }

    public function detailSong() {
        try {
            $song_service = new SongService();
            $query = $_GET["id"];
            $result = $song_service->getSongById($query);
            $data = $result["Data"];
        
            if ($data) {
                http_response_code(200);
                $return = array(
                    'status' => 200,
                    'data' => $data,
                );
                print_r(json_encode($return));
            } else {
                http_response_code(404);
                $return = array(
                    'status' => 404,
                    'error' => 'Song not found'
                );
                print_r(json_encode($return));
            }
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
        
            http_response_code($error_code);
            $return = array(
                'status' => $error_code,
                'error' => $e->getMessage()
            );
            print_r(json_encode($return));
        }
    }

    public function deleteSong(){
        $_DELETE = json_decode(file_get_contents('php://input'), true);
        $song_id = isset($_DELETE['song_id']) ? $_DELETE['song_id'] : '';
        
        if (!$song_id){
            http_response_code(400);
            $return = array(
                'status' => 400,
                'error' => 'Bad request, empty song_id'
            );
            print_r(json_encode($return));
            exit;
        }

        try {
            $song_service = new SongService();
            $result = $song_service->delete($song_id);

            http_response_code(200);
            $return = array(
                'status' => 200,
                'message' => $result
            );
            print_r(json_encode($return));
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;

            http_response_code($error_code);
            $return = array(
                'status' => $error_code,
                'error' => $e->getMessage()
            );
            print_r(json_encode($return));
        }
    }

    public function deleteSongFromAlbum() {
        $_PATCH = json_decode(file_get_contents('php://input'), true);
        $song_id = isset($_PATCH['song_id']) ? $_PATCH['song_id'] : '';

        if (!$song_id){
            http_response_code(400);
            $return = array(
                'status' => 400,
                'error' => 'Bad request'
            );
            print_r(json_encode($return));
            exit;
        }

        try {
            $song_service = new SongService();
            $result = $song_service->deleteSongFromAlbum($song_id);

            http_response_code(201);
            $return = array(
                'status' => 201,
                'message' => $result
            );
            print_r(json_encode($return));
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;

            http_response_code($error_code);
            $return = array(
                'status' => $error_code,
                'error' => $e->getMessage()
            );
            print_r(json_encode($return));
        }
    }

    public function updateSongToAlbum() {
        $_PATCH = json_decode(file_get_contents('php://input'), true);
        $song_id = isset($_PATCH['song_id']) ? $_PATCH['song_id'] : '';
        $album_id = isset($_PATCH['album_id']) ? $_PATCH['album_id'] : '';

        if (!$song_id || !$album_id){
            http_response_code(400);
            $return = array(
                'status' => 400,
                'error' => 'Bad request'
            );
            print_r(json_encode($return));
            exit;
        }

        try {
            $song_service = new SongService();
            $album_service = new AlbumService();
            
            $penyanyi = $song_service->getSongById($song_id)['penyanyi'];
            $penyanyi_compare = $album_service->getAlbumById($album_id)['penyanyi'];

            $total_duration =  $song_service->getSongById($song_id)['duration'] + $album_service->getAlbumById($album_id)['total_duration'];
            if ($penyanyi != $penyanyi_compare){
                http_response_code(400);
                $return = array(
                    'status' => 400,
                    'error' => 'Bad request, Penyanyi song and album is not match'
                );
                print_r(json_encode($return));
                exit;
            }
            $result = $song_service->updateSongToAlbum($song_id, $album_id, $total_duration);

            http_response_code(201);
            $return = array(
                'status' => 201,
                'message' => $result
            );
            print_r(json_encode($return));
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;

            http_response_code($error_code);
            $return = array(
                'status' => $error_code,
                'error' => $e->getMessage()
            );
            print_r(json_encode($return));
        }
    }


}

?>
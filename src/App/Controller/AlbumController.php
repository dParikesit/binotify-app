<?php 
namespace App\Controller;
use App\Service\AlbumService;
use App\Service\SongService;

final class AlbumController {
    public function viewDetailAlbum(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/detailalbum.php";
    }

    public function detailAlbum() {
        try {
            $album_service = new AlbumService();
            $query = $_GET["id"];
            $result = $album_service->getAlbumById($query);
            $data = $result["Data"];
            $songs = $result["Songs"];
        
            if ($data) {
                http_response_code(200);
                $return = array(
                    'status' => 200,
                    'data' => $data,
                    'songs' => $songs
                );
                print_r(json_encode($return));
            } else {
                http_response_code(404);
                $return = array(
                    'status' => 404,
                    'error' => 'Album not found'
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

    public function deleteAlbum(){
        $_DELETE = json_decode(file_get_contents('php://input'), true);
        $album_id = isset($_DELETE['album_id']) ? $_DELETE['album_id'] : '';

        if (!$album_id){
            http_response_code(400);
            $return = array(
                'status' => 400,
                'error' => 'Bad request, album id empty'
            );
            print_r(json_encode($return));
            exit;
        }


        try {
            $album_service = new AlbumService();
            $result = $album_service->delete($album_id);

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
}

?>
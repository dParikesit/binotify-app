<?php 
namespace App\Controller;
require_once "../../inc/config.php";

use App\Service\SongService;


if ($_SERVER["REQUEST_METHOD"] != 'PUT'){
    http_response_code(422);
    $return = array(
        'status' => 422,
        'error' => 'Method not supported'
    );
    print_r(json_encode($return));
    exit;
}

$_PUT = json_decode(file_get_contents('php://input'), true);
$song_id = isset($_PUT['song_id']) ? $_PUT['song_id'] : '';
$album_id = isset($_PUT['album_id']) ? $_PUT['album_id'] : '';


if (!$song_id || !$album_id){
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => 'Bad request, one of field is empty'
    );
    print_r(json_encode($return));
    exit;
}


try {
    $song_service = new SongService();
    $result = $song_service->updateSongToAlbum($song_id, $album_id);

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

?>
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
$judul = isset($_PUT['judul']) ? $_PUT['judul'] : '';
$penyanyi = isset($_PUT['penyanyi']) ? $_PUT['penyanyi'] : '' ;
$tanggal_terbit = isset($_PUT['tanggal_terbit']) ? $_PUT['tanggal_terbit'] : '';
$genre = isset($_PUT['genre']) ? $_PUT['genre'] : '';
$duration = isset($_PUT['duration']) ? $_PUT['duration'] : '';
$audio_path = isset($_PUT['audio_path']) ? $_PUT['audio_path'] : ''; //TODO
$image_path = isset($_PUT['image_path']) ? $_PUT['image_path'] : ''; //TODO
$song_id = isset($_PUT['song_id']) ? $_PUT['song_id'] : '';


if (!$song_id || !$judul || !$penyanyi || !$tanggal_terbit || !$genre || !$duration || !$audio_path || !$image_path){
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
    $result = $song_service->update($song_id, $judul, $penyanyi, $tanggal_terbit, $genre, $duration, $audio_path, $image_path);

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
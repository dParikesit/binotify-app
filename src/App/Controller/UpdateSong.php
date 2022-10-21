<?php 
namespace App\Controller;
require_once "../../inc/config.php";

use App\Service\SongService;


if ($_SERVER["REQUEST_METHOD"] != 'POST'){
    http_response_code(422);
    $return = array(
        'status' => 422,
        'error' => 'Method not supported'
    );
    print_r(json_encode($return));
    exit;
}

$_POST = json_decode(file_get_contents('php://input'), true);
$judul = isset($_POST['judul']) ? $_POST['judul'] : '';
$penyanyi = isset($_POST['penyanyi']) ? $_POST['penyanyi'] : '' ;
$tanggal_terbit = isset($_POST['tanggal_terbit']) ? $_POST['tanggal_terbit'] : '';
$genre = isset($_POST['genre']) ? $_POST['genre'] : '';
$duration = isset($_POST['duration']) ? $_POST['duration'] : '';
$audio_path = isset($_POST['audio_path']) ? $_POST['audio_path'] : '';
$image_path = isset($_POST['image_path']) ? $_POST['image_path'] : '';


if (!$judul || !$penyanyi || !$tanggal_terbit || !$genre || !$duration || !$audio_path || !$image_path){
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
    $result = $song_service->create($judul, $penyanyi, $tanggal_terbit, $genre, $duration, $audio_path, $image_path);

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
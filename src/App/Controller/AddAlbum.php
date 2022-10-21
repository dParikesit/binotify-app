<?php 
namespace App\Controller;
require_once "../../inc/config.php";

use App\Service\AlbumService;


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
$total_duration = isset($_POST['total_duration']) ? $_POST['total_duration'] : '';
$genre = isset($_POST['genre']) ? $_POST['genre'] : '';
$audio_path = isset($_POST['audio_path']) ? $_POST['audio_path'] : '';
$image_path = isset($_POST['image_path']) ? $_POST['image_path'] : '';


if (!$judul || !$penyanyi || !$total_duration || !$genre || !$audio_path || !$image_path){
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => 'Bad request, one of field is empty'
    );
    print_r(json_encode($return));
    exit;
}


try {
    $album_service = new AlbumService();
    $result = $album_service->create($judul, $penyanyi, $total_duration, $image_path, $tanggal_terbit, $genre);

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
<?php 
namespace App\Controller;
require_once "../../inc/config.php";

use App\Service\AlbumService;


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
$genre = isset($_PUT['genre']) ? $_PUT['genre'] : '';
$tanggal_terbit = isset($_PUT['tanggal_terbit']) ? $_PUT['tanggal_terbit'] : '';
$image_path = isset($_PUT['image_path']) ? $_PUT['image_path'] : '';
$album_id = isset($_PUT['album_id']) ? $_PUT['album_id'] : '';

if (!$album_id || !$judul || !$penyanyi || !$genre || !$image_path || !$tanggal_terbit){
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
    $result = $album_service->update($album_id, $judul, $penyanyi, $image_path, $tanggal_terbit, $genre);

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
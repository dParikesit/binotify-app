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
$album_id = isset($_PUT['album_id']) ? $_PUT['album_id'] : '';

if (!$album_id || !$judul || !$penyanyi || !$genre || !$tanggal_terbit){
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => 'Bad request, one of field is empty'
    );
    print_r(json_encode($return));
    exit;
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
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => $image_errors
    );
    print_r(json_encode($return));
    exit;
}


try {
    $album_service = new AlbumService();
    $result = $album_service->update($album_id, $judul, $penyanyi, $full_image_path, $tanggal_terbit, $genre);

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
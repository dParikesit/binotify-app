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
$_FILES = 
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

// Audio File
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
$target_dir = dirname(ROOT, 2)."uploads/audios/";
if (!is_dir($target_dir)) {
    mkdir($target_dir,0777, true);
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
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => $audio_errors
    );
    print_r(json_encode($return));
    exit;
}

$audio_did_upload = move_uploaded_file($audio_file_tmpname, $target_dir.$audio_target_file);
if ($audio_did_upload) {
    // audio_path in database
    $full_audio_path = URL."/uploads/audios/".$audio_target_file."\n";
}


// Image File
if (!isset($_FILES['image_file']['error']) || is_array($_FILES['image_file']['error'])) {
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => 'Invalid audio file parameters.'
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
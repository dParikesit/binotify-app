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
$judul = isset($_POST['judul']) && $_POST['judul'] != '' ? $_POST['judul'] : '';
$penyanyi = isset($_POST['penyanyi']) && $_POST['penyanyi'] != '' ? $_POST['penyanyi'] : '';
$tahun = isset($_POST['tahun']) && $_POST['tahun'] != '' ? $_POST['tahun'] : '';
$genre = isset($_POST['genre']) && $_POST['genre'] != '' ? $_POST['genre'] : '';
$ordering = isset($_POST['ordering']) ? $_POST['ordering'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : '';
$maxdata = isset($_POST['maxdata']) ? $_POST['maxdata'] : '';
/* 
if (!$username || !$password || !$email){
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => 'Bad request, one of field is empty'
    );
    print_r(json_encode($return));
    exit;
} */


try {
    $songs_service = new SongService();
    $result = $songs_service->getSongByParam($judul, $penyanyi, $tahun, $genre, $ordering, $page, $maxdata);

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
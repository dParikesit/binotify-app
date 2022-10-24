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
$param = isset($_POST['param']) && $_POST['param'] != '' ? $_POST['param'] : '';
$tahun = isset($_POST['tahun']) && $_POST['tahun'] != '' ? $_POST['tahun'] : '0';
$ordering = isset($_POST['ordering']) ? $_POST['ordering'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : 0;
$maxdata = isset($_POST['maxdata']) ? $_POST['maxdata'] : '';

try {
    $songs_service = new SongService();
    $result = $songs_service->getSongByParam($param, $tahun, $ordering, $page, $maxdata);

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
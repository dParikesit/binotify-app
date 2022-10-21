<?php 
namespace App\Controller;
require_once "../../inc/config.php";

use App\Service\AlbumService;


if ($_SERVER["REQUEST_METHOD"] != 'DELETE'){
    http_response_code(422);
    $return = array(
        'status' => 422,
        'error' => 'Method not supported'
    );
    print_r(json_encode($return));
    exit;
}

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

?>
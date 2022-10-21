<?php 
namespace App\Controller;
require_once "../../inc/config.php";

use App\Service\AlbumService;

if ($_SERVER["REQUEST_METHOD"] != 'GET'){
    http_response_code(422);
    $return = array(
        'status' => 422,
        'error' => 'Method not supported'
    );
    print_r(json_encode($return));
    exit;
}

try {
    $album_service = new AlbumService();
    $result = $album_service->readAll();
    $data = $result["Data"];

    if ($data) {
        http_response_code(200);
        $return = array(
            'status' => 200,
            'data' => $data,
        );
        print_r(json_encode($return));
    } else {
        http_response_code(404);
        $return = array(
            'status' => 404,
            'error' => 'Album not found'
        );
        print_r(json_encode($return));
    }

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
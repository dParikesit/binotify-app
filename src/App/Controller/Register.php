<?php 
namespace App\Controller;
if (!defined('BASEPATH')){
  require_once "../../inc/config.php";
}

use App\Service\UsersService;

if ($_SERVER["REQUEST_METHOD"] != 'POST'){
    http_response_code(422);
    $return = array(
        'status' => 422,
        'error' => 'Method not supported'
    );
    print_r(json_encode($return));
    exit;
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '' ;
$username = isset($_POST['username']) ? $_POST['username'] : '';

if (!$username || !$password || !$email){
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => 'Bad request, one of field is empty'
    );
    print_r(json_encode($return));
    exit;
}


$users_service = new UsersService();
try {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $result = $users_service->create($email, $hashed_pass, $username);

    http_response_code($result['Status code']);
    print_r(json_encode($result));
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
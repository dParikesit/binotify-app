<?php

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
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '' ;

if (!$username || !$password){
    http_response_code(400);
    $return = array(
        'status' => 400,
        'error' => 'Bad request, one of field is empty'
    );
    print_r(json_encode($return));
    exit;
}

try {
    $users_service = new UsersService();
    $user = $users_service->findUserByUsername($username);
    $correct = password_verify($password, $user['password']);

    if ($correct==true) {
        $_SESSION['user_id'] = $user["user_id"];
        $_SESSION['isAdmin'] = $user["isAdmin"];

        http_response_code(200);
        header('location:/home-user');
    } else {
        http_response_code(401);
        $return = array(
            'status' => 401,
            'error' => 'Incorrect username or password'
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
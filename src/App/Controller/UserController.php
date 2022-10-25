<?php 
namespace App\Controller;
use App\Service\UserService;

final class UserController {
    public function viewLogin(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/login.php";
    }

    public function viewRegister(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/register.php";
    }

    public function viewListUser(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/users.php";
    }

    public function register(){
        $_POST = json_decode(file_get_contents('php://input'), true);
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


        try {
            $users_service = new UserService();
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $result = $users_service->create($email, $hashed_pass, $username);

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
    }

    public function login(){
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
            $users_service = new UserService();
            $user = $users_service->findUserByUsername($username);
            $correct = password_verify($password, $user['password']);

            if ($correct==true) {
                $_SESSION['user_id'] = $user["user_id"];
                $_SESSION['username'] = $user["username"];
                $_SESSION['isAdmin'] = $user["isadmin"];

                http_response_code(200);
                $return = array(
                    'status' => 200,
                    'message' => $result
                );
                print_r(json_encode($return));
            } else {
                http_response_code(401);
                $return = array(
                    'status' => 401,
                    'error' => json_encode($user)
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
    }
}

?>
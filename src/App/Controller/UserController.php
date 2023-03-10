<?php 
namespace App\Controller;
use App\Service\UserService;
use App\Utils\{HTTPException, Response};

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
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '' ;
        $username = isset($_POST['username']) ? $_POST['username'] : '';

        try {
            if (!$name || !$username || !$password || !$email){
                throw new HTTPException('Empty fields', 400);
            }

            $users_service = new UserService();
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $result = $users_service->create($name, $email, $hashed_pass, $username);

            $res = new Response($result, 201);
            $res->sendJSON();

        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function login(){
        $_POST = json_decode(file_get_contents('php://input'), true);
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '' ;

        try {
            if (!$username || !$password){
                throw new HTTPException('Empty fields', 400);
            }

            $users_service = new UserService();
            $user = $users_service->findUserByUsername($username);
            $correct = password_verify($password, $user['password']);

            if ($correct==true) {
                $_SESSION['user_id'] = $user["user_id"];
                $_SESSION['username'] = $user["username"];
                $_SESSION['isAdmin'] = $user["isadmin"];

                $res = new Response($result, 200);
                $res->sendJSON();
            } else {
                throw new HTTPException('Invalid password', 401);
            }

        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function logout(){
        session_destroy();
        header("Location: /login");
    }

    public function checkUsername(){
        // $_GET = json_decode(file_get_contents('php://input'), true);

        try {
            $username = isset($_GET['username']) ? $_GET['username'] : '';

            if (!$username){
                throw new HTTPException('Empty fields', 400);
            }

            $users_service = new UserService();
            $user = $users_service->findUserByUsername($username);

            $res = new Response("Username is already taken", 200);
            $res->sendJSON();

        } catch (HTTPException $e) {
            $e->sendJSON();
        }
        
    }

    public function checkEmail(){
        // $_GET = json_decode(file_get_contents('php://input'), true);

        try {
            $email = isset($_GET['email']) ? $_GET['email'] : '';

            if (!$email){
                throw new HTTPException('Empty fields', 400);
            }

            $users_service = new UserService();
            $user = $users_service->findUserByEmail($email);

            $res = new Response("Email is already taken", 200);
            $res->sendJSON();

        } catch (HTTPException $e) {
            $e->sendJSON();
        }
        
    }
}

?>
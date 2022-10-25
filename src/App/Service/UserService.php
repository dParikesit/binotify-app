<?php
namespace App\Service;
use \PDO;
use App\Utils\HTTPException;

class UserService extends Service{
    public function __construct() {
        parent::__construct();
    }

    public function create(string $email, string $hashed_pass, string $username) {
        try {
            $sql = "INSERT INTO users (email, password, username) VALUES (:email, :password, :username)";

            $statement = $this->db->prepare($sql);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':password', $hashed_pass, PDO::PARAM_STR);
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->execute();

            return "Successfully Created";
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function findUserByUsername(string $username) {
        try {
            $sql = "SELECT * FROM users WHERE username=:username";

            $statement = $this->db->prepare($sql);
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->execute();

            if($statement->rowCount() == 0) {
                throw new HTTPException('User not found', 404);
            }

            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function readAll() {
        try {
            $sql = "SELECT * FROM users";
            $statement = $this->db->prepare($sql);
            $statement->execute();

            return $statement->fetchAll();
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }
}

?>
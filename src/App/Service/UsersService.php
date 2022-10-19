<?php
namespace App\Service;
use \PDO;

class UsersService extends Service{
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

            return array("Status code" => 201,"Message"=>"Successfully Created");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }
}

?>
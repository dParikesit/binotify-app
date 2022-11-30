<?php
namespace App\Service;
use \PDO;
use App\Utils\{HTTPException, Response};

class PremiumService extends Service{
    public function __construct() {
        parent::__construct();
    }

    public function getSubscribedByUserId($user_id) {
        try {
            $sql = "SELECT creator_id FROM subs WHERE subscriber_id = :user_id";
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            return $result;
        } catch (PDOException $e) {
            $res = new HTTPException($e->getMessage(), 400);
            $e->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }
}

?>
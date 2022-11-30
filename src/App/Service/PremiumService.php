<?php
namespace App\Service;
use \PDO;
use App\Utils\{HTTPException, Response};

class PremiumService extends Service{
    public function __construct() {
        parent::__construct();
    }

    public function updateStatus(int $creator_id, int $subscriber_id, string $status) {
        try {
            $sql = "UPDATE subs SET status = :status WHERE creator_id = :creator_id AND subscriber_id = :subscriber_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':status', $status, PDO::PARAM_STR);
            $statement->bindParam(':creator_id', $creator_id, PDO::PARAM_INT);
            $statement->bindParam(':subscriber_id', $subscriber_id, PDO::PARAM_INT);
            $statement->execute();

            return "Status updated";
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
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
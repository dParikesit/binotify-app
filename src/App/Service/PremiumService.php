<?php
namespace App\Service;
use \PDO;
use \SoapClient;
use \SoapVar;
use \SoapHeader;
use \SoapFault;
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

    public function getSubscribedByUserId(int $subscriber_id) {
        try {
            $sql = "SELECT creator_id FROM subs WHERE subscriber_id = :subscriber_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':subscriber_id', $subscriber_id, PDO::PARAM_INT);
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

    public function getPremiumSinger() {
        try {
            $opts = array('http' =>
                array(
                    'method'  => 'GET',
                    'header'  => 'Content-Type: application/json'
                )
            );

            $context  = stream_context_create($opts);

            $result = file_get_contents('http://rest:3002/api/listpenyanyi', false, $context);

            $singer = json_decode($result, true);

            return $singer["data"];
        } catch (PDOException $e) {
            $res = new HTTPException($e->getMessage(), 400);
            $e->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function getSubsStatusPHP($subscriber_id){
        try {
            $sql = "SELECT * FROM subs WHERE subscriber_id = :subscriber_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':subscriber_id', $subscriber_id, PDO::PARAM_INT);
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

    public function getSubsStatusSOAP($subscriber_id) {
        try {
            $client = new SoapClient('http://soap/subs?wsdl', array("trace" => 1, "exceptions" => true));

            $headerVar = new SoapVar('<apiKey>N6GnHem1dDdtPjsXPzHxUAnWWtZG1ECLIMHgOlv7ine1skabTYLlP9WDYtr7se3lHHihPVdIZ6rg9yHQTcIabpy7qfl94GEYaopDTACMQrxjLsUmJaMd1VqikRWkJNpb</apiKey><clientType>FRONTEND</clientType>', XSD_ANYXML);

            $header = new SoapHeader('header','header',$headerVar);
            $client->__setSoapHeaders($header);

            $body = array(
                "subscriber_id" => $subscriber_id
            );

            $singer = $client->__soapCall("getSubStatusBatch", array($body));

            $resultStr = json_encode($singer);
            $recordArr = json_decode(json_decode($resultStr, true)["return"], true)["records"];

            $func = function($value) {
                return array(
                    "creator_id" => $value[0],
                    "subscriber_id" => $value[1],
                    "status" => $value[2]
                );
            };
            $result = array_map($func, $recordArr);
            return $result;
        } catch (\Exception $e) {
            return 500;
        }
    }

    public function addSubscribeReq($creator_id, $subscriber_id) {
        try {
            $client = new SoapClient('http://soap/subs?wsdl', array("trace" => 1, "exception" => 0));

            $headerVar = new SoapVar('<apiKey>N6GnHem1dDdtPjsXPzHxUAnWWtZG1ECLIMHgOlv7ine1skabTYLlP9WDYtr7se3lHHihPVdIZ6rg9yHQTcIabpy7qfl94GEYaopDTACMQrxjLsUmJaMd1VqikRWkJNpb</apiKey><clientType>FRONTEND</clientType>', XSD_ANYXML);

            $header = new SoapHeader('header','header',$headerVar);
            $client->__setSoapHeaders($header);

            $body = array(
                "creator_id" => $creator_id,
                "subscriber_id" => $subscriber_id
            );

            $result = $client->__soapCall("subscribe", array($body));

            $sql = "INSERT INTO subs(creator_id, subscriber_id) VALUES (:creator_id, :subscriber_id)";

            $statement = $this->db->prepare($sql);
            $statement->bindParam(':creator_id', $creator_id, PDO::PARAM_INT);
            $statement->bindParam(':subscriber_id',$subscriber_id, PDO::PARAM_INT);
            $statement->execute();
            
            return 200;
        } catch (\Exception $e) {
            return 500;
        }
    }

    public function addSubsSoap(int $creator_id, int $subscriber_id) {
        try {
            $sql = "INSERT INTO subs(creator_id, subscriber_id) VALUES (:creator_id, :subscriber_id)";

            $statement = $this->db->prepare($sql);
            $statement->bindParam(':creator_id', $creator_id, PDO::PARAM_INT);
            $statement->bindParam(':subscriber_id',$subscriber_id, PDO::PARAM_INT);
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

}

?>
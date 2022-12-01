<?php 
namespace App\Controller;
use App\Service\PremiumService;
use App\Utils\{HTTPException, Response};

final class PremiumController {
    public function viewSinger(){
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/listpenyanyi.php";
    }

    public function viewSingerSong() {
        include $_SERVER['DOCUMENT_ROOT'] . "/App/View/listsong.php";
    }

    public function updateStatus() {
        try {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $premium_service = new PremiumService();
            $result = $premium_service->updateStatus($_POST['creator_id'], $_POST['subscriber_id'], $_POST['status']);
        
            $res = new Response('Success', 200, $result);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function getUserListSubscription() {
        try {
            $premium_service = new PremiumService();
            $subscriber_id = $_SESSION['user_id'];
            $result = $premium_service->getSubscribedByUserId($subscriber_id);
        
            $res = new Response('Success', 200, $result);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function getPremiumSinger() {
        try {
            $premium_service = new PremiumService();
            $result = $premium_service->getPremiumSinger();
        
            $res = new Response('Success', 200, $result);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function getSubStatusPHP() {
        try {
            $premium_service = new PremiumService();
            $subscriber_id = $_SESSION['user_id'];
            $result = $premium_service->getSubsStatusPHP($subscriber_id);
        
            $res = new Response('Success', 200, $result);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function getSubStatusSOAP() {
        try {
            $premium_service = new PremiumService();
            $subscriber_id = $_SESSION['user_id'];
            $result = $premium_service->getSubStatusSOAP($subscriber_id);
        
            $res = new Response('Success', 200, $result);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function addSubsReq($creator_id) {
        try {
            $premium_service = new PremiumService();
            $subscriber_id = $_SESSION['user_id'];
            $result = $premium_service->addSubscribeReq($creator_id, $subscriber_id);
        
            $res = new Response('Success', 200, $result);
            $res->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }
}
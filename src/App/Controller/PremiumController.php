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
}
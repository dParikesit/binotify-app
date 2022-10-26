<?php 

namespace App\Utils;

class Response {
    private $message;
    private $code;
    private $data;

    public function __construct($message="", $code = 200, $data=[]) {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    public function sendJSON(){
        http_response_code($this->code);
        $return = array(
            'status' => $this->code,
            'message' => $this->message
        );
        if(!empty($this->data)){
            $return['data'] = $this->data;
        }

        print_r(json_encode($return));
        exit;
    }
}

?>
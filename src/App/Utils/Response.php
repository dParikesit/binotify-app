<?php 

namespace App\Utils;

class Response {
    private $message;
    private $code;

    public function __construct($message="", $code = 200) {
        $this->message = $message;
        $this->code = $code;
    }

    public function sendJSON(){
        http_response_code($this->code);
        $return = array(
            'status' => $this->code,
            'error' => $this->message
        );
        print_r(json_encode($return));
        exit;
    }
}

?>
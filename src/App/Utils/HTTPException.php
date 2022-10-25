<?php 

namespace App\Utils;

class HTTPException extends \Exception {
    public function __construct($message, $code = 500, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function sendResponse(){
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
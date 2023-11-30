<?php

class MessageType {
    
    private $msg_type;
    private $msg_header;
    private $msg_body;
    
    public function set_msg_type($msg_type){
        $this->msg_type = $msg_type;
        
        return $this;
    }
    
    /**
     * @params [key_array];
     
     * @params['mid'] - message id
     * @params['auth'] - auth type
     * @params['user_ip'] - user ip address
     * @params['ver'] - api version
     * @params['imi'] - ignore message id
     * @params['usr'] - username
     * @params['pwd'] - password
     * @params['iid'] - api interface id
     
     * RESULT: xml/text header
     **/
    public function set_msg_header($params) {
    $authdata = base64_encode( '<authdata msg_id="'.$params['mid'].'"
        user="'.$params['usr'].'" password="'.$params['pwd'].'"
        msg_type="'.$this->msg_type.'" user_ip="'.$params['user_ip'].'" />' );
    
    $this->msg_header = '<header>
        <interface id="'.$params['iid'].'" version="'.$params['ver'].'" />
        <message id="1" ignore_id="'.$params['imi'].'"
            type="'.$this->msg_type.'" created="'.date("Y-m-d\TH:i:s\Z").'" />
        <error id="0" />
        <auth pwd="'.$params['auth'].'">'.$authdata.'</auth>
        </header>';
        
        return $this;
    }
    
    /**
     * @body [xml/text];
     
     * RESULT: xml/text body
     **/
    public function set_msg_body($body){
        $this->msg_body = '<body>'.$body.'</body>';
        
        return $this;
    }
    
    /**
     * RESULT: xml/text simbase api message
     **/
    public function get_api_message() {
        $message = '<?xml version="1.0" encoding="UTF-8"?>
        <sbapi>'
        .$this->msg_header
        .$this->msg_body.
        '</sbapi>';
        
        return $message;
    }
}

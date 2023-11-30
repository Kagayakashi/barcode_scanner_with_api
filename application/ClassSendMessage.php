<?php

class SendMessage {
    
    private $message;
    private $api_url;
    private $timeout;
    private $response;
    
    private $ssl_peer;
    private $ssl_host; 
    
    public function __construct($curl_ssl_verifypeer, $curl_ssl_verifyhost) {
        $this->ssl_peer = $curl_ssl_verifypeer;
        $this->ssl_host = $curl_ssl_verifyhost;
    }
    
    /**
     * @url [text];
     **/
    public function set_api_url($url) {
        $this->api_url = $url;
        return $this;
    }
    
    /**
     * @url [text];
     **/
    public function set_timeout($time) {
        $this->timeout = $time;
        return $this;
    }
    
    /**
     * @message [xml/text];
     **/
    public function set_api_message($message) {
        $this->message = $message;
        return $this;
    }
    
    /**
     * RESULT: CURL HTTP request response.
     **/
    public function send_message() {
        $http_header = array(
            "Content-type: text/xml",
            "Content-length: ".strlen($this->message),
            "Connection: close",
        );
        
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->message);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        if(!$this->ssl_peer) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl_peer);
        }
        if(!$this->ssl_host) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->ssl_host);
        }
        
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        
        // Curl error. Return
        if( $errno ) {
            $this->response = $errno;
            return $this;
        }
        
        // SimBASE response
        $response_xml = simplexml_load_string($response);
        $error = $response_xml->{'header'}->error;
        
        // SimBASE response error. Return
        if( $error['id'] != 0 ){ 
            $this->response = $response_xml->{'header'};
            return $this;
        }
        
        $this->response = $response_xml->{'body'};
        
        return $this;
    }
    
    public function get_response() {
        return $this->response;
    }
}

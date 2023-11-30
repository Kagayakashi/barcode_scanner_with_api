<?php

function d_echo($value, $die = true) {
    echo var_dump($value);
    
    if($die) {
        die();
    }
}

function log_error($params) {
    // Процесс авторизации
    $body = '<function name="f_api_log_error">
        <arg name="error_text">'.$_GET['error_text'].'</arg>
    </function>';
    
    $msg_type_object = new MessageType();
    $msg_type_object->set_msg_type(5000);
    $msg_type_object->set_msg_header($params);
    $msg_type_object->set_msg_body($body);
    $message = $msg_type_object->get_api_message();
    
    $send_message_object = new SendMessage($params['curl_ssl_verifypeer'], $params['curl_ssl_verifyhost']);
    $send_message_object->set_api_url($params['url']);
    $send_message_object->set_timeout($params['timeout']);
    $send_message_object->set_api_message($message);
    $send_message_object->send_message();
    $response = $send_message_object->get_response();
    
    
}
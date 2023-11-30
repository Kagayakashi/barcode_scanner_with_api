<?php

function action_password_reset($params) {
    // Процесс изменения данных объекта.    
    $body = '<function name="f_api_password_reset">
    <arg name="email">'.$_POST['email'].'</arg>
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
    
    if(empty($response->{'error'})) {
        // Регистрация успешна
        $_SESSION['flash_message']['text'] = (string)$response->{'ok'};
        $_SESSION['flash_message']['class'] = 'accept';
    }
    else {
        // Регистрация не успешна
        $_SESSION['flash_message']['text'] = (string)$response->{'error'};
        $_SESSION['flash_message']['class'] = 'decline';
    }
    
    header('Location: /?action=main');
}

function action_password_change($params) {
    // Процесс изменения данных объекта.    
    $body = '<function name="f_api_password_change">
    <arg name="username">'.$_POST['username'].'</arg>
    <arg name="password">'.$_POST['password'].'</arg>
    <arg name="password_new">'.$_POST['password_new'].'</arg>
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
    
    if(empty($response->{'error'})) {
        // Регистрация успешна
        $_SESSION['flash_message']['text'] = (string)$response->{'ok'};
        $_SESSION['flash_message']['class'] = 'accept';
        
        $_SESSION['password'] = hash('sha3-512', $_POST['password_new']);
    }
    else {
        // Регистрация не успешна
        $_SESSION['flash_message']['text'] = (string)$response->{'error'};
        $_SESSION['flash_message']['class'] = 'decline';
    }
    
    header('Location: /?action=home');
}

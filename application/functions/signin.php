<?php

function action_signin($params) {
    // Процесс авторизации
    $body = '<function name="f_api_select_user"></function>';
    
    $params['pwd'] = hash($params['hash_type'], $params['pwd']);
    
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
    
    if(!empty($response->{'ok'})) {
        // Авторизация успешна
        $_SESSION['logged_in'] = true;
        $_SESSION['flash_message']['text'] = (string)$response->{'ok'};
        $_SESSION['flash_message']['class'] = 'accept';
        $_SESSION['base'] = (string)$response->{'base'};
        $_SESSION['base_id'] = (string)$response->{'base_id'};
        $_SESSION['username'] = $params['usr'];
        $_SESSION['password'] = $params['pwd'];
        
        create_session_time();
        
        header('Location: /?action=home');
    }
    else {
        // Авторизация не успешна
        $_SESSION['flash_message']['text'] = 'Не удалось войти.';
        $_SESSION['flash_message']['class'] = 'decline';
        header('Location: /?action=signin');
    }
}
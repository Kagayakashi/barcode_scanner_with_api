<?php

function action_create($params) {
    // Процесс изменения данных объекта.
    
    if(empty($_POST['item_name']) || $_POST['item_name'] == '') {
        // Нет данных
        $_SESSION['flash_message']['text'] = 'Заполните наименование!';
        $_SESSION['flash_message']['class'] = 'decline';
        return header('Location: /?action=create');
    }
    elseif(empty($_POST['item_part']) || $_POST['item_part'] == '') {
        // Нет данных
        $_SESSION['flash_message']['text'] = 'Заполните партию!';
        $_SESSION['flash_message']['class'] = 'decline';
        return header('Location: /?action=create');
    }
    
    //$details = empty($_POST['item_details']) ? '' : '<arg name="item_details">'.$_POST['item_details'].'</arg>';
    $body = '<function name="f_api_create_item">
    <arg name="item_ean13">'.$_POST['item_ean13'].'</arg>
    <arg name="item_name">'.$_POST['item_name_id'].'</arg>
    <arg name="item_part">'.$_POST['item_part_id'].'</arg>
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
        header('Location: /?action=details');
    }
    else {
        // Регистрация не успешна
        $_SESSION['flash_message']['text'] = (string)$response->{'error'};
        $_SESSION['flash_message']['class'] = 'decline';
        header('Location: /?action=create');
    }
}
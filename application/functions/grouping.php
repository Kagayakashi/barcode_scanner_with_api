<?php

function action_add_to_group($params) {
    // Процесс добавления изделия в комплект.
    $i = $_SESSION['adding']['item_amount'];
    $i++;
    
    if($i == 1) {
        $body = '<function name="f_api_create_set"></function>';
        
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
            //  успешна
            $_SESSION['adding']['number'] = (string)$response->{'ok'};
        }
        elseif(!empty($response->{'error'})) {
            // Регистрация не успешна
            $_SESSION['adding']['number'] = (string)$response->{'error'};
        }
    }

    // Сохранение штрихкода, наименование и цеха изделия.
    $_SESSION['adding'][$i]['item_ean13'] = $_POST['item_ean13'];
    $_SESSION['adding'][$i]['item_name'] = $_POST['item_name'];
    $_SESSION['adding'][$i]['item_name_id'] = $_POST['item_name_id'];
    
    // Сохранение счётчика изделия
    $_SESSION['adding']['item_amount'] = $i;
    
    header('Location: /?action=grouping');
}

function action_grouping($params) {
    // Процесс создания изделия.
    // Процесс изменения данных объекта.

    if(empty($_POST['item_set']) || $_POST['item_set'] == '') {
        // Нет данных
        $_SESSION['flash_message']['text'] = 'Заполните наименование!';
        $_SESSION['flash_message']['class'] = 'decline';
        return header('Location: /?action=create');
    }
    
    $body = '<function name="f_api_save_set">
        <arg name="item_ean13">[';
    $i = 1;
    while($i <= $_SESSION['adding']['item_amount']) {
        $body .= $_SESSION['adding'][$i]['item_ean13'];
        if($i < $_SESSION['adding']['item_amount']) {
            $body .= ', ';
        }
        $i++;
    }
    $body .= ']</arg>
        <arg name="item_set">'.$_POST['item_set'].'</arg>
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

    if(!empty($response->{'ok'})) {
        // Регистрация успешна
        $_SESSION['flash_message']['text'] = (string)$response->{'ok'};
        $_SESSION['flash_message']['class'] = 'accept';
        $_SESSION['adding'] = null;
        $_SESSION['adding']['item_amount'] = 0;
    }
    elseif(!empty($response->{'error'})) {
        // Регистрация не успешна
        $_SESSION['flash_message']['text'] = (string)$response->{'error'};
        $_SESSION['flash_message']['class'] = 'decline';
    }
    
    header('Location: /?action=home');
}

function action_cancel_grouping() {
    // Процесс отмены в создании комплекта.
    $_SESSION['adding']['item_amount'] = 0;
    $_SESSION['adding'] = null;
    header('Location: /?action=home');
}

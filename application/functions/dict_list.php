<?php

function get_dict_list($params) {
    $body = '<function name="f_api_select_lists"></function>';
        
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
    
    // PARTS - Партии
    $i = 0;
    foreach($response->parts as $element) {
        // each element
        foreach($element as $data) {
            // element data
            $data_array['name'] = (string)$data->name;
            $data_array['id'] = (string)$data->id;
            $element_array[$i++] = $data_array;
        }
        $elements_array['parts'] = $element_array;
    }
    unset($element_array);
    unset($element);
    unset($data);
    
    // BASES - Цеха
    $i = 0;
    foreach($response->bases as $element) {
        // each element
        foreach($element as $data) {
            // element data
            $data_array['name'] = (string)$data->name;
            $data_array['id'] = (string)$data->id;
            $element_array[$i++] = $data_array;
        }
        $elements_array['bases'] = $element_array;
    }
    unset($element_array);
    unset($element);
    unset($data);
    
    // SETS - Комплекты
    $i = 0;
    foreach($response->sets as $element) {
        // each element
        foreach($element as $data) {
            // element data
            $data_array['name'] = (string)$data->name;
            $data_array['id'] = (string)$data->id;
            $element_array[$i++] = $data_array;
        }
        $elements_array['sets'] = $element_array;
    }
    unset($element_array);
    unset($element);
    unset($data);
    
    // Сохранить в сессию
    $_SESSION['dict_list'] = $elements_array;
}

function get_items($params) {
    $body = '<search dictionary="22"> 
        <field name="d_id" operator=">" value="0"></field>
    </search>
    <data limit="40000" total="off" picture="off"> 
        <field name="d_ename" sort="asc"></field>
        <field name="d_id"></field>
    </data>';
        
    $msg_type_object = new MessageType();
    $msg_type_object->set_msg_type(3100);
    $msg_type_object->set_msg_header($params);
    $msg_type_object->set_msg_body($body);
    $message = $msg_type_object->get_api_message();
    
    $send_message_object = new SendMessage($params['curl_ssl_verifypeer'], $params['curl_ssl_verifyhost']);
    $send_message_object->set_api_url($params['url']);
    $send_message_object->set_timeout($params['timeout']);
    $send_message_object->set_api_message($message);
    $send_message_object->send_message();
    $response = $send_message_object->get_response();
    
    $i = 0;
    foreach($response->data->element as $element) {
        foreach($element as $field) {
            if($field['name'] == 'd_ename') {
                $data_array['name'] = (string)$field;
            }
            elseif($field['name'] == 'd_id') {
                $data_array['id'] = (string)$field;
            }
        }
        $element_array[$i++] = $data_array;
    }
    
    $_SESSION['dict_list']['items'] = $element_array;
}
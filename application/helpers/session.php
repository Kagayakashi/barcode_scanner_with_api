<?php

function open_session() {
    session_start();
    // Присвоить первоначальное значение параметра авторизации.
    if(!isset($_SESSION['logged_in']))             { $_SESSION['logged_in'] = false; }
    // Присвоить первоначальное значение сообщения результата.
    if(!isset($_SESSION['flash_message']))         { $_SESSION['flash_message'] = null; }
    // Присвоить первоначальное значение счётчика изделий комплектации.
    if(!isset($_SESSION['adding']['item_amount'])) { $_SESSION['adding']['item_amount'] = 0; }
    // Присвоить первоначальное значение  номеру комплекта изделий.
    if(!isset($_SESSION['adding']['number']))      { $_SESSION['adding']['number'] = null; }
    // Присвоить первоначальное значение списку справочников.
    if(!isset($_SESSION['dict_list']))             { $_SESSION['dict_list'] = null; }
    // Присвоить первоначальное значение цеху (департамент).
    if(!isset($_SESSION['base']))                  { $_SESSION['base'] = null; }
    if(!isset($_SESSION['base_id']))               { $_SESSION['base_id'] = null; }
    
}

function close_session() {
    if(isset($_SESSION['logged_in'])){ unset($_SESSION['logged_in']); }
    if(isset($_SESSION['flash_message'])){ unset($_SESSION['flash_message']); }
    if(isset($_SESSION['dict_list'])){ unset($_SESSION['dict_list']); }
    if(isset($_SESSION['created'])){ unset($_SESSION['created']); }
    if(isset($_SESSION['last_update'])){ unset($_SESSION['last_update']); }
    if(isset($_SESSION['prev_update'])){ unset($_SESSION['prev_update']); }
    if(isset($_SESSION['prev_ubasepdate'])){ unset($_SESSION['base']); }
    if(isset($_SESSION['base_id'])){ unset($_SESSION['base_id']); }
    if(isset($_SESSION['username'])){ unset($_SESSION['username']); }
    if(isset($_SESSION['password'])){ unset($_SESSION['password']); }
    if(isset($_SESSION['adding'])){ unset($_SESSION['adding']); }
    
    header('Location: /?action=main');
}

function create_session_time() {
    $_SESSION['created'] = round(microtime(true));
    $_SESSION['prev_update'] = $_SESSION['created'];
    $_SESSION['last_update'] = $_SESSION['created'];
}

function update_session_time() {
    if($_SESSION['logged_in']) {
        // Обновление таймера сессии
        $_SESSION['prev_update'] = $_SESSION['last_update'];
        $_SESSION['last_update'] = round(microtime(true));
    }
}

function validate_session_time($max_time) {
    if(isset($_GET['action']) && !isset($_GET['code'])) {
        $not_allowed_without_auth = array('password_change', 'editing', 'create', 'grouping', 'add_to_group', 'home');
        
        if(!$_SESSION['logged_in'] && in_array($_GET['action'], $not_allowed_without_auth)) {
            
            close_session();
        }
    }
    
    if($_SESSION['logged_in']) {
        $time = $_SESSION['last_update'] - $_SESSION['prev_update'];
        if($time >= $max_time) {
            
            close_session();
        }
    }
}

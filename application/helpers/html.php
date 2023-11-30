<?php

/**
 * Общие параметра заголовка HTML
 **/
function h_html_header($title = '') {
    return '<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'.$title.'</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="icon" type="image/ico" href="images/favicon.ico"/>
    <link rel="icon" type="image/png" href="images/favicon.png"/>
    <link rel="stylesheet" href="css/share.css">
    <script src="js/webrtc_adapter/webrtc_adapter.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/device_info.js"></script>';
}

/**
 * Общие кнопки навигации HTML
 **/
function h_html_nav_block() {
    $name = ($_SESSION['logged_in']) ? 'home' : 'main';
    
    return '<div class="nav_block">
        <div class="img_home">
            <a href="/?action='.$name.'">
                <img alt="'.$name.'" src="images/home.png">
            </a>
        </div>
        <div class="img_exit">
            <a href="?action=logout">
                <img alt="Exit" src="images/logout.png">
            </a>
        </div>
    </div>';
}

/**
 * Общий логотип
 **/
function h_html_logo() {
    return '<div class="img_logo">
        <img src="images/logo.png">
    </div>';
}

/**
 * Общий заголовок страницы
 **/
function h_html_body_title($title) {
    
    $flash_message = '';
    if(isset($_SESSION['flash_message']['text']) && $_SESSION['flash_message']['text'] != null) {
        $flash_message = '<div class="flash_message '.$_SESSION['flash_message']['class'].'"><h6>'.$_SESSION['flash_message']['text'].'</h6></div>';
        $_SESSION['flash_message'] = null;
    }
    
    return '<div class="title_block">
        <h1>'.$title.'</h1>
        '.$flash_message.'
    </div>';
}

/**
 * Общее начало формы
 **/
function h_html_form_begin($method, $id = '') {
    return '<div class="form_container">
        <form method="'.$method.'" action="" id="'.$id.'">';
}

/**
 * Общая кнопка формы
 **/
function h_html_form_button($name, $value, $class = 'button_blue') {
    return '<div class="submit_block">
        <input type="hidden" name="action" value="'.$name.'" readonly>
        <input type="submit" name="button" class="'.$name.' '.$class.'" value="'.$value.'">
    </div>';
}

/**
 * Общий заголовов поля ввода формы
 **/
function h_html_form_field_label($name, $value) {
    return '<div class="label_block">
        <label for="'.$name.'">'.$value.'</label>
    </div>';
}

/**
 * Общее поле ввода формы
 **/
function h_html_form_field_input($name, $type, $required = '', $max_len = '', $hidden_name = '', $hidden_value = '') {
    $hidden_field = '';
    if(!empty($hidden)) {
        $hidden_field = '<input type="hidden" value="'.$hidden_value.'" name="'.$hidden_name.'" id="'.$hidden_name.'" '.$required.'>';
    }
    
    $length = '';
    if(!empty($max_len)) {
        $length = 'maxlength="'.$max_len.'"';
    }
    
    return '<div class="field_block">
        <input type="'.$type.'" name="'.$name.'" class="field_value '.$name.'" id="'.$name.'" '.$length.' '.$required.'>
        '.$hidden_field.'
    </div>';
}

/**
 * Общее поле ввода формы
 * @var $data structure
 * $data[index]['name']
 * $data[index]['id']
 **/
function h_html_form_field_datalist($name, $type, $data, $required = '', $max_len = '', $hidden_name = '', $hidden_value = '') {
    $options = '';
    foreach($data as $element) {
        $options .= '<option data-value="'.$element['id'].'" value="'.$element['name'].'">';
    }
    
    $length = '';
    if(!empty($max_len)) {
        $length = 'maxlength="'.$max_len.'"';
    }
    
    $field = '<input class="field_value '.$name.'" type="'.$type.'" list="'.$name.'_list"" name="'.$name.'" id="'.$name.'" '.$length.' '.$required.'>
        <input type="hidden" name="'.$hidden_name.'" id="'.$hidden_name.'">
        <datalist id="'.$name.'_list">'.$options.'</datalist>';
    
    return '<div class="field_block">
        '.$field.'
    </div>';
}

/**
 * Общее поле ввода формы
 **/
function h_html_form_field_readonly($name, $value = '', $hidden_name = '', $hidden_value = '') {
    return '<div class="field_block">
        <textarea name="'.$name.'" id="'.$name.'" class="readonly" cols="22" readonly>'.$value.'</textarea>
        <input value="'.$hidden_value.'" name="'.$hidden_name.'" type="hidden" id="'.$hidden_name.'" class="field_value" readonly>
    </div>';
    
    return '<div class="field_block">
        <input value="'.$value.'" name="'.$name.'" type="text" id="'.$name.'" class="field_value readonly" readonly>
        <input value="'.$hidden_value.'" name="'.$hidden_name.'" type="hidden" id="'.$hidden_name.'" class="field_value" readonly>
    </div>';
}

/**
 * Общее окончание формы
 **/
function h_html_form_end() {
    return '</form>
        </div>';
}

/**
 * Общий текстовый параграф
 **/
function h_html_text_paragraph($name, $value) {
    return '<div class="'.$name.'"><span class="'.$name.'">'.$value.'</span></div>';
}

/**
 * Общий нижний колонтитул
 **/
function h_html_footer() {
    $start = 2021;
    $year = date('Y');
    
    $year_text = $year > $start ? $start.'-'.$year : $year;
    
    return '<div class="copyrights">
        <p>&copy; '.$year_text.' ТЫНЫС г. Кокшетау</p>
    </div>';
}
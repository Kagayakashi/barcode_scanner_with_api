<?php

// Конфигурация
$cfg = require_once '../config/i_default.php';
$cfg = require_once '../i_custom.cfg';

// Классы для SimBASE API
require_once '../application/ClassMessageType.php';
require_once '../application/ClassSendMessage.php';

// Хелперы
require_once '../application/helpers/html.php';
require_once '../application/helpers/debug.php';
require_once '../application/helpers/session.php';

// Логика запросов и получение данных
require_once '../application/functions/dict_list.php';
require_once '../application/functions/get_item.php';
require_once '../application/functions/signin.php';
require_once '../application/functions/editing.php';
require_once '../application/functions/grouping.php';
require_once '../application/functions/create.php';
require_once '../application/functions/password.php';

/**
 * Сессия.
 * Функции сессии /functions/session
 **/
$max_time = $cfg['session'];

open_session();
update_session_time();
validate_session_time($max_time);

// Параметры запросов
$params['url']  = $cfg['api_url'];
$params['mid']  = $cfg['api_mid'];
$params['auth'] = $cfg['api_auth_type'];
$params['ver'] = $cfg['api_ver'];
$params['imi'] = $cfg['api_imi'];
$params['iid'] = $cfg['api_iid'];
$params['user_ip'] = $cfg['user_ip'];
$params['timeout'] = $cfg['api_rto'];
$params['hash_type'] = $cfg['pwd_hash_algo'];

$params['curl_ssl_verifypeer'] = $cfg['ssl_verifypeer'];
$params['curl_ssl_verifyhost'] = $cfg['ssl_verifyhost'];

// Данные пользователя SimBASE. Поумолчанию системный пользователь.
$params['usr'] = $cfg['api_login'];
$params['pwd'] = $cfg['api_pwd'];

if(isset($_GET['ajax'])) {
    /**
     * AJAX запрос на получение данных из SimBASE (5000 функция)
     * Возврат JSON.
     **/
    if($_GET['action'] == 'get_data' && isset($_GET['code'])) {
        // Получение данных изделия из объекта
        get_item_data($params);
    }
    elseif($_GET['action'] == 'error') {
        // Отправка логов ошибок в симбейс системным сообщением админам
        log_error($params);
    }
}
else {
    /**
     * Функция действия отправки форм.
     * - Авторизация пользователя,
     * - Изменение изделия,
     * - Регистрация изделия,
     *
     * После авторизации, пароль и логин хранится в сессии.
     * Пароль хешируется в функции /functions/signing/action_signin()
     * @var $_SESSION['username']
     * @var $_SESSION['password'] hash sha1
     **/
    if(isset($_POST['action'])){
        switch($_POST['action']) {
        case 'signing':
            // Процесс авторизации
            // Данные пользователя SimBASE.
            $params['usr'] = $_POST['username'];
            $params['pwd'] = $_POST['password'];
            return action_signin($params);
            break;
        case 'password_reset':
            // Процесс авторизации
            // Данные пользователя SimBASE.
            return action_password_reset($params);
            break;
        case 'password_change':
            // Процесс авторизации
            // Данные пользователя SimBASE.
            return action_password_change($params);
            break;
        case 'editing':
            // Процесс изменения данных объекта
            return action_editing($params);
            break;
        case 'create':
            // Процесс создания нового объекта
            return action_create($params);
            break;
        case 'adding_to_group':
            // Процесс добавления изделия в комплект
            return action_add_to_group($params);
            break;
        case 'setup_group':
            // Процесс создания нового комплекта изделий
            return action_grouping($params);
            break;
        }
    }
    
    if($_SESSION['logged_in']) {
        /**
         * При авторизации использовать пароль из сессии
         **/
        $params['usr'] = $_SESSION['username'];
        $params['pwd'] = $_SESSION['password'];
        
        
        if(isset($_GET['action'])) {
            switch($_GET['action']) {
            case 'editing':
            case 'create':
                /**
                 * Запрос данных справочников (5000 функция) и сохранение в сессию
                 * @var $_SESSION['dict_list']
                 **/
                get_dict_list($params);
                
                // Отдельно. Общее количество ~40k
                get_items($params);
                break;
            }
        }
    }
    
    /**
     * Отображение страниц
     **/
    if(isset($_GET['action'])) {
        switch($_GET['action']) {
        case 'logout':
            close_session();
            break;
        case 'cancel_group':
            // Процесс отмены в создании комплекта
            action_cancel_grouping($params);
            break;
        case 'signin':
        case 'home':
        case 'main':
        case 'scanning':
        case 'grouping':
        case 'add_to_group':
        case 'details':
        case 'editing':
        case 'create':
        case 'password_reset':
        case 'password_change':
            include '../application/views/'.$_GET['action'].'_screen.php';
            break;
        }
    }
    else {
        include '../application/views/main_screen.php';
    }
}

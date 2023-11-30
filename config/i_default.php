<?php
// ---------------------------------------------------------------------------->
// Copyright Simourg 2021. All rights reserved.
//
// WARNING: this is PHP file, so be careful with syntax.
// ---------------------------------------------------------------------------->

/**
 * API Connect
 **/

// version API
$cfg['api_ver'] = 8;
// url API
$cfg['api_url'] = 'localhost';
// API ID (hex) 
$cfg['api_iid'] = '000000';
// ignore MESSAGE_ID in API. yes / no
$cfg['api_imi'] = 'yes';
// Auth type. hash / open
$cfg['api_auth_type'] = 'hash';
// Hash algo
$cfg['pwd_hash_algo'] = 'sha3-512';
// timeout http
$cfg['api_rto'] = 60;

/**
 * System
 **/
$cfg['api_login'] = 'username';
$cfg['api_pwd'] = 'password';

// SSL check
$cfg['ssl_verifypeer'] = TRUE;
$cfg['ssl_verifyhost'] = TRUE;

// IP remote user
$cfg['user_ip'] = '127.0.0.1';
// Session time
$cfg['session'] = 300;

/**
 * DEBUG
 **/
$cfg['debug'] = 0;

return $cfg;

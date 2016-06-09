<?php

session_start();

//set timezone
date_default_timezone_set('America/Sao_Paulo');

/*
 * Template for defined values
 * defined('') ? null : define('', '');
 */

//database credentials
defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
defined('DB_USER') ? null : define('DB_USER', 'root');
defined('DB_PASS') ? null : define('DB_PASS', 'toor');
defined('DB_NAME') ? null : define('DB_NAME', 'bioconverter');

//application address
defined('DIR') ? null : define('DIR', 'http://domain.com/');
defined('SITEEMAIL') ? null : define('SITEEMAIL', 'noreply@domain.com');

//cookies for login
defined('APP_ID') ? null : define('APP_ID', 'bioconverter');
defined('KEY_ID') ? null : define('KEY_ID', '71536d433c27472b7325765457644d43662b69566d4a27294720756b71');
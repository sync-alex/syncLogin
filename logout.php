<?php
include_once dirname(__FILE__) . '\config.php';
include_once dirname(__FILE__) . '\functions.php';

$past = time() - 100; 
//this makes the time in the past to destroy the cookie 
setcookie(APP_ID, gone, $past); 
setcookie(KEY_ID, gone, $past);

Redirect("login.php");
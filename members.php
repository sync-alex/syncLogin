<?php

include_once dirname(__FILE__) . '\config.php';
include_once dirname(__FILE__) . '\database.php';
include_once dirname(__FILE__) . '\functions.php';

 //checks cookies to make sure they are logged in 
 if(COOKIE_value(APP_ID)){
    $id = COOKIE_value(APP_ID); 
    $pass = COOKIE_value(KEY_ID);

    $db->query(" SELECT * FROM usuarios WHERE id = '$id' ");
    
    while($info = $db->all()){
        //if the cookie has the wrong password, they are taken to the login page
        $passDb = "";
        foreach($info as $row) {
            $passDb = $row['senha'];            
        }
        
        if ($pass != $passDb){
            Redirect("login.php"); 
        } else {
            //otherwise they are shown the admin area
            echo "Admin Area<p>"; 
            echo "Your Content<p>"; 
            echo "<a href=logout.php>Logout</a>"; 
        }
    }
} else { //if the cookie does not exist, they are taken to the login screen 
    Redirect("login.php"); 
 }

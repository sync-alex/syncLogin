<?php

include_once dirname(__FILE__) . '\config.php';
include_once dirname(__FILE__) . '\database.php';
include_once dirname(__FILE__) . '\functions.php';

//Checks if there is a login cookie
if(COOKIE_value(APP_ID)){ //if there is, it logs you in and directes you to the members page
    $id = filter_input(INPUT_COOKIE, APP_ID); 
    $pass = filter_input(INPUT_COOKIE, KEY_ID);
    $check = $db->query(" SELECT * FROM usuarios WHERE id = '$id' ");
    
    while($info = $db->all()){
        
        $passDb = "";
        foreach($info as $row) {
            $passDb = $row['senha'];            
        }
        
        if ($passDb == $pass) {     
            Redirect("members.php");
        } else {
            Redirect("add.php");
        }
    }
 }

 //if the login form is submitted 
 if (POST_value('submit')) {
    // makes sure they filled it in
    if(!POST_value('username')){
        die('You did not fill in a username.');
    }
     if(!POST_value('email')){
        die('You did not fill a email.');
    }
    if(!POST_value('pass')){
        die('You did not fill in a password.');
    }

    // checks it against the database
    if (!get_magic_quotes_gpc()){
        $_POST['username'] = addslashes(POST_value('username'));
    }
    
    $query = " SELECT * FROM usuarios WHERE email = '" . POST_value('email') . "' ";
    $query .= " and nome like '%" . POST_value('username') . "%' ";
    $db->query($query);            

    //Gives error if user dosen't exist
    $check2 = $db->rows();
    if ($check2 == 0){
        die('That user does not exist in our database.<br /><br />If you think this is wrong <a href="login.php">try again</a>.');
    }

    while($info = $db->all()){
        
        $idDb = "";        
        foreach($info as $row) {
            $passDb = $row['senha'];
            $idDb = $row['id'];
        }
        
        $_POST['pass'] = stripslashes(POST_value('pass'));
        $passDb = stripslashes($passDb);
        
        if (password_verify(POST_value('pass'), $passDb)) {
            // Login successful.
            
            $hour = time() + 3600; 
            setcookie(APP_ID, $idDb, $hour); 
            setcookie(KEY_ID, $passDb, $hour);	 

            //then redirect them to the members area 
            Redirect("members.php");
            
            //if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                // Recalculate a new password_hash() and overwrite the one we stored previously
            //}
        } else {
            //gives error if the password is wrong
            die('Incorrect password, please <a href="login.php">try again</a>.');
        }
    }
} else {
// if they are not logged in 
?>

<form action="<?php echo SERVER_value('PHP_SELF'); ?>" method="post">
    <table> 
        <tr>
            <td colspan=2>
                <h1>Login</h1>
            </td>
        </tr> 
        <tr>
            <td>Email:</td>
            <td> 
                <input type="text" name="email" maxlength="40" /> 
            </td>
        </tr>
        <tr>
            <td>Username:</td>
            <td> 
                <input type="text" name="username" maxlength="40" /> 
            </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td> 
                <input type="password" name="pass" maxlength="50" /> 
            </td>
        </tr> 
        <tr>
            <td> 
                <input type="submit" name="submit" value="Login" />                                
            </td>
            <td>
                <p>
                    <label>Or <a href="add.php"> Sign Up</a>.</label>
                </p>
            </td>
        </tr> 
    </table>
</form>
 <?php }
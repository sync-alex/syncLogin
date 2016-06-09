<?php
include_once dirname(__FILE__) . '\config.php';
include_once dirname(__FILE__) . '\database.php';
include_once dirname(__FILE__) . '\functions.php';

//This code runs if the form has been submitted
if (POST_value('submit')) {
    //This makes sure they did not leave any fields blank
    if (!POST_value('username')
            | !POST_value('pass') 
            | !POST_value('pass2')) {
        die('You did not complete all of the required fields');
    }

    // checks if the username is in use
    if (!get_magic_quotes_gpc()) {
        $_POST['username'] = addslashes(POST_value('username'));
    }

    $emailcheck = POST_value('email');
    $usercheck = POST_value('username');
    $db->query(" SELECT email FROM usuarios WHERE email = '$emailcheck' ");            
    $check2 = $db->rows();

    //if the name exists it gives an error
    if ($check2 != 0) {
        die('Sorry, the email ' . POST_value('email') . ' is already in use.');
    }

    // this makes sure both passwords entered match
    if (POST_value('pass') != POST_value('pass2')) {
        die('Your passwords did not match. ');
    }

    if (!get_magic_quotes_gpc()) {
        $_POST['pass'] = addslashes(POST_value('pass'));
        $_POST['username'] = addslashes(POST_value('username'));
    }
    
    $hash = password_hash(POST_value('pass'), PASSWORD_DEFAULT);
    
    // now we insert it into the database
    $query = " INSERT INTO usuarios (nome, email, senha) VALUES ('";
    $query .= POST_value('username') . "', '";
    $query .= POST_value('email') . "', '";
    $query .= $hash . "') ";
    $db->query($query);    
    $add_member = $db->fetch();
?>
 <h1>Registered</h1>
 <p>Thank you, you have registered - you may now 
     <a href="login.php">login</a>.
 </p>
 <?php 
}
else
{    
    
?> 
 <form action="<?php echo filter_input(INPUT_SERVER, 'PHP_SELF'); ?>" method="post">
    <table>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="email" maxlength="60" />
            </td>
        </tr>
        <tr>
            <td>Username:</td>
            <td>
                <input type="text" name="username" maxlength="60" />
            </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td>
                <input type="password" name="pass" maxlength="10" />
            </td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td>
                <input type="password" name="pass2" maxlength="10" />
            </td>
        </tr>
        <tr>
            <th colspan=2>
                <input type="submit" name="submit" value="Register">
            </th>
        </tr>
    </table>
 </form>
<?php }

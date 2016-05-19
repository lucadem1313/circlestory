<?php

    $relative = '../';
    $currentpage = 'Sign Up';
    include($relative.'includes/start.php');
    
    if(isset($_POST['checkusername']))
    {
        if((((mysql_num_rows(mysql_query("SELECT * FROM users WHERE username='".$_POST['checkusername']."'")) > 1 && $_POST['checkusername'] == $username) || (mysql_num_rows(mysql_query("SELECT * FROM users WHERE username='".$_POST['checkusername']."'")) > 0 && $_POST['checkusername'] != $username)) || mysql_num_rows(mysql_query("SELECT * FROM unverified WHERE username='".$_POST['checkusername']."'")) > 0))
        {
            echo true;
            
        }
        else
        {
            echo false;
        }
    }
    
    if(isset($_POST['username']))
    {
        $username = $_POST["username"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        
        $breaks = array("\r\n","\n\r","\r","\n");
        $description = str_replace($breaks, '', nl2br(htmlentities($_POST["description"])));
        
        if(!(((mysql_num_rows(mysql_query("SELECT * FROM users WHERE username='".$_POST['username']."'")) > 1 && $_POST['username'] == $username) || (mysql_num_rows(mysql_query("SELECT * FROM users WHERE username='".$_POST['username']."'")) > 0 && $_POST['username'] != $username)) || mysql_num_rows(mysql_query("SELECT * FROM unverified WHERE username='".$_POST['username']."'")) > 0))
        {
            if(true)
            {
                if(!(strlen($username) > 30 || strlen($username) < 1 || strlen($firstname) > 30 || strlen($firstname) < 1 || strlen($lastname) > 30 || strlen($lastname) < 1))
                {
                    $insertinfo = mysql_query("UPDATE users SET firstname='".mysql_real_escape_string($firstname)."', lastname='".mysql_real_escape_string($lastname)."', username='".mysql_real_escape_string($username)."', description='".mysql_real_escape_string($description)."' WHERE id=$userid");
                }
                else
                {
                    $error = 3;
                }
            }
            else
            {
                $error = 2;
            }
        }
        else
        {
            $error = 1;
        }
        
        echo $error;
    }

?>
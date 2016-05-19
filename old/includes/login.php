<?php


    $cookie = "asdfas";
    
    if(isset($cookie))
    {
        $username = "ltdemian";
        $loggedin = true;
        $selectuserinfo = mysql_query("SELECT * FROM users WHERE username='$username'");
        while($row = mysql_fetch_array($selectuserinfo))
        {
            $userid = $row{"id"};
        }
        $selectmod = mysql_query("SELECT * FROM moderators WHERE userid=$userid");
        if(mysql_num_rows($selectmod) > 0)
        {
            $mod = true;
        }
        else
        {
            $mod = false;
        }
    }
    else
    {
        $loggedin = false;
    }
    
?>
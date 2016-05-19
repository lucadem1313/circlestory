<?php

    $relative = '../';
    $currentpage = 'Sign Up';
    include($relative.'includes/start.php');
    
    
    if(isset($_GET['id']))
        $idstring = $_GET['id'];
    else
        header("Location: ".$relative);
        
    $selectinfo = mysql_query("SELECT * FROM unverified WHERE idstring='$idstring'");
    
    if(mysql_num_rows($selectinfo) < 1)
    {
        header("Location: ".$relative);
    }
    else
    {
        while($row = mysql_fetch_array($selectinfo))
        {
            $firstname = $row{'firstname'};
            $lastname = $row{'lastname'};
            $username = $row{'username'};
            $password = $row{'password'};
            $description = $row{'description'};
            $email = $row{'email'};
        }
        
        $insertinfo = mysql_query("INSERT INTO users (firstname, lastname, username, password, description, email) VALUES ('".$firstname."', '".$lastname."', '".$username."', '".$password."', '".$description."', '".$email."')");
        $deleteinfo = mysql_query("DELETE FROM unverified WHERE idstring='$idstring' LIMIT 1");
        
        $_SESSION['loggedin'] = openssl_encrypt($username, ENCRYPTION_TYPE, ENCRYPTION_PASSWORD);
        
        $loggedin = true;
        
        header("Location: ".$relative);
    }
?>
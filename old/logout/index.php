<?php
    
    include($path."includes/define.php");
    include($path."includes/login.php");
    
    function logout(){
        
    }
    
    logout();
    
    header("Location: ".$path);
?>
<?php


$relative = '../';
include($relative."includes/define.php");
include($relative."includes/connect.php");
include($relative."includes/login.php");

if(isset($_POST["newaddition"]))
{
    $storyid = $_POST['id'];
    $editnumber = mysql_num_rows(mysql_query("SELECT * FROM additions WHERE id=$storyid AND approved=1"));
    mysql_query("INSERT INTO additions (storyid, userid, text, editnumber, anonymous) VALUES ('".mysql_real_escape_string($storyid)."', '".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($_POST["newaddition"])."', '".mysql_real_escape_string($editnumber + 1)."', '".mysql_real_escape_string($_POST["anonymous"])."')");
}
if(isset($_POST["likestory"]))
{
    $storyid = $_POST['id'];
    mysql_query("INSERT INTO storylikes (storyid, userid) VALUES ('".mysql_real_escape_string($storyid)."', '".mysql_real_escape_string($userid)."')") or die(mysql_error());
}
if(isset($_POST["unlikestory"]))
{
    $storyid = $_POST['id'];
    mysql_query("DELETE FROM storylikes WHERE storyid=$storyid AND userid=$userid") or die(mysql_error());
}
if(isset($_POST["likeaddition"]))
{
    $storyid = $_POST['id'];
    mysql_query("INSERT INTO additionlikes (additionid, userid) VALUES ('".mysql_real_escape_string($storyid)."', '".mysql_real_escape_string($userid)."')") or die(mysql_error());
}
if(isset($_POST["unlikeaddition"]))
{
    $storyid = $_POST['id'];
    mysql_query("DELETE FROM additionlikes WHERE additionid=$storyid AND userid=$userid") or die(mysql_error());
}
if(isset($_POST["reportstory"]))
{
    $storyid = $_POST['id'];
    mysql_query("INSERT INTO storyreports (storyid, userid, title, report) VALUES ('".mysql_real_escape_string($storyid)."', '".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($_POST["title"])."', '".mysql_real_escape_string($_POST["text"])."')");
}
if(isset($_POST["reportaddition"]))
{
    $additionid = $_POST['id'];
    mysql_query("INSERT INTO additionreports (additionid, userid, title, report) VALUES ('".mysql_real_escape_string($additionid)."', '".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($_POST["title"])."', '".mysql_real_escape_string($_POST["text"])."')");
}

if(isset($_POST["favorite"]))
{
    $storyid = $_POST['id'];
    mysql_query("INSERT INTO favorites (storyid, userid) VALUES ('".mysql_real_escape_string($storyid)."', '".mysql_real_escape_string($userid)."')") or die(mysql_error());
}
if(isset($_POST["unfavorite"]))
{
    $storyid = $_POST['id'];
    mysql_query("DELETE FROM favorites WHERE storyid=$storyid AND userid=$userid") or die(mysql_error());
}
if(isset($_POST["follow"]))
{
    $storyid = $_POST['id'];
    mysql_query("INSERT INTO following (storyid, userid) VALUES ('".mysql_real_escape_string($storyid)."', '".mysql_real_escape_string($userid)."')") or die(mysql_error());
}
if(isset($_POST["unfollow"]))
{
    $storyid = $_POST['id'];
    mysql_query("DELETE FROM following WHERE storyid=$storyid AND userid=$userid") or die(mysql_error());
}

if(isset($_POST["deletestory"]))
{
    $storyid = $_POST['id'];
    $selectifmod = mysql_query('SELECT * FROM moderators WHERE userid='.$userid.'');
    $selectifstarted = mysql_query("SELECT * FROM stories WHERE userid=$userid AND id=$storyid");
    
    if(mysql_num_rows($selectifmod) || mysql_num_rows($selectifstarted))
    {
        mysql_query("DELETE FROM stories WHERE id=$storyid") or die(mysql_error());
        mysql_query("DELETE FROM following WHERE storyid=$storyid") or die(mysql_error());
        mysql_query("DELETE FROM storyreports WHERE storyid=$storyid") or die(mysql_error());
        mysql_query("DELETE FROM favorites WHERE storyid=$storyid") or die(mysql_error());
        mysql_query("DELETE FROM storylikes WHERE storyid=$storyid") or die(mysql_error());
        mysql_query("DELETE FROM storysubjects WHERE storyid=$storyid") or die(mysql_error());
        mysql_query("DELETE FROM tags WHERE storyid=$storyid") or die(mysql_error());
    }
}
if(isset($_POST["deleteaddition"]))
{
    $id = $_POST['storyid'];
    $storyid = $_POST['additionid'];
    $selectifmod = mysql_query('SELECT * FROM moderators WHERE userid='.$userid.'');
    $selectifstarted = mysql_query("SELECT * FROM stories WHERE userid=$userid AND id=$id");
    
    if(mysql_num_rows($selectifmod) || mysql_num_rows($selectifstarted))
    {
        mysql_query("DELETE FROM additions WHERE id=$storyid") or die(mysql_error());
        mysql_query("DELETE FROM additionlikes WHERE additionid=$storyid") or die(mysql_error());
        mysql_query("DELETE FROM additionreports WHERE additionid=$storyid") or die(mysql_error());
    }
}
if(isset($_POST["approveaddition"]))
{
    $id = $_POST['storyid'];
    $storyid = $_POST['additionid'];
    $selectifmod = mysql_query('SELECT * FROM moderators WHERE userid='.$userid.'');
    $selectifstarted = mysql_query("SELECT * FROM stories WHERE userid=$userid AND id=$id");
    
    if(mysql_num_rows($selectifmod) || mysql_num_rows($selectifstarted))
    {
        mysql_query("UPDATE additions SET approved=1 WHERE id=$storyid") or die(mysql_error());
    }
}
if(isset($_POST["unapproveaddition"]))
{
    $id = $_POST['storyid'];
    $storyid = $_POST['additionid'];
    $selectifmod = mysql_query('SELECT * FROM moderators WHERE userid='.$userid.'');
    $selectifstarted = mysql_query("SELECT * FROM stories WHERE userid=$userid AND id=$id");
    
    if(mysql_num_rows($selectifmod) || mysql_num_rows($selectifstarted))
    {
        mysql_query("UPDATE additions SET approved=0 WHERE id=$storyid") or die(mysql_error());
    }
}
if(isset($_POST["verifyaddition"]))
{
    $id = $_POST['storyid'];
    $storyid = $_POST['additionid'];
    $selectifmod = mysql_query('SELECT * FROM moderators WHERE userid='.$userid.'');
    $selectifstarted = mysql_query("SELECT * FROM stories WHERE userid=$userid AND id=$id");
    
    if(mysql_num_rows($selectifmod) || mysql_num_rows($selectifstarted))
    {
        mysql_query("UPDATE additions SET verified=1 WHERE id=$storyid") or die(mysql_error());
    }
}
if(isset($_POST["unverifyaddition"]))
{
    $id = $_POST['storyid'];
    $storyid = $_POST['additionid'];
    $selectifmod = mysql_query('SELECT * FROM moderators WHERE userid='.$userid.'');
    $selectifstarted = mysql_query("SELECT * FROM stories WHERE userid=$userid AND id=$id");
    
    if(mysql_num_rows($selectifmod) || mysql_num_rows($selectifstarted))
    {
        mysql_query("UPDATE additions SET verified=0 WHERE id=$storyid") or die(mysql_error());
    }
}
if(isset($_POST["verifystory"]))
{
    $storyid = $_POST['id'];
    $selectifmod = mysql_query('SELECT * FROM moderators WHERE userid='.$userid.'');
    $selectifstarted = mysql_query("SELECT * FROM stories WHERE userid=$userid AND id=$storyid");
    
    if(mysql_num_rows($selectifmod) || mysql_num_rows($selectifstarted))
    {
        mysql_query("UPDATE stories SET verified=1 WHERE id=$storyid") or die(mysql_error());
    }
}
if(isset($_POST["unverifystory"]))
{
    $storyid = $_POST['id'];
    $selectifmod = mysql_query('SELECT * FROM moderators WHERE userid='.$userid.'');
    $selectifstarted = mysql_query("SELECT * FROM stories WHERE userid=$userid AND id=$storyid");
    
    if(mysql_num_rows($selectifmod) || mysql_num_rows($selectifstarted))
    {
        mysql_query("UPDATE stories SET verified=0 WHERE id=$storyid") or die(mysql_error());
    }
}
?>
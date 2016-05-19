<?php


$relative = '';
include($relative."includes/define.php");
include($relative."includes/connect.php");
include($relative."includes/login.php");


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
if(isset($_POST["reportstory"]))
{
    $storyid = $_POST['id'];
    mysql_query("INSERT INTO storyreports (storyid, userid, title, report) VALUES ('".mysql_real_escape_string($storyid)."', '".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($_POST["title"])."', '".mysql_real_escape_string($_POST["text"])."')");
}
?>
<?php


$relative = '../';
include($relative."includes/define.php");
include($relative."includes/connect.php");
include($relative."includes/login.php");

if(isset($_POST["post"]))
{
    $table_name = "stories"; 
    $query = mysql_query("SHOW TABLE STATUS WHERE name='$table_name'"); 
    $row = mysql_fetch_array($query); 
    $nextid = $row["Auto_increment"];
    
    
    
    if($_POST['tags'] != '')
        $tags = explode(', ',$_POST['tags']);
    else
        $tags = [];
    
    $title = $_POST['title'];
    $longid = explode(30, $title)[0];
    $longid = strtolower($longid);
    $longid = str_replace(' ', '-', $longid);
    $longid = $longid."-".$nextid;
    $longid = preg_replace("/[^A-Za-z0-9 ]/", '', $longid);
    $text = $_POST['post'];
    $text = strip_tags($text, '<br><b><i><u><blockquote><h1><h2><h3><h4>');
    $text = strip_tags($text, '<br><b><i><u><blockquote><h1><h2><h3><h4>');
    $text = strip_tags($text, '<br><b><i><u><blockquote><h1><h2><h3><h4>');
    $text = strip_tags($text, '<br><b><i><u><blockquote><h1><h2><h3><h4>');
    $text = strip_tags($text, '<br><b><i><u><blockquote><h1><h2><h3><h4>');
    $text = strip_tags($text, '<br><b><i><u><blockquote><h1><h2><h3><h4>');
    $text = strip_tags($text, '<br><b><i><u><blockquote><h1><h2><h3><h4>');
    
    $genre = $_POST['genre'];
    
    if(mysql_num_rows(mysql_query("SELECT * FROM subjects WHERE id=$genre")) < 1)
    {
        $genre = 1;
    }
    
    mysql_query("INSERT INTO storysubjects (storyid, subjectid) VALUES ('".mysql_escape_string($nextid)."', '".mysql_escape_string($genre)."')");
    
    mysql_query("INSERT INTO stories (title, userid, text, storylongid) VALUES ('".mysql_real_escape_string($title)."', '".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($text)."', '".mysql_real_escape_string($longid)."')");
    
    foreach($tags as $tag)
    {
        mysql_query("INSERT INTO tags (storyid, tag) VALUES ('".mysql_real_escape_string($nextid)."','".mysql_real_escape_string($tag)."')");
    }
}

?>
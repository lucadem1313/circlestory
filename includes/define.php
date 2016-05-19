<?php

session_start();

$sitename = "Circle Story";
$path = "/circlestory/";
$pathtouser = $path."user?id=";
$pathtosubject = "subject?s=";
$pathtotag = $path."tag?id=";
$error404path = $path."error404.php";
$pathtostory = $path."story?id=";

$url = 'http://lucademian.com/circlestory';

define('ENCRYPTION_PASSWORD', 'RETRACTED');
define('ENCRYPTION_TYPE', 'blowfish');
?>
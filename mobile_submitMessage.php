<?php

ob_start();
$db_username="reck";
$db_password="burdell";

$dsn = 'mysql:host=mysql.localhost;dbname=reck_club';
$db= new PDO($dsn, $db_username, $db_password);
session_start();
$userId = $_SESSION[memberID];

$name = $_SESSION[firstName]." ".$_SESSION[lastName];
$message = $_POST[message];

$userInfo= $db->prepare("INSERT INTO  `Messages` (  `id` ,  `user` ,  `date` ,  `message` ) VALUES (NULL , :name, CURRENT_TIMESTAMP , :message);");
$userInfo->bindValue("name",$name, PDO::PARAM_STR);
$userInfo->bindValue("message",$message, PDO::PARAM_STR);
$userInfo->execute();

header("location:mobile.php#messages");
?>

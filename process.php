<?php

require "database_connect.php";

$db = new PDO($dsn, $username, $password);

$title = $_POST['title'];
$type = intval($_GET['type']);

$user=$_POST['user'];
$year= $_GET['year'];

if($type==0){
	$insertStory= $db->prepare("INSERT INTO stories (title, year, user, type) VALUES (:title, :year, :user,:type)");
	$insertStory->bindValue("title",$title, PDO::PARAM_STR);
	$insertStory->bindValue("year",$year, PDO::PARAM_STR);
	$insertStory->bindValue("user",$user, PDO::PARAM_STR);
	$insertStory->bindValue("type",$type, PDO::PARAM_STR);
$insertStory->execute();
} elseif($type==1){
	$story = htmlentities($_POST['story']);
	$insertStory= $db->prepare("INSERT INTO stories (title, year, user, type, story) VALUES (:title, :year, :user,:type,:story)");
	$insertStory->bindValue("title",$title, PDO::PARAM_STR);
	$insertStory->bindValue("year",$year, PDO::PARAM_STR);
	$insertStory->bindValue("user",$user, PDO::PARAM_STR);
	$insertStory->bindValue("type",$type, PDO::PARAM_STR);
	$insertStory->bindValue("story",$story, PDO::PARAM_STR);
	$insertStory->execute();
}else{
	echo "Error.";
}
header( 'Location: history.php?year='.$year ) ;

?>
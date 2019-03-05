<?php

require "database_connect.php";

$db = new PDO($dsn, $username, $password);

$year= $_GET['year'];
$id = intval($_GET['id']);

	// $delStory= $db->prepare("DELETE FROM stories WHERE id=:id");
	// $delStory->bindValue("id",$id, PDO::PARAM_STR);
	// $delStory->execute();

	$update_query = $db->prepare("UPDATE  stories SET  deleted = 1 WHERE id=:id");
	$update_query->execute(array('id'=>$id));


header( 'Location: history.php?year='.$year ) ;

?>
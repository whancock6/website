<?php
	require "database_connect.php";

	$storyId=intval($_GET["id"]);

	$story_query= $db->prepare("SELECT story FROM stories WHERE id=:id");
	$story_query->bindValue("id",$storyId, PDO::PARAM_STR);
	$story_query->execute();

	$row = $story_query->fetch();

	$story = $row['story'];
	echo html_entity_decode($story);

?>

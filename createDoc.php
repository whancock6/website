<?php
	require "logged_in_check.php";
	require "database_connect.php";
	
	$query = $db->prepare("INSERT INTO Docs (Name, URL, User, Type, Description) VALUES(:name,:url,:user,:type,:description)");
	$query->execute(array('name'=>$_POST[name], 'url'=>$_POST[url], 'user'=>$_POST[user], 'type'=>$_POST[type], 'description'=>$_POST[description]));
	
	header("Location:docs.php");	
?>
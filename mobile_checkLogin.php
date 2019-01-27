<?php
ob_start();
$db_username="reck";
$db_password="burdell";

$dsn = 'mysql:host=mysql.localhost;dbname=reck_club';
$db= new PDO($dsn, $db_username, $db_password);
session_start();
$postUser=$_POST[username];
$postPass=md5($_POST[password]);


$stmt= $db->prepare("SELECT * FROM Member WHERE username=:user AND password=:pass");
$stmt->bindValue("user",$postUser, PDO::PARAM_STR);
$stmt->bindValue("pass",$postPass, PDO::PARAM_STR);
$stmt->execute();

$count=$stmt->rowCount();
if($count==1){
	//get user
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	// Register $myusername, $mypassword and redirect to file "login_success.php"
		$_SESSION[username] = $row[username];
		$_SESSION[memberID] = $row[memberID];
		$_SESSION[firstName] = $row[firstName];
		$_SESSION[lastName] = $row[lastName];
		$_SESSION[isAdmin] = $row[isAdmin];
		$_SESSION[isEventAdmin] = $row[isEventAdmin];
		$_SESSION[memFamilyID] = $row[memFamilyID];
	header("location:mobile.php");
	
}
else {
	header("location:mobile_memberLoginForm.php");
}

?>
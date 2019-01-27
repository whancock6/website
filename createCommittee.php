<?php
	require "logged_in_check.php";
	if ($_SESSION['isAdmin']==0 && $_SESSION['isVP']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	$query = $db->prepare("INSERT INTO Committee (committeeName) VALUES (:committeeName)");
	$query->execute(array('committeeName'=>$_POST[committeeName]));
	
	echo "<h3>Committee Created</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageCommittees.php\">";

	require "html_footer.txt";	
?>
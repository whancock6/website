<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isSecretary]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	$query = $db->prepare("DELETE FROM Member WHERE memberID=:memberID");
	$query->execute(array('memberID'=>$_POST[memberID]));
	
	echo "<h3>Member Deleted</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageMembers.php\">";
	
	require "html_footer.txt";
?>
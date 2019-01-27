<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";

	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	$db->query("DELETE FROM Event");
	$db->query("UPDATE Member SET memberPoints=0, mandatoryEventCount=0, sportsEventCount=0, socialEventCount=0, workEventCount=0");
	$db->query("UPDATE Family SET familyPoints=0");
	
	echo "<h3>Points Reset</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageWebsite.php\">";

	require "html_footer.txt";
?>
<?php
	require "logged_in_check.php";
	require "set_session_vars_short.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	$query = $db->prepare("UPDATE Member SET password=:password WHERE memberID=:memberID");
	$query->execute(array('password'=>md5($_POST[newPassword]), 'memberID'=>$_POST["memberID"]));
	
	print("<h3>Password Changed</h3>");
	print("<meta http-equiv=\"refresh\" ");
	print("content=\"2; url=memberProfile.php\">");
	
	require "html_footer.txt";
?>
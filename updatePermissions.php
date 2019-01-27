<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	if($_POST[selectedMember] != "none" && $_POST[selectedRole] != "none") {
		if(isset($_POST[add])) {
			if($_POST[selectedRole] == "isAdmin") {
				$query = $db->prepare("UPDATE Member SET isAdmin = 1 WHERE memberID = :memberID");
				$query->execute(array('memberID'=>$_POST[selectedMember]));
			}elseif($_POST[selectedRole] == "isEventAdmin") {
				$query = $db->prepare("UPDATE Member SET isEventAdmin = 1 WHERE memberID = :memberID");
				$query->execute(array('memberID'=>$_POST[selectedMember]));
			}
		}elseif(isset($_POST[remove])) {
			if($_POST[selectedRole] == "isAdmin") {
				$query = $db->prepare("UPDATE Member SET isAdmin = 0 WHERE memberID = :memberID");
				$query->execute(array('memberID'=>$_POST[selectedMember]));
			}elseif($_POST[selectedRole] == "isEventAdmin") {
				$query = $db->prepare("UPDATE Member SET isEventAdmin = 0 WHERE memberID = :memberID");
				$query->execute(array('memberID'=>$_POST[selectedMember]));
			}
		}
	}
	
	echo "<h3>Permissions Updated</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"1; url=manageWebsite.php\">";
	
	require "html_footer.txt";
?>
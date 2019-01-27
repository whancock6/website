<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isTreasurer]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
?>

<?php
   	$query = $db->prepare("DELETE FROM LineItem WHERE lineItemID=:lineItemID");
	$query->execute(array('lineItemID'=>$_POST[lineItemID]));
    
	echo "<h3>Line Item Deleted</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageLineItems.php\">";
?>

<?php require "html_footer.txt"; ?>
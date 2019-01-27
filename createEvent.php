<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isEventAdmin]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	if($_POST[isBonus] == 'on') {
		$bonus = 1;
	} else {
		$bonus = 0;
	}
	
	if($_POST[isFamilyEvent] == 'on') {
		$family = 1;
	} else {
		$family = 0;
	}
	
	$query = $db->prepare("INSERT INTO Event (eventName, dateYear, dateMonth, dateDay, pointValue, isBonus, isFamilyEvent, type) VALUES (:eventName, :dateYear, :dateMonth, :dateDay, :pointValue, :bonus, :family, :type)");
	$query->execute(array('eventName'=>$_POST[eventName], 'dateYear'=>$_POST[dateYear], 'dateMonth'=>$_POST[dateMonth], 'dateDay'=>$_POST[dateDay], 'pointValue'=>$_POST[pointValue], 'bonus'=>$bonus, 'family'=>$family, 'type'=>$_POST[type]));

	echo "<h3>Event Created</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=editEvents.php\">";

	require "html_footer.txt";
?>
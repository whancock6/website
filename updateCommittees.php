<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isVP]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	$selectedCommittee = $_POST[selectedCommittee];
	$selectedYear = $_POST[selectedYear];

	foreach ($_POST[SourceSelect] AS $tempMemberID) {
		$query = $db->prepare("SELECT * FROM OnCommittee WHERE memberID = :tempMemberID AND committeeID = :selectedCommittee AND year = :selectedYear");
		$query->execute(array('tempMemberID'=>$tempMemberID, 'selectedCommittee'=>$selectedCommittee, 'selectedYear'=>$selectedYear));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		$num_results = $query->rowCount();
		if($num_results==1){
			$query2 = $db->prepare("DELETE FROM OnCommittee WHERE memberID = :tempMemberID AND committeeID = :selectedCommittee AND year = :selectedYear");
			$query2->execute(array('tempMemberID'=>$tempMemberID, 'selectedCommittee'=>$selectedCommittee, 'selectedYear'=>$selectedYear));
		} else { }
	}
	
	foreach ($_POST[DestinationSelect] AS $tempMemberID) {
		$query = $db->prepare("SELECT * FROM OnCommittee WHERE memberID = :tempMemberID AND committeeID = :selectedCommittee AND year = :selectedYear");
		$query->execute(array('tempMemberID'=>$tempMemberID, 'selectedCommittee'=>$selectedCommittee, 'selectedYear'=>$selectedYear));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		$num_results = $query->rowCount();
		if($num_results==0){
			$query2 = $db->prepare("INSERT INTO OnCommittee (memberID, committeeID, year) VALUES (:tempMemberID, :selectedCommittee, :selectedYear)");
			$query2->execute(array('tempMemberID'=>$tempMemberID, 'selectedCommittee'=>$selectedCommittee, 'selectedYear'=>$selectedYear));
		} else { }
	}

	echo "<h3>Committee Updated</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageCommittees.php?selectedCommittee=".$selectedCommittee."&selectedYear=".$selectedYear."\">";
	
	require "html_footer.txt"; 
?>
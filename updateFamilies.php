<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isVP]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	$family1name = $_POST[family1name];
	$family2name = $_POST[family2name];
	$family3name = $_POST[family3name];
	$family4name = $_POST[family4name];
	
	$query1 = $db->prepare("UPDATE Family SET familyName=:family1name WHERE familyID=1");
	$query1->execute(array('family1name'=>$family1name));
	$query2 = $db->prepare("UPDATE Family SET familyName=:family2name WHERE familyID=2");
	$query2->execute(array('family2name'=>$family2name));
	$query3 = $db->prepare("UPDATE Family SET familyName=:family3name WHERE familyID=3");
	$query3->execute(array('family3name'=>$family3name));
	$query4 = $db->prepare("UPDATE Family SET familyName=:family4name WHERE familyID=4");
	$query4->execute(array('family4name'=>$family4name));

	foreach ($_POST[SourceSelect] AS $tempMemberID) {
		$query = $db->prepare("UPDATE Member SET memFamilyID = NULL WHERE memberID = :tempMemberID");
		$query->execute(array('tempMemberID'=>$tempMemberID));
	}
	foreach ($_POST[Family1Select] AS $tempMemberID) {
		$query = $db->prepare("UPDATE Member SET memFamilyID = 1 WHERE memberID = :tempMemberID");
		$query->execute(array('tempMemberID'=>$tempMemberID));
	}	
	foreach ($_POST[Family2Select] AS $tempMemberID) {
		$query = $db->prepare("UPDATE Member SET memFamilyID = 2 WHERE memberID = :tempMemberID");
		$query->execute(array('tempMemberID'=>$tempMemberID));
	}	
	foreach ($_POST[Family3Select] AS $tempMemberID) {
		$query = $db->prepare("UPDATE Member SET memFamilyID = 3 WHERE memberID = :tempMemberID");
		$query->execute(array('tempMemberID'=>$tempMemberID));
	}
	foreach ($_POST[Family4Select] AS $tempMemberID) {
		$query = $db->prepare("UPDATE Member SET memFamilyID = 4 WHERE memberID = :tempMemberID");
		$query->execute(array('tempMemberID'=>$tempMemberID));
	}
	
	// CALCULATE ALL FAMILIES' TOTAL POINTS
	//-------------------------------------

	$resultFam = $db->query("SELECT familyID FROM Family");
		$resultFam->setFetchMode(PDO::FETCH_ASSOC);
	         
	while($rowFam = $resultFam->fetch()) {
	
	    $tempFamilyID = $rowFam[familyID];
	    
	    $famnum = 0;
	    
		$query = $db->prepare("SELECT SUM(points) AS pts FROM 
								(SELECT SUM(pointValue) AS points FROM Member JOIN (AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID) ON Member.memberID = AttendsEvent.memberID WHERE Member.memFamilyID = :tempFamilyID AND (Member.status != 'alumni')
								UNION ALL
								SELECT SUM(pointValue) FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE AttendsEvent.familyID = :tempFamilyID AND AttendsEvent.memberID IS NULL) subquery");
		$query->execute(array('tempFamilyID'=>$tempFamilyID));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		$famnum = $row[pts];
					
	// SET ALL FAMILIES' TOTAL POINTS IN DATABASE
	// ------------------------------------------
	
		$query2 = $db->prepare("UPDATE Family SET familyPoints = :famnum WHERE familyID = :tempFamilyID");
		$query2->execute(array('famnum'=>$famnum, 'tempFamilyID'=>$tempFamilyID));
	
	}

	echo "<h3>Families Updated</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=editFamilies.php\">";

	require "html_footer.txt"; 
?>
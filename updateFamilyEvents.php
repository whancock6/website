<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	if(isset($_POST[update])) {
		$query = $db->prepare("INSERT INTO AttendsEvent (familyID, eventID) VALUES (:family, :event)");
		$query->execute(array('family'=>$_POST[family], 'event'=>$_POST[event]));
	} elseif(isset($_POST[remove])) {
		$query = $db->prepare("DELETE FROM AttendsEvent WHERE familyID=:family AND eventID=:event");
		$query->execute(array('family'=>$_POST[family], 'event'=>$_POST[event]));
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
?>

<h3>Family Events Updated</h3>
<meta http-equiv="refresh" content="2; url=familyEvents.php">

<?php require "html_footer.txt"; ?>
<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	$query_bound = $_POST[query_bound];
	
	if($query_bound == 'recent'){
	    $today = getdate();
	    $currentday = $today[mday];
	    $currentmonth = $today[mon];
	    $currentyear = $today[year];
	    $query = $db->query("SELECT * FROM Event WHERE isFamilyEvent = '0' AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear ),'%m/%d/%Y') <= STR_TO_DATE(CONCAT($currentmonth,'/',$currentday,'/',$currentyear ),'%m/%d/%Y') ORDER BY dateMonth DESC, dateDay DESC, eventName LIMIT 0, 10");
	    	$query->setFetchMode(PDO::FETCH_ASSOC);
	} elseif($query_bound == 'all') {
	    $query = $db->query("SELECT * FROM Event");
	    	$query->setFetchMode(PDO::FETCH_ASSOC);
	} else {
	    $query = $db->prepare("SELECT * FROM Event WHERE dateMonth = :query_bound");
	    $query->execute(array('query_bound'=>$query_bound));
	    	$query->setFetchMode(PDO::FETCH_ASSOC);
	}

	while($row = $query->fetch())  {
		$tempEventID = $row[eventID];
		$query2 = $db->prepare("SELECT * FROM AttendsEvent WHERE eventID = :tempEventID AND memberID = :memberID");
		$query2->execute(array('tempEventID'=>$tempEventID, 'memberID'=>$memberID));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		$num_results = $query2->rowCount();
		if($_POST[$tempEventID] == 'on') {
			if($num_results == 0) {
				$query3 = $db->prepare("INSERT INTO AttendsEvent (memberID, familyID, eventID) VALUES (:memberID, :memFamilyID, :tempEventID)");
				$query3->execute(array('memberID'=>$memberID, 'memFamilyID'=>$memFamilyID, 'tempEventID'=>$tempEventID));
			} else { }
		} else {
			if($num_results == 1) {
				$query3 = $db->prepare("DELETE FROM AttendsEvent WHERE eventID = :tempEventID AND memberID = :memberID");
				$query3->execute(array('memberID'=>$memberID, 'tempEventID'=>$tempEventID));
			} else { }
		}
    }
     
// CALCULATE MEMBER POINT INFORMATION
//-----------------------------------

	$query = $db->prepare("SELECT pointValue, type FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE memberID = :memberID");
	$query->execute(array('memberID'=>$memberID));
		$query->setFetchMode(PDO::FETCH_ASSOC);
	
	$num = 0;
	$mandatory = 0;
	$sports = 0;
	$social = 0;
	$work = 0;
	
	while($row = $query->fetch()) {
		if($row[type]=='mandatory'){
			$mandatory++;
			$num += $row[pointValue];
		}
		else if($row[type]=='sports'){
			$sports++;
			$num += $row[pointValue];
		}
		else if($row[type]=='social'){
			$social++;
			$num += $row[pointValue];
		}
		else if($row[type]=='work'){
			$work++;
			$num += $row[pointValue];
		}		
	}
                    
// SET MEMBERS POINT INFORMATION IN DATABASE
//------------------------------------------

	$query = $db->prepare("UPDATE Member SET memberPoints = :num, mandatoryEventCount = :mandatory, sportsEventCount = :sports, socialEventCount = :social, workEventCount = :work WHERE memberID = :memberID");
	$query->execute(array('num'=>$num, 'mandatory'=>$mandatory, 'sports'=>$sports, 'social'=>$social, 'work'=>$work, 'memberID'=>$memberID));
	$_SESSION[memberPoints] = $num;
	$_SESSION[mandatoryEventCount] = $mandatory;
	$_SESSION[sportsEventCount] = $sports;
	$_SESSION[socialEventCount] = $social;
	$_SESSION[workEventCount] = $work;
		
// CALCULATE AND UPDATE TOTAL FAMILY POINTS
//-----------------------------------------

	$resultFam = $db->prepare("SELECT * FROM Member WHERE memberID = :memberID");
	$resultFam->execute(array('memberID'=>$memberID));
		$resultFam->setFetchMode(PDO::FETCH_ASSOC);
	
	$row = $resultFam->fetch();
	if(isset($row[memFamilyID])){
	    
	    $famnum = 0;

		$query2 = $db->prepare("SELECT SUM(points) AS pts FROM 
								(SELECT SUM(pointValue) AS points FROM Member JOIN (AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID) ON Member.memberID = AttendsEvent.memberID WHERE Member.memFamilyID = :tempFamilyID AND (Member.status != 'alumni')
								UNION ALL
								SELECT SUM(pointValue) FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE AttendsEvent.familyID = :tempFamilyID AND AttendsEvent.memberID IS NULL) subquery");
		$query2->execute(array('tempFamilyID'=>$row[memFamilyID]));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		$row2 = $query2->fetch();
		$famnum = $row2[pts];

// SET FAMILY POINT INFORMATION IN DATABASE
//-----------------------------------------

		$query3 = $db->prepare("UPDATE Family SET familyPoints = :famnum WHERE familyID = :tempFamilyID");
		$query3->execute(array('famnum'=>$famnum, 'tempFamilyID'=>$row[memFamilyID]));

	} else {} 
?>

<h3>Points Updated</h3>
<meta http-equiv="refresh" content="2; url=points.php">

<?php require "html_footer.txt"; ?>
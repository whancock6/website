<?php

ob_start();
$db_username="reck";
$db_password="burdell";

$dsn = 'mysql:host=mysql.localhost;dbname=reck_club';
$db= new PDO($dsn, $db_username, $db_password);
session_start();
$userId = $_SESSION[memberID];
$memFamilyId = $_SESSION[memFamilyID];

$month=$_POST[month];
	$stmt= $db->prepare("SELECT * FROM Event WHERE dateMonth = :month");
	$stmt->bindValue("month",$month, PDO::PARAM_STR);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$tempEventID = $row[eventID];
		$eventLookup= $db->prepare("SELECT * FROM AttendsEvent WHERE eventID =:event AND memberID =:user");
		$eventLookup->bindValue("event",$tempEventID, PDO::PARAM_STR);
		$eventLookup->bindValue("user",$userId, PDO::PARAM_STR);
		$eventLookup->execute();
	   if($_POST[$tempEventID] == 'on') {
			if($eventLookup->rowCount() == 0) {
				$eventLookup= $db->prepare("INSERT INTO AttendsEvent (memberID, familyID, eventID) VALUES (:user, :fam, :temp)");
				$eventLookup->bindValue("user",$userId, PDO::PARAM_STR);
				$eventLookup->bindValue("fam",$memFamilyId, PDO::PARAM_STR);
				$eventLookup->bindValue("temp",$tempEventID, PDO::PARAM_STR);
				$eventLookup->execute();
			} else { }
	   } 
	   else {
			if($eventLookup->rowCount() == 1) {
				$eventLookup= $db->prepare("DELETE FROM AttendsEvent WHERE eventID = :event AND memberID = :user");
				$eventLookup->bindValue("event",$tempEventID, PDO::PARAM_STR);
				$eventLookup->bindValue("user",$userId, PDO::PARAM_STR);
				$eventLookup->execute();
			} else { }
	   }
	}

// CALCULATE MEMBER POINT INFORMATION
//-----------------------------------
	
	$stmt= $db->prepare("SELECT pointValue, type FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE memberID =:user");
	$stmt->bindValue("user",$userId, PDO::PARAM_STR);
	$stmt->execute();
	$num = 0;
	$mandatory = 0;
	$sports = 0;
	$social = 0;
	$work = 0;
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
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

	$stmt= $db->prepare("UPDATE Member SET memberPoints = :num, mandatoryEventCount = :mand, sportsEventCount = :sports, socialEventCount = :social, workEventCount = :work WHERE memberID = :user");
	$stmt->bindValue("num",$num, PDO::PARAM_STR);
	$stmt->bindValue("mand",$mandatory, PDO::PARAM_STR);
	$stmt->bindValue("sports",$sports, PDO::PARAM_STR);
	$stmt->bindValue("social",$social, PDO::PARAM_STR);
	$stmt->bindValue("work",$work, PDO::PARAM_STR);
	$stmt->bindValue("user",$userId, PDO::PARAM_STR);
	$stmt->execute();

// CALCULATE AND UPDATE TOTAL FAMILY POINTS
//-----------------------------------------
	
	$famnum = 0;
	$famstmt= $db->prepare("SELECT SUM(pointValue) AS pts FROM Member JOIN (AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID) ON Member.memberID = AttendsEvent.memberID WHERE Member.memFamilyID = :fam AND 
	(Member.status != 'alumni')");
	$famstmt->bindValue("fam",$memFamilyId, PDO::PARAM_STR);
	$famstmt->execute();
			
	while($row1 = $famstmt->fetch(PDO::FETCH_ASSOC)){
		$famnum += $row1[pts];
	 }
		$famstmt= $db->prepare("SELECT SUM(pointValue) AS pts FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE AttendsEvent.familyID = :fam AND AttendsEvent.memberID IS NULL");
		$famstmt->bindValue("fam",$memFamilyId, PDO::PARAM_STR);
		$famstmt->execute();
	while($row2 = $famstmt->fetch(PDO::FETCH_ASSOC)){
		$famnum += $row2[pts];
	}	
	
// SET FAMILY POINT INFORMATION IN DATABASE
//-----------------------------------------
	$famstmt= $db->prepare("UPDATE Family SET familyPoints = :famNum WHERE familyID = :fam");
	$famstmt->bindValue("famNum",$famnum, PDO::PARAM_STR);
	$famstmt->bindValue("fam",$memFamilyId, PDO::PARAM_STR);
	$famstmt->execute();

?>
<meta http-equiv="refresh" content="2; url=mobile.php">
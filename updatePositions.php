<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isVP]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	$today = getdate();	
	$currentyear = $today["year"];	
	$stopyear = $_POST[stopYear];

	if(isset($_POST[add]) || isset($_POST[remove])) {
		if($_POST[selectedPosition] != "none" && $_POST[selectedMember] != "none" && $_POST[selectedYear] != "none") {
			$query = $db->prepare("SELECT * FROM HoldsPosition WHERE memberID=:memberID AND positionID=:positionID AND year=:year");
			$query->execute(array('memberID'=>$_POST[selectedMember], 'positionID'=>$_POST[selectedPosition], 'year'=>$_POST[selectedYear]));
				$query->setFetchMode(PDO::FETCH_ASSOC);
			$cnt = $query->rowCount();
			if(isset($_POST[add])) {
				if($cnt == 0) {
					$query2 = $db->prepare("INSERT INTO HoldsPosition (memberID, positionID, year) VALUES (:memberID, :positionID, :year)");
					$query2->execute(array('memberID'=>$_POST[selectedMember], 'positionID'=>$_POST[selectedPosition], 'year'=>$_POST[selectedYear]));
				} else {}
			} elseif(isset($_POST[remove])) {
				if($cnt > 0) {
					$query2 = $db->prepare("DELETE FROM HoldsPosition WHERE memberID=:memberID AND positionID=:positionID AND year=:year");
					$query2->execute(array('memberID'=>$_POST[selectedMember], 'positionID'=>$_POST[selectedPosition], 'year'=>$_POST[selectedYear]));
				} else {}
			}
		}
	} elseif(isset($_POST[position])) {
		$tempyear = $currentyear;
		while($tempyear >= $stopyear) {
			$query = $db->prepare("DELETE FROM HoldsPosition WHERE positionID=:positionID AND year=:year");
			$query->execute(array('positionID'=>$_POST[selectedPosition], 'year'=>$tempyear));
			foreach($_POST[$tempyear] as $m) {
				if($m != "none") {
					$query2 = $db->prepare("INSERT INTO HoldsPosition (memberID, positionID, year) VALUES (:memberID, :positionID, :year)");
					$query2->execute(array('memberID'=>$m, 'positionID'=>$_POST[selectedPosition], 'year'=>$tempyear));
				}
			}
			$tempyear = $tempyear - 1;
		}
	} elseif(isset($_POST[year])) {
		$query = $db->query("SELECT positionID FROM Position");
			$query->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $query->fetch()) {
			$p = $row[positionID];
			$query2 = $db->prepare("DELETE FROM HoldsPosition WHERE positionID=:positionID AND year=:year");
			$query2->execute(array('positionID'=>$p, 'year'=>$_POST[selectedYear]));
			foreach($_POST[$p] as $m) {
				if($m != "none") {
					$query3 = $db->prepare("INSERT INTO HoldsPosition (memberID, positionID, year) VALUES (:memberID, :positionID, :year)");
					$query3->execute(array('memberID'=>$m, 'positionID'=>$p, 'year'=>$_POST[selectedYear]));
				}
			}
		}
	}
	
	$query = $db->query("UPDATE Member SET isVP=0, isSecretary=0, isTreasurer=0");
	
	$query = $db->prepare("UPDATE Member SET isVP=1 WHERE memberID IN 
							(SELECT HoldsPosition.memberID FROM HoldsPosition INNER JOIN Position ON HoldsPosition.positionID = Position.positionID 
							WHERE Position.positionName = 'Vice President' AND HoldsPosition.year = :year)");
	$query->execute(array('year'=>$currentyear));
	
	$query = $db->prepare("UPDATE Member SET isSecretary=1 WHERE memberID IN 
							(SELECT HoldsPosition.memberID FROM HoldsPosition INNER JOIN Position ON HoldsPosition.positionID = Position.positionID 
							WHERE Position.positionName = 'Secretary' AND HoldsPosition.year = :year)");
	$query->execute(array('year'=>$currentyear));
	
	$query = $db->prepare("UPDATE Member SET isTreasurer=1 WHERE memberID IN 
							(SELECT HoldsPosition.memberID FROM HoldsPosition INNER JOIN Position ON HoldsPosition.positionID = Position.positionID 
							WHERE Position.positionName = 'Treasurer' AND HoldsPosition.year = :year)");
	$query->execute(array('year'=>$currentyear));
	
	if(isset($_POST[pagePosition]) && $_POST[pagePosition] != "none") {
		echo "<h3>Positions Updated</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=managePositions.php?selectedPosition=".$_POST[pagePosition]."\">";
	} elseif(isset($_POST[pageYear]) && $_POST[pageYear] != "none") {
		echo "<h3>Positions Updated</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=managePositions.php?selectedYear=".$_POST[pageYear]."\">";
	} else {
		echo "<h3>Positions Updated</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=managePositions.php\">";
	}
	
	require "html_footer.txt";
?>
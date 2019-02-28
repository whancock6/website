<?php
	require "logged_in_check.php";
	require "set_session_vars_short.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	$month=$_POST[dateMonth];
	if($month=='01'){$monthName='January';}
	if($month=='02'){$monthName='February';}
	if($month=='03'){$monthName='March';}
	if($month=='04'){$monthName='April';}
	if($month=='05'){$monthName='May';}
	if($month=='06'){$monthName='June';}
	if($month=='07'){$monthName='July';}
	if($month=='08'){$monthName='August';}
	if($month=='09'){$monthName='September';}
	if($month=='10'){$monthName='October';}
	if($month=='11'){$monthName='November';}
	if($month=='12'){$monthName='December';}
	
	if($month=='all'){
		$query = $db->query("SELECT * FROM Event WHERE isFamilyEvent = '0' ORDER BY dateMonth, dateDay, eventName");
			$query->setFetchMode(PDO::FETCH_ASSOC);
	} else {
		$query = $db->prepare("SELECT * FROM Event WHERE isFamilyEvent = '0' AND dateMonth = :month ORDER BY dateMonth, dateDay, eventName");
		$query->execute(array('month'=>$month));
			$query->setFetchMode(PDO::FETCH_ASSOC);
	}
	
	$num_results = $query->rowCount();
	if($num_results == 0){
		if($month=='all'){
		    echo "<div align=\"center\"><a href=\"points.php\">Back to Points</a><br><br><br><br><br>";
		    echo "There are currently no events.</div>";
		} else {
		    echo "<div align=\"center\"><a href=\"points.php\">Back to Points</a><br><br><br><br><br>";
		    echo "There are currently no events for the month of ".$monthName.".</div>";					
		}
	} else {
		if($month=='all') {
            echo "<h3><u>All Events</u></h3>";
            echo "<div align=\"center\"><a href=\"points.php\">Back to Points</a><br><br></div>";
		} else {
			echo "<h3><u>".$monthName." Events</u></h3>";
			echo "<div align=\"center\"><a href=\"points.php\">Back to Points</a><br><br></div>";
		}
	


	// CREATE FORM FOR UPDATING USER'S POINTS
	//---------------------------------------------------------

	echo "<form id=\"updatePoints\" name=\"updatePoints\" action=\"updatePoints.php\" method=\"POST\">\n";
	echo "<table align=\"center\">\n";
	echo "<tr bgcolor=\"#b3a369\"><th>&nbsp;</th><th width=350>Event</th><th width=100>Date</th><th>Points</th></tr>\n";

	$counter = 0;
	while($row = $query->fetch())  {
		$counter = $counter + 1;
		$tempEventID = $row[eventID];
		$query2 = $db->prepare("SELECT * FROM AttendsEvent WHERE eventID = :tempEventID AND memberID = :memberID");
		$query2->execute(array('tempEventID'=>$tempEventID, 'memberID'=>$memberID));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		$num_results2 = $query2->rowCount();
		echo "<tr";
		if($num_results2 == 1) {
		             echo " bgcolor=\"#b3a369\"";
		} else { }
		echo "><td><input type=\"checkbox\" name=\"";
		echo $row[eventID];
		echo "\" ";
		if($num_results2 == 1) {
		             echo " CHECKED";
		} else { }
		echo "></td>";
		echo "<td>".$row[eventName];
		if($row[isBonus] == 1) {
		              echo " (BONUS)";
		} else { }
		echo"</td>";
		echo "<td>".$row[dateMonth]."-".$row[dateDay]."-".$row[dateYear]."</td>";
		echo "<td>".$row[pointValue]."</td></tr>";
		if (($counter % 20 == 0) && ($num_results - $counter >= 10)) {
			echo "<tr><td colspan=\"4\"><input type=\"submit\" form=\"updatePoints\" value=\"Update\"></td></tr>\n";
		}
	}
	echo "<tr><td colspan=\"4\"><input type=\"submit\" form=\"updatePoints\" value=\"Update\"></td></tr>\n";
	
	echo "</table>\n";
	if($month=='all') {
		echo "<input type=\"hidden\" name=\"query_bound\" value=\"all\">";
	} else {
		echo "<input type=\"hidden\" name=\"query_bound\" value=\"".$month."\">";
	}
	echo "</form><br><br>";
	}               
?>

<?php require "html_footer.txt"; ?>
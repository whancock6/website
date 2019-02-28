<?php
	require "logged_in_check.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	echo "<br />";
	
	$query = $db->query("SELECT * FROM (AttendsEvent RIGHT OUTER JOIN Event ON AttendsEvent.eventID = Event.eventID) LEFT OUTER JOIN Family ON AttendsEvent.familyID = Family.familyID  WHERE isFamilyEvent = '1' ORDER BY dateMonth, dateDay, eventName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$num_results = $query->rowCount();
	if($num_results == 0){
		echo "<div align=\"center\"><a href=\"families.php\">Back to Families</a><br><br><br><br><br>";
		echo "There are currently no family events</div>";
	} else {
		echo "<h3>Family Events</h3>";
		echo "<div align=\"center\"><a href=\"families.php\">Back to Families</a><br/><br/></div>";
		echo "<br>";

        if($_SESSION[isAdmin]==1) {
        	$query2 = $db->query("SELECT familyID, familyName FROM Family");
        		$query->setFetchMode(PDO::FETCH_ASSOC);
        	$query3 = $db->query("SELECT * FROM Event WHERE isFamilyEvent = '1' ORDER BY dateMonth, dateDay, eventName");
			echo "<form action=\"updateFamilyEvents.php\" method=\"POST\">\n";
			echo "<table align=\"center\">\n";
			echo "<tr bgcolor=\"#b3a369\"><th width=300>Event</th><th width=200>Family</th><th>Add</th><th>Remove</th></tr>";
			echo "<tr><td><select name=\"event\">";
			echo "<option value=\"none\">---</option>";
			while($row = $query3->fetch()) {
				echo "<option value=".$row[eventID].">".$row[eventName]." (".$row[dateMonth]."-".$row[dateDay].")</option>";
			}
			echo "</select></td><td><select name=\"family\">";
				echo "<option value=\"none\">---</option>";
			while($row = $query2->fetch()) {
				echo "<option value=".$row[familyID].">".$row[familyName]."</option>";
			}
			echo "</select></td><td>";
			echo "<input type=\"submit\" name=\"update\" value=\"Add\">";
			echo "</td><td>";
			echo "<input type=\"submit\" name=\"remove\" value=\"Remove\">";
			echo "</td></tr>";
			echo "</table>\n";
			echo "</form><br><br>";
        }

		echo "<table align=\"center\">\n";
		echo "<tr bgcolor=\"#b3a369\"><th width=300>Event</th><th width=100>Date</th><th>Points</th><th>Family</th></tr>\n";
	
		while($row2 = $query->fetch())  {
			echo "<td>".$row2[eventName];
			if($row2[isBonus] == 1) {
				echo " (BONUS)";
			} else { }
			echo"</td>";
			echo "<td>".$row2[dateMonth]."-".$row2[dateDay]."-".$row2[dateYear]."</td>";
			echo "<td>".$row2[pointValue]."</td><td>".$row2[familyName]."</td></tr>";
		}
	
		echo "</table>\n";
	}
?>
<br/><br/><br/><br/><br/>
<?php require "html_footer.txt"; ?>
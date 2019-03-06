<?php
	require "logged_in_check.php";
	require "database_connect.php";
	require "set_session_vars_full.php";
	$pageTitle = "Family Events";
	require "partials/head.php";
	?>
<html>
<body>
<?php require "partials/header.php" ?>
<div class="container mb-3">
<h2 class="mb-3">Family Events</h2>
<?php
	
	$query = $db->query("SELECT * FROM (AttendsEvent RIGHT OUTER JOIN Event ON AttendsEvent.eventID = Event.eventID) LEFT OUTER JOIN Family ON AttendsEvent.familyID = Family.familyID  WHERE isFamilyEvent = '1' ORDER BY dateMonth, dateDay, eventName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$num_results = $query->rowCount();
	if($num_results == 0){
		echo "<p>There are currently no family events.</p>";
	} else {
        if($_SESSION[isAdmin]==1) {
        	$query2 = $db->query("SELECT familyID, familyName FROM Family");
        		$query->setFetchMode(PDO::FETCH_ASSOC);
        	$query3 = $db->query("SELECT * FROM Event WHERE isFamilyEvent = '1' ORDER BY dateMonth, dateDay, eventName");
			echo "<form action=\"updateFamilyEvents.php\" method=\"POST\">\n";
            echo "<h6><strong>Assign an Event to a Family:</strong></h6>";
            echo "
<div class=\"form-row\">
    <div class=\"form-group col-md-4\">
      <label for=\"event\">Event</label>
      <select class='form-control custom-select' name=\"event\">";
            echo "<option value=\"none\">---</option>";
            while($row = $query3->fetch()) {
                echo "<option value=".$row[eventID].">".$row[eventName]." (".$row[dateMonth]."-".$row[dateDay].")</option>";
			}
      echo "</select>
    </div>
    <div class=\"form-group col-md-4\">
      <label for=\"inputState\">Family</label>
      <select class='form-control custom-select' name=\"family\">";
            echo "<option value=\"none\">---</option>";
            while($row = $query2->fetch()) {
				echo "<option value=".$row[familyID].">".$row[familyName]."</option>";
			}
      echo "</select>
    </div>
    <div class=\"form-group col-md-2\">
      <label for=\"update\">Add</label>
      <input class='form-control btn btn-primary' type=\"submit\" name=\"update\" value=\"Add\">
    </div>
    <div class=\"form-group col-md-2\">
      <label for=\"remove\">Remove</label>
      <input class='form-control btn btn-secondary' type=\"submit\" name=\"remove\" value=\"Remove\">
    </div>
  </div>";
			echo "</form>";
        }

        echo "<div class='row'>";
        echo "<div class='col-12'>";
        echo "<h6><strong>All Family Events</strong></h6>";
        echo "<table class=\"table table-responsive table-hover table-sm\">";
        echo "<thead>";
        echo "<td scope='col' align='left'><b>Event</b></td><td scope='col' align='center'><b>Date</b></td><td scope='col' align='center'><b>Family</b></td><td scope='col' align='right'><b>Points</b></td>";
        echo "</thead>";
        echo "<tbody>";
        while ($row2 = $query->fetch())  {
            echo "<tr>";
			echo "<td align='left'>".$row2[eventName];
			if($row2[isBonus] == 1) {
				echo " (BONUS)";
			} else { }
			echo"</td>";
			echo "<td align='center'>".$row2[dateMonth]."/".$row2[dateDay]."/".$row2[dateYear]."</td>";
			echo "<td align='center'>". ((strlen($row2[familyName]) > 0) ? $row2[familyName] : '<em class="text-muted">Family not assigned</em>') ."</td><td align='right'>".$row2[pointValue]."</td>";
			echo "</tr>";
		}
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
	}
?>
</div>
<?php require "partials/footer.php" ?>
<?php require "partials/scripts.php" ?>
</body>
</html>
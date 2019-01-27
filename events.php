<?php	
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	
	require "header.php";

	$month=$_POST[dateMonth];
	if($month==''){
		$month=date(m);
	}
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
?>
	<div class="row">
		<div  class="six columns">
			<h3><?php echo $monthName; ?> Events</h3>
		</div>
		<div class="three columns offset-by-seven">
			<div class="selectdiv right" >  
				<form id="monthSelect" action="events.php" method="post">
					<select name="dateMonth" class="selectboxdiv">
						<option value="01" <?PHP if($month=='01') echo "selected";?>>January</option>
							<option value="02" <?PHP if($month=='02') echo "selected";?>>February</option>
							<option value="03" <?PHP if($month=='03') echo "selected";?>>March</option>
							<option value="04" <?PHP if($month=='04') echo "selected";?>>April</option>
							<option value="05" <?PHP if($month=='05') echo "selected";?>>May</option>
							<option value="06" <?PHP if($month=='06') echo "selected";?>>June</option>
							<option value="07" <?PHP if($month=='07') echo "selected";?>>July</option>
							<option value="08" <?PHP if($month=='08') echo "selected";?>>August</option>
							<option value="09" <?PHP if($month=='09') echo "selected";?>>September</option>
							<option value="10" <?PHP if($month=='10') echo "selected";?>>October</option>
							<option value="11" <?PHP if($month=='11') echo "selected";?>>November</option>
							<option value="12" <?PHP if($month=='12') echo "selected";?>>December</option>
							<option value="all">All Events</option>
					</select>
				</form>
				<div class="out"></div>
			</div>
		</div>
	</div>
	<div id="upcoming-events" class="row">
			<div class="events-list">
				<form action="updatePoints.php" method="POST">
				<div class="sixteen columns">
						<ul>
							<li>
								<div class="checkbox"></div>
								<div class="date header">Date</div><div class="event header">Event</div><div class="points header">Points</div>
							</li>
<?php
	if($num_results == 0){
		if($month=='all'){
		    echo "There are currently no events.</div>";
		} else {
		    echo "There are currently no events for the month of ".$monthName.".</div>";					
		}
	} else {
	
	// CREATE FORM FOR UPDATING USER'S POINTS
	//---------------------------------------------------------

	echo "<form id=\"updatePoints\" method=\"POST\">\n";

	$counter = 0;
	while($row = $query->fetch())  {
		$counter = $counter + 1;
		$tempEventID = $row[eventID];
		$query2 = $db->prepare("SELECT * FROM AttendsEvent WHERE eventID = :tempEventID AND memberID = :memberID");
		$query2->execute(array('tempEventID'=>$tempEventID, 'memberID'=>$memberID));
		$query2->setFetchMode(PDO::FETCH_ASSOC);
		$num_results2 = $query2->rowCount();
		echo "<li><div class=\"checkbox\"><div class=\"squaredFour\"><input id=\"event".$count."\" type=\"checkbox\" name=\"";
        echo $row[eventID];
        echo "\" ";
        if($num_results2 == 1) {
                       echo " CHECKED";
        } else { }
        echo "><label for=\"event".$count."\"></label></div></div>";
        echo "<div class=\"date\">".$row[dateMonth]."-".$row[dateDay]."</div><div class=\"event\">".$row[eventName];
        if($row[isBonus] == 1) {
                        echo " (BONUS)";
        }
        echo "</div><div class=\"points\">".$row[pointValue]."</div></li>";
        $count++;
	}
	
	if($month=='all') {
		echo "<input type=\"hidden\" name=\"query_bound\" value=\"all\">";
	} else {
		echo "<input type=\"hidden\" name=\"query_bound\" value=\"".$month."\">";
	}
	}               
?>
</ul>
					</div>
					<div class="five columns offset-by-eleven clearfix">
						<div class="right">
							<input type="submit">
						</div>
					</div>
				</form>
			</div>
		</div> 


	</div><!-- container -->


<!-- End Document
================================================== -->
<script>
	$(document).ready(function(){
		var changeFlag=0;
		$("select").change(function () { 
		   var str = ""; 
		   str = $(this).find(":selected").text(); 
		   $(".out").text(str); 
		   console.log("yes");
		   if(changeFlag==1){
		   	$('#monthSelect').submit();
		   }
		   changeFlag=1;
		}).trigger('change'); 
	});
</script>
</body>
</html>
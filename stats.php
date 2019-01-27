<?php
	require "logged_in_check.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<?php require "html_header_end.txt"; ?>
	
	<div align="center">
	<a href="rankings.php">Back to Individual Rankings</a><br/><br/>
	
	</div><br/>
	
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawCharts);
      function drawCharts(){
		drawChart1();
		drawChart2();
	  }
	  function drawChart1() {
		  // Create and populate the data table.
		  var data = google.visualization.arrayToDataTable([
			['Name','Total Points','Average'],
				<?php

	// CREATE TABLE OF INDIVIDUAL RANKINGS
	//---------------------------------------------------

	$query = $db->query("SELECT AVG(memberPoints) as AVRG FROM Member WHERE status IN ('probate', 'member')");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	$pointAVG = number_format($row[AVRG],2);
	
   	$query = $db->query("SELECT firstName, lastName, memberPoints, memberID FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName");
	$query->setFetchMode(PDO::FETCH_ASSOC);
	
	$count = 1;

	while($row = $query->fetch())
		{
		echo "['".$row[firstName]."', ".$row[memberPoints].",".$pointAVG."],";
		$count++;
		}
?>
			
			
		  ]);

		  // Create and draw the visualization.
		  new google.visualization.ComboChart(document.getElementById('chart1_div')).
			  draw(data,
				   {title:"Total Points Visualization",
					width:1000, height:400,
					legend: {position: 'none'},
					seriesType: "bars",
					series: {1: {type: "line"}},
					chartArea:{left:100,top:30,width:"100%",height:"75%"},
					hAxis: {title: "Recker"}}
					
			  );
		}
		function drawChart2() {
		  // Create and populate the data table.
		  var data = google.visualization.arrayToDataTable([
			['Name','Mandatory','Social','Sports','Work'],
				<?php

	// CREATE TABLE OF INDIVIDUAL RANKINGS
	//---------------------------------------------------

	
	
   	$query = $db->query("SELECT firstName, mandatoryEventCount, sportsEventCount, socialEventCount, workEventCount FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName");
	$query->setFetchMode(PDO::FETCH_ASSOC);
	
	$count = 1;

	while($row = $query->fetch())
		{
		echo "['".$row[firstName],"',";
		echo "".$row[mandatoryEventCount].", ".$row[socialEventCount].", ".$row[sportsEventCount].", ".$row[workEventCount]."],";
		$count++;
		}
?>
			
			
		  ]);

		  // Create and draw the visualization.
		  new google.visualization.ColumnChart(document.getElementById('chart2_div')).
			  draw(data,
				   {title:"Total Events Visualization",
					width:1000, height:400,
					isStacked:true,
					chartArea:{left:100,top:30, bottom:10,width:"100%",height:"75%"},
					colors:['#D0D0D0','#005ACE','#FFCB00','#149F3D'],
					hAxis: {title: "Recker"}}
					
			  );
		}
    </script>
	<img src="images/remember.png" />
	<h1>STATSCENTER</h1>
    <div id="chart1_div" style="width: 900px; height: 410px;"></div>
	<b>The points whores really screw with the average.</b>
	<h1>Event Breakdown</h1>
	<?php
	$query2 = $db->prepare("SELECT type FROM Event");
	$query2->setFetchMode(PDO::FETCH_ASSOC);
	
	$mandatory=0;
	$sports=0;
	$social=0;
	$work=0;
	$events=0;
	
	while($row = $query2->fetch()) {
		$events++;
		echo($events);
		if($row[type]=='mandatory'){
			$mandatory++;   
		}
		else if($row[type]=='sports'){
			$sports++;
		}
		else if($row[type]=='social'){
			$social++;
		}
		else if($row[type]=='work'){
			$work++;
		}
	}
	?>
	
	<!--<div>Event<?php echo($events);?></div>
	<div>Mandatory<?php echo($mandatory);?></div>
	<div>Sports<?php echo($sports);?></div>
	<div>Social<?php echo($social);?></div>
	<div>Work<?php echo($work);?></div>-->
	<div id="chart2_div" style="width: 900px; height: 500px;"></div>
	
<?php require "html_footer.txt"; ?>
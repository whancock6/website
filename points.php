<?php
	require "logged_in_check.php";
session_start();
	require "set_session_vars_full.php";
	require "database_connect.php";
	if($_SESSION['status']=="alumni"){
		print("<meta http-equiv=\"REFRESH\" content=\"0;url=history.php\">");
	}
	require "header.php";
?>
		<?php
			$eventCount = $mandatoryEventCount + $sportsEventCount + $socialEventCount + $workEventCount;
				
		//CALCULATE RANK
		//--------------
			
			$rank_query = $db->query("SELECT memberID, memberPoints FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName");
				$rank_query->setFetchMode(PDO::FETCH_ASSOC);

			$count1 = 0;

			while($row = $rank_query->fetch()) {
				$count1++;
				if($row[memberID] == $memberID) {
					$rank = $count1;
					$pts = $row[memberPoints];
				}
			}

		// SHOW USER'S TOTAL POINTS AND RANK
		//----------------------------------

		?>
		<div id="points-ribbon" class="row">
			<div class="one-third column points-block">
				<div class="value"><p><?php echo($pts); ?></p></div>
				<div class="label">Total Points </div>
			</div>
			<div class="one-third column points-block">
				<div class="value"><p><?php echo($rank); ?></p></div>
				<div class="label">Rank</div>
			</div>
			<div class="one-third column points-block">
				<div class="value"><p><?php echo($eventCount); ?></p></div>
				<div class="label">Events</div>
			</div>
		</div>
		<div id="rankings" class="row">
			<div id="top-5" class="eight columns">
				<h3>Top 5</h3>
				<ul>
					<?php 
                        
                        	$count = 1;

							$top5_query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName LIMIT 5");
								$top5_query->setFetchMode(PDO::FETCH_ASSOC);

                        	while($row = $top5_query->fetch()){
	                                	echo "<li><div class=\"ranking\">".$count."</div><div class=\"name\">".$row[firstName]." ".$row[lastName]."</div><div class=\"value\">".$row[memberPoints]."</div></li>";
										$count++;
                            }
                            
                        ?>
                     <li><a href="rankings.php">Complete Rankings</a></li>
				</ul>
			</div>
			<div id="family-rankings" class="eight columns">
				<h3>Family Rankings</h3>
				<ul>
					<?php
						$family_query = $db->query("SELECT familyName, familyPoints FROM Family ORDER BY familyPoints DESC, familyName");
							$family_query->setFetchMode(PDO::FETCH_ASSOC);

    					$var = 1;

                        while($row = $family_query->fetch()){
                                echo "<li><div class=\"ranking\">".$var."</div><div class=\"name\">".$row[familyName]."</div><div class=\"value\">".$row[familyPoints]."</div></li>";
                                $var++;							   
						}							
					?>
					<li><a href="families.php">Family Rankings</a></li>
				</ul>
			</div>
		</div>
		<div id="upcoming-events" class="row">
			<div  class="sixteen columns">
				<h3>Recent Events</h3>
			</div>
			<div class="events-list">
				<form action="updatePoints.php" method="POST">
				<div class="sixteen columns">
						<ul>
							<li>
								<div class="checkbox"></div>
								<div class="date header">Date</div><div class="event header">Event</div><div class="points header">Points</div>
							</li>
							<?php
				                $today = getdate();
				                $currentday = $today[mday];
				                $currentmonth = $today[mon];
				                $currentyear = $today[year];

								$events_query = $db->query("SELECT * FROM Event WHERE isFamilyEvent = '0' AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear ),'%m/%d/%Y') <= STR_TO_DATE(CONCAT($currentmonth,'/',$currentday,'/',$currentyear ),'%m/%d/%Y') ORDER BY dateMonth DESC, dateDay DESC, eventName LIMIT 0, 10");
									$events_query->setFetchMode(PDO::FETCH_ASSOC);
			                		
			                	$rowcount = $events_query->rowCount();
			                	$count = 1;

			                	if($rowcount==0){
			                		echo "There are currently no events.";
			                	} else {
				                	while($row = $events_query->fetch()){
				                          $tempEventID = $row[eventID];
										  $attends_query = $db->query("SELECT * FROM AttendsEvent WHERE eventID = $tempEventID AND memberID = $memberID");
											   $attends_query->setFetchMode(PDO::FETCH_ASSOC);
				                          $num_results3 = $attends_query->rowCount();
				                          
				                          echo "<li><div class=\"checkbox\"><div class=\"squaredFour\"><input id=\"event".$count."\" type=\"checkbox\" name=\"";
				                          echo $row[eventID];
				                          echo "\" ";
				                          if($num_results3 == 1) {
				                                         echo " CHECKED";
				                          } else { }
				                          echo "><label for=\"event".$count."\"></label></div></div>";
				                          echo "<div class=\"date\">".$row[dateMonth]."-".$row[dateDay]."</div><div class=\"event\">".$row[eventName];
				                          if($row[isBonus] == 1) {
				                                          echo " (BONUS)";
				                          } else { }
				                          echo"</td>";
				                          echo "</div><div class=\"points\">".$row[pointValue]."</div></li>";
				                          $count++;
				                	}
									echo "<input type=\"hidden\" name=\"query_bound\" value=\"recent\">";
								}
						?>
						</ul>
					</div>
					<div class="five columns offset-by-eleven clearfix">
						<div class="right">
							<a class="button" href="events.php">View All Events</a>
							<input type="submit">
						</div>
					</div>
				</form>
			</div>
		</div> 


	</div><!-- container -->


<!-- End Document
================================================== -->
</body>
</html>
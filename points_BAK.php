<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
		<script type="text/javascript">
		jQuery(document).ready(function() {
		  jQuery(".pie").hide();
		  //toggle the componenet with class msg_body
		  $(".breakdown").click(function()
		  {
		    jQuery(".pie").slideToggle('slow', function() {
		    // Animation complete.
		  });
		  });
		});
		</script>
		<script type="text/javascript">
		<!--
		if (screen.width <= 700) {
		window.location = "http://reckclub.org/mobile.php";
		}
		//-->
		</script>
	<script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
		  ['Work', <?php echo($workEventCount); ?>],
          ['Social', <?php echo($socialEventCount); ?>],
		  ['Sports', <?php echo($sportsEventCount); ?>],
          ['Mandatory', <?php echo($mandatoryEventCount); ?>]
		  
          
        ]);

        // Set chart options
        var options = {'width':400,
                       'height':175,chartArea:{left:20,top:10,width:"100%",height:"90%"},legend:{position: 'right', textStyle: {color: 'black', fontSize: 11}},'is3D':false,pieSliceTextStyle:{color: 'black'}, backgroundColor:'#FFFFFF',colors:['#149F3D','#005ACE','#FFCB00','#D0D0D0']};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<?php require "html_header_end.txt"; ?>
	
	<div align="center">
		<img src="images/memberMainHeader.png">
		<br/>
		<div style="font-size:16px; text-transform:uppercase; letter-spacing:5px;">
			Welcome back, <?php echo($firstName) ?>.
		</div>
		<br/>

<!-- NAVIGATION BAR -->

<div id="nav">
	<ul>
		<?php
			if($isSecretary == 1 || $isVP == 1 || $isEventAdmin == 1 || $isAdmin == 1) {
				echo("<li>Admin<ul>");
							if($isSecretary == 1 || $isAdmin == 1) {
								echo "<li><a href=\"manageMembers.php\">Manage Members</a></li>";			
							}
							if($isVP == 1 || $isAdmin == 1) {
								echo "<li><a href=\"managePositions.php\">Manage Positions</a></li>";
							}
							if($isVP == 1 || $isAdmin == 1) {
								echo "<li><a href=\"manageCommittees.php\">Manage Committees</a></li>";	
							}
							if($isEventAdmin == 1 || $isAdmin == 1) {
								echo "<li><a href=\"editEvents.php\">Edit Events</a></li>";
							}	
							if($isAdmin == 1) {
								echo "<li><a href=\"manageWebsite.php\">Manage Website</a></li>";
							}	
					echo("</ul></li>");
			}
		?>
		<li><a href="calendar.php">Calendar</a></li>
		<li>Resources
			<ul>
				<li><a href="rules.php">Rules</a></li>
				<li><a href="docs.php">Docs</a></li>
				<li><a href="memberContacts.php">Contacts</a></li>
			</ul>
		</li>
	  <li><a href="memberBalance.php">Balance</a>
			<?php
				if($isTreasurer == 1 || $isAdmin == 1) {
				 echo("<ul><li><a href=\"manageLineItems.php\">Manage Line Items</a></li><li><a href=\"applyLineItems.php\">Apply Line Items</a></li><li><a href=\"managePayments.php\">Manage Payments</a></li><li><a href=\"viewMemberBalances.php\">View All Balances</a></li></ul>");
				}
			?>
			
	  </li>
	  <li><a href="memberSettingsForm.php">Settings</a></li>
	  <li><a href="memberLogout.php">Log Out</a></li>
	</ul>
</div>

<!-- RETRIEVE MEMBER POINT INFORMATION -->

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

<table align="center" class="table-nopadding table-main">
	<tr class="table-nopadding" valign="top">
    <!-- LEFT COLUMN-->
    	<td class="table-nopadding table-main">
			<table class="table-nopadding">
              <!-- POINTS,RANK,EVENTS-->
            	<tr class="table-gold">
                <td class="table-nopadding">
                	<table width="400">
						<tr class="table-nopadding" >
                            <td width="125">
                                <div class="statsType">
                                    <?php echo($pts); ?>
                                </div>
                                <div class="descType">
                                    POINTS
                                </div>
                            </td>
                            <td width="125">
                                <div class="statsType">
                                    <?php echo($rank); ?>
                                </div>
                                <div class="descType">
                                    RANK
                                </div>
                            </td>
                            <td width="125">
                                <div class="statsType">
                                    <?php echo($eventCount); ?>
                                </div>
                                <div class="descType">
                                    EVENTS
                                </div>
                            </td>
						</tr>
					</table>
              	</td>
                </tr>
                <tr class="table-gold breakdown">
                	<td><span style="font-size:11px; letter-spacing:2px; color:#FFF;">YOUR EVENT BREAKDOWN</span></td>
                </tr>
                <tr>
                	<td class="table-nopadding pie">
    					<div id="chart_div"></div>
                    </td>
                </tr>
                <!-- Top 5 -->
                <tr>
                <td class="table-nopadding">
                	<table width="408">
                    	<tr class="table-header table-gold">
                        	<td colspan="3">Top 5</td>
                        </tr>
                    	<tr class="table-header">
                       	  <td>
                            	Rank
                          </td>
                          <td>
                            	Member
                          </td>
                          <td>
                            	Points
                          </td>
                        </tr>
                        <?php 
                        
                        	$count = 1;

							$top5_query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName LIMIT 5");
								$top5_query->setFetchMode(PDO::FETCH_ASSOC);

                        	while($row = $top5_query->fetch()){
	                                	echo "<tr class=\"rowHover\"><td align=\"center\">".$count."</td>";
										echo "<td width=300>".$row[firstName]." ".$row[lastName]."</td>";
										echo "<td align=\"center\">".$row[memberPoints]."</td></tr>";
										$count++;
                            }
                            
                        ?>
                        <tr><td colspan="3"><a href="rankings.php" style="font-size:12px;">Complete Individual Rankings</a></td></tr>
                        <tr style="float:left; height:8px"><td>&nbsp;</td></tr>
                    </table>
                </td>
                </tr>
                <!-- Family Rankings -->
                <tr>
                <td class="table-nopadding">
                	<table width="408">
                    	<tr class="table-header table-gold">
                        	<td colspan="3" >Family Rankings</td>
                        </tr>
                    	<tr class="table-header">
                       	  <td>
                            	Rank
                          </td>
                          <td>
                            	Family
                          </td>
                          <td>
                            	Points
                          </td>
                        </tr>
                        <?php
							$family_query = $db->query("SELECT familyName, familyPoints FROM Family ORDER BY familyPoints DESC, familyName");
								$family_query->setFetchMode(PDO::FETCH_ASSOC);

        					$var = 1;

                            while($row = $family_query->fetch()){
                                    echo "<tr class=\"rowHover\"><td align=\"center\">".$var."</td>";
                                    echo "<td width=300>".$row[familyName]."</td>";
                                    echo "<td align=\"center\">".$row[familyPoints]."</td></tr>";
                                    $var++;							   
						}							
						?>
                    </table>
                </td>
                </tr>
            </table>
        </td>
    <!-- RIGHT COLUMN-->
        <td class="table-nopadding table-main">
			<table class="table-nopadding">
                <tr class="table-gold">
                    <td>
                        <div>
                            <strong>Recent Events</strong>
                        </div>
                	</td>
                </tr>
                <tr>
                	<td>
	                <?php
		                $today = getdate();
		                $currentday = $today[mday];
		                $currentmonth = $today[mon];
		                $currentyear = $today[year];

						$events_query = $db->query("SELECT * FROM Event WHERE isFamilyEvent = '0' AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear ),'%m/%d/%Y') <= STR_TO_DATE(CONCAT($currentmonth,'/',$currentday,'/',$currentyear ),'%m/%d/%Y') ORDER BY dateMonth DESC, dateDay DESC, eventName LIMIT 0, 10");
							$events_query->setFetchMode(PDO::FETCH_ASSOC);
	                		
	                	$rowcount = $events_query->rowCount();
	                	
	                	if($rowcount==0){
	                		echo "<br/><br/><br/><br/><br/><br/><br/><br/>There are currently no events.<br/><br/><br/><br/><br/><br/><br/><br/><br/>";
	                	} else {
		                	echo "<table class=\"table-nopadding\">";	
		                	echo "<form action=\"updatePoints.php\" method=\"POST\">\n";
							echo "<tr><th>&nbsp;</th><th width=\"200\">Event</th><th>Date</th><th>Points</th></tr>\n";
	                	
		                	while($row = $events_query->fetch()){
		                          $tempEventID = $row[eventID];
								  $attends_query = $db->query("SELECT * FROM AttendsEvent WHERE eventID = $tempEventID AND memberID = $memberID");
									   $attends_query->setFetchMode(PDO::FETCH_ASSOC);
		                          $num_results3 = $attends_query->rowCount();
		                          echo "<tr";
		                          if($num_results3 == 1) {
		                                         echo " bgcolor=\"#b3a369\"";
		                          } else { }
		                          echo "><td><input type=\"checkbox\" name=\"";
		                          echo $row[eventID];
		                          echo "\" ";
		                          if($num_results3 == 1) {
		                                         echo " CHECKED";
		                          } else { }
		                          echo "></td>";
		                          echo "<td width=\"150\">".$row[eventName];
		                          if($row[isBonus] == 1) {
		                                          echo " (BONUS)";
		                          } else { }
		                          echo"</td>";
		                          echo "<td>".$row[dateMonth]."-".$row[dateDay]."-".$row[dateYear]."</td>";
		                          echo "<td>".$row[pointValue]."</td></tr>";
		                	}
							echo "<tr><td colspan=\"4\"><input type=\"submit\" value=\"Update\"></td></tr>\n";
							echo "<input type=\"hidden\" name=\"query_bound\" value=\"recent\">";
							echo "</form>";
							echo "</table>";
						}
					?>
					</td>
				</tr>
				<tr><td><hr/></td></tr>
                <tr>
                	<td>
                	<table><form action="events.php" method="POST"><tr>
                		<td><label for="selectMonth">Select Events By Month: </label></td><td>
						<select name="dateMonth" id="dateMonth">
							<option value="01" <?PHP if($currentmonth==1) echo "selected";?>>January</option>
							<option value="02" <?PHP if($currentmonth==2) echo "selected";?>>February</option>
							<option value="03" <?PHP if($currentmonth==3) echo "selected";?>>March</option>
							<option value="04" <?PHP if($currentmonth==4) echo "selected";?>>April</option>
							<option value="05" <?PHP if($currentmonth==5) echo "selected";?>>May</option>
							<option value="06" <?PHP if($currentmonth==6) echo "selected";?>>June</option>
							<option value="07" <?PHP if($currentmonth==7) echo "selected";?>>July</option>
							<option value="08" <?PHP if($currentmonth==8) echo "selected";?>>August</option>
							<option value="09" <?PHP if($currentmonth==9) echo "selected";?>>September</option>
							<option value="10" <?PHP if($currentmonth==10) echo "selected";?>>October</option>
							<option value="11" <?PHP if($currentmonth==11) echo "selected";?>>November</option>
							<option value="12" <?PHP if($currentmonth==12) echo "selected";?>>December</option>
							<option value="all">All Events</option>
						</select>
                		</td>
                		<td><input type="submit" value="Select"></td></tr></form></table>
                	</td>
                </tr>
                <tr class="table-gold">
                    <td>
                        <div>
                            <strong>Family Info</strong>
                        </div>
                	</td>
                </tr>
                <tr>
                	<td>
                        <div>
                            <a href="families.php">Families</a><br />
                            <a href="familyEvents.php">Family Events</a>
                        </div>
                	</td>
                </tr>

            </table>
        	
        </td>
    </tr>
</table>
<br/><br/><br/><br/>

<?php require "html_footer.txt"; ?>
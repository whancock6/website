<?php
	require "logged_in_check.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
<SCRIPT language=JavaScript>
function reload(form){
var sortBy=form.sortBy.options[form.sortBy.options.selectedIndex].value;
self.location='rankings.php?sortBy=' + sortBy;
}
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br/>
<?php
	@$sortBy=$_GET[sortBy];
	
	if(isset($sortBy)) {
	} else {
	    $sortBy = "all";
	}
?>
<h3>Complete Individual Rankings</h3>

<div align="center">
<a href="points.php">Back to Points</a><br/>
<a href="stats.php">More fun stats</a>
</div><br/>
<form>
<table align="center">
<tr><td>Sort by: </td>
<td>
<select name="sortBy" id="sortBy" onChange="reload(this.form)">
   <option value="all"  <?PHP if($sortBy=="all") echo "selected";?>>All</option>
   <option value="members"  <?PHP if($sortBy=="members") echo "selected";?>>Members</option>
   <option value="probates"  <?PHP if($sortBy=="probates") echo "selected";?>>Probates</option>
   <option value="social"  <?PHP if($sortBy=="social") echo "selected";?>>Social</option>
</select>
</td></tr>
</table>
</form>
</br></br>
<?php

	// CREATE TABLE OF INDIVIDUAL RANKINGS
	//---------------------------------------------------

	echo "<table align=\"center\">";
	echo "<tr bgcolor=\"#dbcfba\"><th>Rank</th><th>Member</th><th width=100>Points</th><th>Check Events</th></tr>";

        if($sortBy=="all") {
		   	$query = $db->query("SELECT firstName, lastName, memberPoints, memberID FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        } elseif($sortBy=="members") {
		   	$query = $db->query("SELECT firstName, lastName, memberPoints, memberID FROM Member WHERE status='member' ORDER BY memberPoints DESC, lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        } elseif($sortBy=="probates") {
		   	$query = $db->query("SELECT firstName, lastName, memberPoints, memberID FROM Member WHERE status='probate' ORDER BY memberPoints DESC, lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        } elseif($sortBy=="social") {
		   	$query = $db->query("SELECT firstName, lastName, memberPoints, memberID FROM Member WHERE status='social' ORDER BY memberPoints DESC, lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        }
	
	$count = 1;

	while($row = $query->fetch())
		{
		echo "<form action=\"allAttended.php\" method=\"POST\">";
		echo "<tr><td align=\"center\">".$count."</td>";
		echo "<td width=200>".$row[firstName]." ".$row[lastName]."</td>";
		echo "<td align=\"center\">".$row[memberPoints]."</td>";
		echo "<td align=\"center\"><input type=\"submit\" value=\"Check Events\"></td></tr>";
		echo "<input type=\"hidden\" name=\"memberID\" value=\"".$row[memberID]."\">";
		echo "</form>";
		$count++;
		}

	echo "</table>";
?>
<br/><br/><br/><br/><br/><br/>
<?php require "html_footer.txt"; ?>
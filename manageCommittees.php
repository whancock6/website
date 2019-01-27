<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isVP]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
<SCRIPT type="text/javascript" language="javascript1.2">
	function reload(form){
	var selectedCommittee=form.selectedCommittee.options[form.selectedCommittee.options.selectedIndex].value;
	var selectedYear=form.selectedYear.options[form.selectedYear.options.selectedIndex].value;
	self.location='manageCommittees.php?selectedCommittee=' + selectedCommittee + '&selectedYear=' + selectedYear;
	}
	function moveData(dir) {
	    var sF = document.getElementById(((dir == "back")?"destinationSelect":"sourceSelect"));
	    var dF = document.getElementById(((dir == "back")?"sourceSelect":"destinationSelect"));
	    if(sF.length == 0 || sF.selectedIndex == -1) return;
	    while (sF.selectedIndex != -1) {
	        dF.options[dF.length] = new Option(sF.options[sF.selectedIndex].text, sF.options[sF.selectedIndex].value);
	        sF.options[sF.selectedIndex] = null;
	    }
	}
	function selectAll(selectBox,selectAll) { 
	    // have we been passed an ID 
	    if (typeof selectBox == "string") { 
	        selectBox = document.getElementById(selectBox);
	    } 
	    // is the select box a multiple select box? 
	    if (selectBox.type == "select-multiple") { 
	        for (var i = 0; i < selectBox.options.length; i++) { 
	             selectBox.options[i].selected = selectAll; 
	        } 
	    }
	}
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br>
	
<?php
	@$selectedCommittee=$_GET[selectedCommittee];
	@$selectedYear=$_GET[selectedYear];
	$today = getdate();
	$currentyear = $today[year];
	
	if(isset($selectedCommittee)) {
	} else {
		$selectedCommittee = "none";
	}
	
	if(isset($selectedYear)) {
	} else {
		$selectedYear = $currentyear;
	}
	
	$query = $db->query("SELECT committeeName, committeeID FROM Committee ORDER BY committeeName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
?>

<h3>Manage Committees</h3>
<div align="center">
<a href="points.php">Back to Points</a><br><br>
</div><br>

<form>
	<table align="center">
		<tr><td>Select Committee: </td>
		<td>
		<select name="selectedCommittee" id="selectedCommittee" onChange="reload(this.form)">
		   <option value="none"  <?PHP if($selectedCommittee=='NULL') echo "selected";?>>---</option>
		
		<?php
		   while($row = $query->fetch()) {
		          echo "<option value=\"".$row[committeeID]."\" ";
		           if($selectedCommittee==$row[committeeID]) {
		                  echo "selected";
		           }
		          echo ">".$row[committeeName]."</option>";
		   }    
		?>
		
		</select>
		</td></tr>
		<tr><td>Select Year: </td>
		<td>
		<select name="selectedYear" id="selectedYear" onChange="reload(this.form)">
		
		<?php
			$stopyear = 2012;
			$tempyear = $currentyear;
			while($tempyear >= $stopyear) {
				echo "<option value=\"".$tempyear."\" ";
				if($selectedYear==$tempyear) { echo "selected"; }
				echo ">".$tempyear."</option>";
				$tempyear = $tempyear - 1;
			}
		?>

		</select>
		</td></tr>
	</table>
</form>

<br/>

<form action="createCommittee.php" method="POST">
	<table align="center">
		<tr><td>New Committee Name: </td><td><input type="text" name="committeeName" size=30/></td><td><input type="submit" value="Create"/></td></tr>
	</table>
</form>

<br/><br/>

<?php
	if($selectedCommittee != "none" && $selectedYear == $currentyear) {
		$query2 = $db->prepare("SELECT memberID, firstName, lastName FROM Member WHERE memberID NOT IN (SELECT memberID FROM OnCommittee WHERE committeeID = :selectedCommittee AND year = :selectedYear) AND status != 'alumni' ORDER BY lastName");
		$query2->execute(array('selectedCommittee'=>$selectedCommittee, 'selectedYear'=>$selectedYear));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		$query3 = $db->prepare("SELECT memberID, firstName, lastName FROM Member WHERE memberID IN (SELECT memberID FROM OnCommittee WHERE committeeID = :selectedCommittee AND year = :selectedYear) AND status != 'alumni' ORDER BY lastName");
		$query3->execute(array('selectedCommittee'=>$selectedCommittee, 'selectedYear'=>$selectedYear));
			$query3->setFetchMode(PDO::FETCH_ASSOC);
	} elseif($selectedCommittee != "none" && $selectedYear != $currentyear) {
		$query2 = $db->prepare("SELECT memberID, firstName, lastName FROM Member WHERE memberID NOT IN (SELECT memberID FROM OnCommittee WHERE committeeID = :selectedCommittee AND year = :selectedYear) ORDER BY lastName");
		$query2->execute(array('selectedCommittee'=>$selectedCommittee, 'selectedYear'=>$selectedYear));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		$query3 = $db->prepare("SELECT memberID, firstName, lastName FROM Member WHERE memberID IN (SELECT memberID FROM OnCommittee WHERE committeeID = :selectedCommittee AND year = :selectedYear) ORDER BY lastName");
		$query3->execute(array('selectedCommittee'=>$selectedCommittee, 'selectedYear'=>$selectedYear));
			$query3->setFetchMode(PDO::FETCH_ASSOC);
	}
?>

<form action="updateCommittees.php" method="POST">
  <table align="center" width="250" border="0" cellspacing="0" cellpadding="0">
    <tr><th>Members:</th><th>&nbsp;</th><th>Members in Committee:</th></tr>
    <tr>
      <td width="400"><select style="width: 200px" name="SourceSelect[]" id="sourceSelect" size="25" multiple="multiple" ondblclick="moveData(); return false;">
      	<?php
      		if($selectedCommittee != "none") {
	      		while($row2 = $query2->fetch()) {
	      			echo "<option value=\"".$row2[memberID]."\">".$row2[lastName].", ".$row2[firstName]."</option>";
	      		}
	      	}
      	?>
        </select></td>
      <td width="100" align="center" valign="middle"><input type="submit" name="forward" id="button" value=">>>" onclick="moveData(); return false;"/>&nbsp;
        <input type="submit" name="back" id="button" value="<<<" onclick="moveData('back'); return false;"/></td>
      <td width="400" align="left"><select style="width: 200px" name="DestinationSelect[]" id="destinationSelect" size="25" multiple="multiple" ondblclick="moveData('back'); return false;">
      	<?php
      		if($selectedCommittee != "none") {
	      		while($row3 = $query3->fetch()) {
	      			echo "<option value=\"".$row3[memberID]."\">".$row3[lastName].", ".$row3[firstName]."</option>";
	      		}
	      	}
      	?>      
        </select></td>
    </tr><tr><td>&nbsp;</td></tr>
    <tr><td colspan="3"><input type="submit" value="Update" onclick="selectAll('sourceSelect',true); selectAll('destinationSelect',true); return true;"></td></tr>
    <input type="hidden" name="selectedCommittee" value="<?php echo $selectedCommittee; ?>">
    <input type="hidden" name="selectedYear" value="<?php echo $selectedYear; ?>">
  </table>
</form>

<br/><br/><br/><br/>

<?php require "html_footer.txt"; ?>
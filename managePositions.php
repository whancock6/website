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
	function reload1(form){
	var selectedPosition=form.selectedPosition.options[form.selectedPosition.options.selectedIndex].value;
	self.location='managePositions.php?selectedPosition=' + selectedPosition;
	}
	function reload2(form){
	var selectedYear=form.selectedYear.options[form.selectedYear.options.selectedIndex].value;
	self.location='managePositions.php?selectedYear=' + selectedYear;
	}
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br/>
	
<?php
	@$selectedPosition=$_GET[selectedPosition];
	@$selectedYear=$_GET[selectedYear];
	$today = getdate();
	
	$currentyear = $today[year];
	$stopyear = 2000;
	
	if(isset($selectedPosition)) {
	} else {
		$selectedPosition = "none";
	}
	
	if(isset($selectedYear)) {
	} else {
		$selectedYear = "none";
	}
	
	$query = $db->query("SELECT positionName, positionID FROM Position ORDER BY positionID");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$positions = $query->fetchAll();
	
	$query2 = $db->query("SELECT memberID, firstName, lastName FROM Member ORDER BY lastName");
		$query2->setFetchMode(PDO::FETCH_ASSOC);
	$members = $query2->fetchAll();
?>

<h3>Manage Positions</h3>
<div align="center">
<a href="points.php">Back to Points</a><br><br>
</div><br>

<!-- VIEW POSITIONS FORM -->
<form>
	<table align="center">
		<tr><th>VIEW:</th><td>Select Position: </td>
		<td>
		<select name="selectedPosition" id="selectedPosition" onChange="reload1(this.form)">
		   <option value="none"  <?PHP if($selectedPosition=='NULL') echo "selected";?>>---</option>
		
		<?php
		   foreach($positions as $p) {
		          echo "<option value=\"".$p[positionID]."\" ";
		           if($selectedPosition==$p[positionID]) {
		                  echo "selected";
		           }
		          echo ">".$p[positionName]."</option>";
		   }    
		?>
		
		</select>
		</td><td colspan="2">   OR   </td><td>Select Year: </td>
		<td>
		<select name="selectedYear" id="selectedYear" onChange="reload2(this.form)">
			<option value="none" <?PHP if($selectedYear=='NULL') echo "selected";?>>---</option>
		
		<?php
			$tempyear = $currentyear;
			while($tempyear >= $stopyear) {
				echo "<option value=\"".$tempyear."\"";
				if($selectedYear==$tempyear) { echo " selected"; }
				echo ">".$tempyear."</option>";
				$tempyear = $tempyear - 1;
			}
		?>

		</select>
		</td></tr>
	</table>
</form>

<br/>

<!-- ADD POSITION FORM -->
<form action="createPosition.php" method="POST">
	<table align="center">
		<tr><th>ADD:</th><td>New Position Name: </td><td><input type="text" name="positionName" size=30/></td><td><input type="submit" value="Create"/></td></tr>
	</table>
</form>

<br/>

<!-- EDIT POSITIONS FORM -->
<form action="updatePositions.php" method="POST">
	<table align="center">
		<tr><th>EDIT:</th><td>Position: </td><td><select name="selectedPosition" id="selectedPosition">
		   <option value="none">---</option>
			<?php
			   foreach($positions as $p) {
			          echo "<option value=\"".$p[positionID]."\">".$p[positionName]."</option>";
			   }    
			?>
		</select></td><td>Member: </td><td><select name="selectedMember" id="selectedMember">
			<option value="none">---</option>
			<?php
			   foreach($members as $m) {
			          echo "<option value=\"".$m[memberID]."\">".$m[lastName].", ".$m[firstName]."</option>";
			   }    
			?>
		</select></td><td>Year: </td><td><select name="selectedYear" id="selectedYear">
			<option value="none">---</option>
			<?php
				$tempyear = $currentyear;
				while($tempyear >= $stopyear) {
					echo "<option value=\"".$tempyear."\">".$tempyear."</option>";
					$tempyear = $tempyear - 1;
				}
			?>
		</select></td><td><input type="submit" name="add" value="Add"></td><td><input type="submit" name="remove" value="Remove"></td>
		</tr>
	</table>
	<input type="hidden" name="pagePosition" value="<?php echo $selectedPosition; ?>">
	<input type="hidden" name="pageYear" value="<?php echo $selectedYear; ?>">
</form>

<br/><br/>

<?php
	if(isset($selectedPosition) && $selectedPosition != "none") {
		$query = $db->prepare("SELECT positionName FROM Position WHERE positionID=:positionID");
		$query->execute(array('positionID'=>$selectedPosition));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		$positionName = $row[positionName];
?>
		<form action="updatePositions.php" method="POST">
			<table align="center">
				<tr><th colspan="10"><?php echo $positionName; ?></th></tr>
				<?php
				$tempyear = $currentyear;
				while($tempyear >= $stopyear) {
					$query3 = $db->prepare("SELECT memberID FROM HoldsPosition WHERE positionID=:positionID AND year=:year");
					$query3->execute(array('positionID'=>$selectedPosition, 'year'=>$tempyear));
						$query3->setFetchMode(PDO::FETCH_ASSOC);
					$cnt = $query3->rowCount();
					if($cnt==0) {
						echo "<tr><td>".$tempyear." - </td>";
						echo "<td colspan=\"10\"><select name=\"".$tempyear."[]\">";
						echo "<option value=\"none\">---</option>";
						foreach($members as $m) {
							echo "<option value=\"".$m[memberID]."\">".$m[lastName].", ".$m[firstName]."</option>";
						}
						echo "</select></td>";
					} else {
						echo "<tr><td>".$tempyear." - </td>";
						while($row = $query3->fetch()) {
							$tempMemberID = $row[memberID];
							echo "<td><select name=\"".$tempyear."[]\">";
							echo "<option value=\"none\">---</option>";
							foreach($members as $m) {
								echo "<option value=\"".$m[memberID]."\"";
								if($m[memberID]==$tempMemberID) { echo " selected"; }
								echo">".$m[lastName].", ".$m[firstName]."</option>";
							}
							echo "</select></td>";
						}
						echo "</tr>";
					}
					$tempyear = $tempyear - 1;
				}
				?>
				<tr><td colspan="10"><input type="submit" name="position" value="Update"></td></tr>
			</table>
			<input type="hidden" name="stopYear" value="<?php echo $stopyear; ?>">
			<input type="hidden" name="selectedPosition" value="<?php echo $selectedPosition; ?>">
			<input type="hidden" name="pagePosition" value="<?php echo $selectedPosition; ?>">
		</form>
<?php
	} elseif (isset($selectedYear) && $selectedYear != "none") {
?>
		<form action="updatePositions.php" method="POST">
			<table align="center">
				<tr><th colspan="10"><?php echo $selectedYear; ?></th></tr>
				<?php
				foreach($positions as $p) {
					$query3 = $db->prepare("SELECT memberID FROM HoldsPosition WHERE positionID=:positionID AND year=:year");
					$query3->execute(array('positionID'=>$p[positionID], 'year'=>$selectedYear));
						$query3->setFetchMode(PDO::FETCH_ASSOC);
					$cnt = $query3->rowCount();
					if($cnt==0) {
						echo "<tr><td>".$p[positionName]." - </td><td><select name=\"".$p[positionID]."[]\">";
						echo "<option value=\"none\">---</option>";
						foreach($members as $m) {
							echo "<option value=\"".$m[memberID]."\">".$m[lastName].", ".$m[firstName]."</option>";
						}
						echo "</select></td></tr>";					
					} else {
						while($row = $query3->fetch()) {
							$tempMemberID = $row[memberID];
							echo "<tr><td>".$p[positionName]." - </td><td><select name=\"".$p[positionID]."[]\">";
							echo "<option value=\"none\">---</option>";
							foreach($members as $m) {
								echo "<option value=\"".$m[memberID]."\"";
								if($m[memberID]==$tempMemberID) { echo " selected"; }
								echo ">".$m[lastName].", ".$m[firstName]."</option>";
							}
							echo "</select></td></tr>";
						}
					}
				}			
				?>
				<tr><td colspan="10"><input type="submit" name="year" value="Update"></td></tr>
			</table>
			<input type="hidden" name="stopYear" value="<?php echo $stopyear; ?>">
			<input type="hidden" name="selectedYear" value="<?php echo $selectedYear; ?>">
			<input type="hidden" name="pageYear" value="<?php echo $selectedYear; ?>">
		</form>
<?php
	} else {}
?>

<br/><br/><br/><br/>

<?php require "html_footer.txt"; ?>
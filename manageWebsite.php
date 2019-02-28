<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
<SCRIPT type="text/javascript">
	function confirmSubmitBackup() 
	{
	var agree=confirm("Are you sure you wish to back up all tables in the database? Any previous back up will be overwritten.");
	if (agree)
		return true;
	else
		return false;
	}
	function confirmSubmitRevert() 
	{
	var agree=confirm("Are you sure you wish to revert to the backed up version of the database? This action cannot be undone.");
	if (agree)
		return true;
	else
		return false;
	}
	function confirmSubmitReset() 
	{
	var agree=confirm("Are you sure you wish to delete all events and reset points? This action cannot be undone.");
	if (agree)
		return true;
	else
		return false;
	}
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br>

<h3>Manage Website</h3>
<div align="center">
<a href="points.php">Back to Points</a><br><br>
</div><br>

<?php
	$query = $db->query("SELECT DATE_FORMAT(lastBackupDate, '%M %e, %Y %r') AS lastBackup FROM BackupLog;");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	$bkupDate = $row[lastBackup];
	
	$query = $db->query("SELECT * FROM Member WHERE isAdmin = 1 || isEventAdmin = 1 ORDER BY lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$admins = $query->fetchAll();
	
	$query = $db->query("SELECT * FROM Member ORDER BY lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$members = $query->fetchAll();
?>

<form name="permissions" action="updatePermissions.php" method="POST">
	<table align="center">
		<tr><td style="vertical-align:top">
			<table>
				<tr><th>Admins</th></tr>
				<?php
					foreach($admins as $a) {
						if($a[isAdmin]==1) {
							echo "<tr><td>".$a[firstName]." ".$a[lastName]."</td></tr>";
						}
					}
				?>
			</table>
		</td><td style="vertical-align:top">
			<table>
				<tr><th>Event Admins</th></tr>
				<?php
					foreach($admins as $a) {
						if($a[isEventAdmin]==1) {
							echo "<tr><td>".$a[firstName]." ".$a[lastName]."</td></tr>";
						}
					}
				?>
			</table>
		</td><td style="vertical-align:top">
			<table>
				<tr><th>Member</th><th>Role</th><th>Add</th><th>Remove</th></tr>
				<tr><td><select name="selectedMember">
					<option value="none">---</option>
					<?php
						foreach($members as $m) {
							echo "<option value=\"".$m[memberID]."\">".$m[lastName].", ".$m[firstName]."</option>";
						}
					?>
				</select></td><td><select name="selectedRole">
					<option value="none">---</option>
					<option value="isAdmin">Admin</option>
					<option value="isEventAdmin">Event Admin</option>
				</select></td><td><input type="submit" name="add" value="Add"></td><td><input type="submit" name="remove" value="Remove"></td></tr>
			</table>
		</td></tr>
	</table>
</form>

<br><br><br>

<form name="backupDatabase" action="backupDatabasex.php" method="POST">
	<table align="center">
		<tr><th>Back Up All Tables in the Database</th></tr>
		<tr bgcolor="#b3a369"><td>This will create a back up table for each table in the database. This allows you to revert to a previous state if an error occurs in the future.</td></tr>
		<tr bgcolor="#b3a369"><td>If a back up already exists, then it will be replaced with a new one based on the current data. (i.e. There is only one back up at a time.)</td></tr>
		<?php echo "<tr><td><u>Date of Last Back Up</u>: ".$bkupDate."</td></tr>"; ?>
		<tr><td><input type="submit" value="Back Up Database" onClick="return confirmSubmitBackup()"></td></tr>
	</table>
</form>

<br><br><br>

<form name="revertDatabase" action="revertDatabasex.php" method="POST">
	<table align="center">
		<tr><th>Revert to the Backed Up Version of the Database</th></tr>
		<tr bgcolor="#b3a369"><td>This will overwrite the current version of each table with its corresponding backed up version.</td></tr>
		<tr bgcolor="#b3a369"><td>This action cannot be undone and should only be taken if important data is lost or there is some other serious error with the database.</td></tr>
		<tr><td><input type="submit" value="Revert to Back Up" onClick="return confirmSubmitRevert()"></td></tr>
	</table>
</form>

<br><br><br>

<form name="resetPoints" action="resetPointsx.php" method="POST">
	<table align="center">
		<tr><th>Delete Events and Reset Points</th></tr>
		<tr bgcolor="#b3a369"><td>WARNING: This will delete all events in the database. Use only to reset points for a new semester.</td></tr>
		<tr><td><input type="submit" value="Reset Points" onClick="return confirmSubmitReset()"></td></tr>
	</table>
</form>

<br><br><br>

<form name="phpInfo" action="testinfo.php" method="POST">
	<table align="center">
		<tr><th>Check Current Version of PHP</th></tr>
		<tr bgcolor="#b3a369"><td>Get information about the current version and configuration of PHP running on the system.</td></tr>
		<tr><td><input type="submit" value="Check PHP Version"></td></tr>
	</table>
</form>

<br><br><br><br><br><br>

<?php require "html_footer.txt"; ?>
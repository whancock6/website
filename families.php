<?php
	require "logged_in_check.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
?>

<h3>Families</h3>

<div align="center">
<a href="points.php">Back to Points</a>
</div><br/>
<br/>
<?php
if($_SESSION[isAdmin]==1 || $_SESSION[isVP]==1) {
     echo "<table align=\"center\">";
     echo "<form action=\"editFamilies.php\" method=\"POST\">";
     echo "<tr><td><input type=\"submit\" value=\"Edit Families\"></td></tr>";
     echo "</form>";
     echo "</table>";
     echo "<br/><br/>";
}
?>
<table align="center">
<?php
	echo "<tr bgcolor=\"#dbcfba\"><th width=300>";
	$query = $db->query("SELECT familyName FROM Family WHERE familyID=1");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	echo $row[familyName];
	echo "</th><th>Points</th><th width=300>";
	$query = $db->query("SELECT familyName FROM Family WHERE familyID=3");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	echo $row[familyName];
	echo "</th><th>Points</th></tr>";
	echo "<tr><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=1 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[firstName]." ".$row[lastName]."<br>";
	}
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=1 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[memberPoints]."<br>";
	}       
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=3 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[firstName]." ".$row[lastName]."<br>";
	}
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=3 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[memberPoints]."<br>";
	}
	echo "</td></tr>";
	echo "<tr bgcolor=\"#dbcfba\"><th>";
	$query = $db->query("SELECT familyName FROM Family WHERE familyID=2");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	echo $row[familyName];
	echo "</th><th>Points</th><th>";
	$query = $db->query("SELECT familyName FROM Family WHERE familyID=4");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	echo $row[familyName];
	echo "</th><th>Points</th></tr>";
	echo "<tr><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=2 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[firstName]." ".$row[lastName]."<br>";
	}
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=2 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[memberPoints]."<br>";
	}
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=4 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[firstName]." ".$row[lastName]."<br>";
	}
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=4 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[memberPoints]."<br>";
	}
echo "</td></tr>";
	echo "<tr bgcolor=\"#dbcfba\"><th>";
	$query = $db->query("SELECT familyName FROM Family WHERE familyID=5");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	echo $row[familyName];
	echo "</th><th>Points</th><th>";
	$query = $db->query("SELECT familyName FROM Family WHERE familyID=6");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	echo $row[familyName];
	echo "</th><th>Points</th></tr>";
	echo "<tr><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=5 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[firstName]." ".$row[lastName]."<br>";
	}
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=5 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[memberPoints]."<br>";
	}
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=6 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[firstName]." ".$row[lastName]."<br>";
	}
	echo "</td><td>";
	$query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=6 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo $row[memberPoints]."<br>";
	}
	echo "</td></tr>";
	
?>
</table>
	
<br/><br/><br/>	
<?php require "html_footer.txt"; ?>
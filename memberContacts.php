<?php
	require "logged_in_check.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	echo "<br />";
	echo "<h3>Contacts</h3>";

	echo "<div align=\"center\">";
	echo "<a href=\"points.php\">Back to Points</a>";
	echo "</div><br>";

	echo "<table align=\"center\">";
	echo "<tr><th width=200>Name</th><th width=300>Email</th><th width=100>Phone Number</th><th width=100>Twitter</th></tr>";
	
	$query = $db->query("SELECT * FROM Member WHERE status!='alumni' ORDER BY lastName");
		$query->setFetchMode(PDO::FETCH_ASSOC);

	$num = 3;

	while($row = $query->fetch())
		{
			echo "<tr";
			if($num%2 == 1)
				{
				echo " bgcolor=\"#b3a369\"";
				}
			echo "><td>".$row[firstName]." ".$row[lastName]."</td>";
			echo "<td>".$row[email]."</td>";
			echo "<td>".$row[phone]."</td>";
			echo "<td>".$row[twitter]."</td></tr>";
			$num++;
		}

	echo "</table>";
	echo "<br/><br/><br/><br/><br/><br/>";

	require "html_footer.txt"; 
?>
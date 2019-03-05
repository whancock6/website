<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	
	require "header.php";

	$query = $db->query("SELECT * FROM Member WHERE status!='alumni' ORDER BY lastName");
	$query->setFetchMode(PDO::FETCH_ASSOC);

?>
<div class="row">
			<div class="sixteen columns ">
				<h3>Contacts</h3>
			</div>
		</div>
		<div class="row">
			<div id="contacts" class="sixteen columns">
				<ul>
					<li class="header"><div class="name">Name</div><div class="email">Email</div><div class="phone">Phone Number</div><div class="twitter">Twitter</div></li>
					<?php
						while($row = $query->fetch())
						{
							echo "<li><div class=\"name\">".$row[firstName]." ".$row[lastName]."</div><div class=\"email\">".$row[email]."</div><div class=\"phone\">".$row[phone]."</div><div class=\"twitter\">".$row[twitter]."</div></li>";
						}
					?>
				</ul>
			</div>
			
		</div>
		
	</div><!-- container -->


<!-- End Document
================================================== -->
</body>
</html>
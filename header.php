<!--DOCTYPE html-->
<html>
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>Ramblin' Reck Club - Members</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
 	<link href='http://fonts.googleapis.com/css?family=Open+Sans|Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/base.css">
	<link rel="stylesheet" href="css/skeleton.css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/layout.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->


</head>
<body>
	<div class="container">
		<div class="row">
			<header>
				<div class="row">
					<div class="seven columns ">
						<span class="title">Ramblin' Reck Club</span><br>
						<span class="meta">Logged in as <?php echo $_SESSION[username] ?></span>
					</div>
					
					<div class="eight columns">
						<nav>
							<div>
								<span><a href="points.php" class="main highlight">Points</a></span>
<!--								<span><a href="http://reckclub.org/mediastorage" class="main">Media</a></span>-->
							</div>

							<div class="meta">
								<ul>
<!--									<li><a href="memberBalance.php">Balance</a></li>-->
									<li><a href="contacts.php">Contacts</a></li>
									<li><a href="memberSettingsForm.php">Settings</a></li>
									<li><a href="memberLogout.php">Log Out</a></li>
								</ul>
							</div>
						</nav>

					</div>
				</div>
			</header>
		</div>
		<!--<div id="alert" class="row">
			<div class="sixteen columns">
				<div >
					<span class="title">| Alert</span><span>Please pay Tyler your dues by the 2nd meeting. </span>
					<span class="alertClose">x</span>
				</div>
			</div>
		</div>-->
		<?php if($isSecretary == 1 || $isVP == 1 || $isEventAdmin == 1 || $isAdmin == 1) :?>
		<div id="admin" class="row">
			<div class="sixteen columns">
				<ul>
					<li class="title">Admin</li>
					<li><a href="editEvents.php">Edit Events</a></li>
					<?php endif; ?>
					<?php if($isSecretary == 1 || $isVP == 1 || $isAdmin == 1) :?>
					<li><a href="manageMembers.php">Edit Members</a></li>
					<li><a href="managePositions.php">Manage Positions</a></li>
<!--					<li><a href="manageCommittees.php">Manage Commitees</a></li>-->
					<li><a href="manageWebsite.php">Manage Website</a></li>
					<?php endif; ?>
		<?php if($isSecretary == 1 || $isVP == 1 || $isEventAdmin == 1 || $isAdmin == 1) :?>
				</ul>
			</div>
		</div>
		<?php endif; ?>
<!--		--><?php //if($isTreasurer == 1 || $isAdmin == 1) : ?>
<!--		<div id="treasurer" class="row">-->
<!--			<div class="sixteen columns">-->
<!--				<ul>-->
<!--					<li class="title">$$$</li>-->
<!--					<li><a href="manageLineItems.php">Manage Line Items</a></li>-->
<!--					<li><a href="applyLineItems.php">Apply Line Items</a></li>-->
<!--					<li><a href="managePayments.php">Manage Payments</a></li>-->
<!--					<li><a href="viewMemberBalances.php">View Member Balances</a></li>-->
<!--				</ul>-->
<!--			</div>-->
<!--		</div>-->
<!--	    --><?php //endif; ?>
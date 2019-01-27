<?php
	session_start();
	if (!isset($_SESSION['memberID'])) {
                                           echo "<meta http-equiv=\"REFRESH\" content=\"0;url=memberLoginForm.php\">";
                                           die;
                     } else {
                                           // SET SESSION VARIABLES

		$loggedIn = true;
		$memberID = $_SESSION['memberID'];
		$username = $_SESSION['username'];
		$firstName = $_SESSION['firstName'];
		$lastName = $_SESSION['lastName'];
		$email = $_SESSION['email'];
		$phone = $_SESSION['phone'];
		$twitter = $_SESSION['twitter'];
                $streetAddress = $_SESSION['streetAddress'];
                $city = $_SESSION['city'];
                $state = $_SESSION['state'];
                $zipCode = $_SESSION['zipCode'];
		$status = $_SESSION['status'];
		$joinYear = $_SESSION['joinYear'];
		$gradYear = $_SESSION['gradYear'];
		$gradMonth = $_SESSION['gradMonth'];
		$reckerPair = $_SESSION['reckerPair'];
		$memFamilyID = $_SESSION['memFamilyID'];
		$isAdmin = $_SESSION['isAdmin'];
		$isSecretary = $_SESSION['isSecretary'];
		$isTreasurer = $_SESSION['isTreasurer'];
		$isVP = $_SESSION['isVP'];
		$isEventAdmin = $_SESSION['isEventAdmin'];

	                     // CONNECT TO THE mySQL DATABASE

	                     $mysql_host = "mysql.localhost";
	                     $mysql_db = "reck_club";
	                     $mysql_user = "reck";
	                     $mysql_password = "burdell";
	                     $mysql_link = mysql_connect($mysql_host, $mysql_user, $mysql_password)
		                     or die("Error connecting to database: ".mysql_error());
	                     mysql_select_db($mysql_db)
		                     or die("Error accessing database: ".mysql_error());
					 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width">
<title>Ramblin Reck Club</title>
<link href="css/mobile_style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
<script type="text/javascript" src="lib/iscroll.js"></script>
<script type="text/javascript">
var myScroll;

function loaded() {
	myScroll = new iScroll('wrapper', {
		snap: true,
		momentum: false,
		hScrollbar: false,
		onScrollEnd: function () {
			document.querySelector('#indicator > li.active').className = '';
			document.querySelector('#indicator > li:nth-child(' + (this.currPageX+1) + ')').className = 'active';
		}
	 });
}

document.addEventListener('DOMContentLoaded', loaded, false);
</script>
</head>
<body onload="setTimeout(function() { window.scrollTo(0, 1) }, 100);">

<?php
                       // CALCULATE MEMBER'S TOTAL POINTS
                       //-----------------------------------------------

                                        $result = mysql_query("SELECT pointValue FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE memberID = $memberID")
                                                       or die("Failed query: ".mysql_error());
                                        $num = 0;
										$events=0;

                                        while($row = mysql_fetch_assoc($result)) {
                                                       $num += $row['pointValue'];
													   $events++;
                                        }


	// SET MEMBERS' TOTAL POINTS IN DATABASE
	//------------------------------------------------------

	                   mysql_query("UPDATE Member SET memberPoints = $num WHERE memberID = $memberID")
		              or die("Failed query: ".mysql_error());

                       // CALCULATE FAMILIES' TOTAL POINTS AND SET IN DATABASE
                       //---------------------------------------------------------------------------

                      // FAMILY 1

                      $result = mysql_query("SELECT pointValue FROM Member JOIN (AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID) ON Member.memberID = AttendsEvent.memberID WHERE familyID = 1 AND (status = 'probate' OR status = 'member' OR status = 'social')")
                                 or die("Failed query: ".mysql_error());
                      $famnum = 0;
                      while($row = mysql_fetch_assoc($result)) {
                                 $famnum += $row['pointValue'];
                       }

	mysql_query("UPDATE Family SET familyPoints = $famnum WHERE familyID = 1")
		or die("Failed query: ".mysql_error());

                      // FAMILY 2

                      $result = mysql_query("SELECT pointValue FROM Member JOIN (AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID) ON Member.memberID = AttendsEvent.memberID WHERE familyID = 2 AND (status = 'probate' OR status = 'member' OR status = 'social')")
                                 or die("Failed query: ".mysql_error());
                      $famnum = 0;
                      while($row = mysql_fetch_assoc($result)) {
                                 $famnum += $row['pointValue'];
                       }

	mysql_query("UPDATE Family SET familyPoints = $famnum WHERE familyID = 2")
		or die("Failed query: ".mysql_error());

                      // FAMILY 3

                      $result = mysql_query("SELECT pointValue FROM Member JOIN (AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID) ON Member.memberID = AttendsEvent.memberID WHERE familyID = 3 AND (status = 'probate' OR status = 'member' OR status = 'social')")
                                 or die("Failed query: ".mysql_error());
                      $famnum = 0;
                      while($row = mysql_fetch_assoc($result)) {
                                 $famnum += $row['pointValue'];
                       }

	mysql_query("UPDATE Family SET familyPoints = $famnum WHERE familyID = 3")
		or die("Failed query: ".mysql_error());

                      // FAMILY 4

                      $result = mysql_query("SELECT pointValue FROM Member JOIN (AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID) ON Member.memberID = AttendsEvent.memberID WHERE familyID = 4 AND (status = 'probate' OR status = 'member' OR status = 'social')")
                                 or die("Failed query: ".mysql_error());
                      $famnum = 0;
                      while($row = mysql_fetch_assoc($result)) {
                                 $famnum += $row['pointValue'];
                       }

	mysql_query("UPDATE Family SET familyPoints = $famnum WHERE familyID = 4")
		or die("Failed query: ".mysql_error());
		
	//CALCULATE RANK
	//-------------------------------
	
	$result3 = mysql_query("SELECT memberID FROM Member WHERE status='probate' OR status='member' OR status='social' ORDER BY memberPoints DESC, lastName")
		or die("Failed query: ".mysql_error());

	$count1 = 0;

	while($row = mysql_fetch_assoc($result3))
		{
		$count1++;
		if($row['memberID'] == $memberID)
			{
			$rank = $count1;
			}
		}

	// SHOW USER'S TOTAL POINTS AND RANK
	//------------------------------------
?>	


<div id="wrapper">
	<div id="scroller">
		<ul id="thelist">
			<li><div><img src="images/rrclogo.png" /></div><div class="bottomPlaque"> <?php echo($firstName) ?>&nbsp;<?php echo($lastName) ?></div></li>
			<li><div class="points"><?php echo($num)?></div></li>
			<li><div class="rank"><?php echo($rank)?></div></li>
			<li><div class="events"><?php echo($events)?></div></li>
			<li><strong>Lyuben Dilov's Forth law:</strong> <em>A robot must establish its identity as a robot in all cases.</em></li>
			<li><strong>Harry Harrison's Forth law:</strong> <em>A robot must reproduce. As long as such reproduction does not interfere with the First or Second or Third Law.</em></li>
			<li><strong>Nikola Kesarovski's Fifth law:</strong> <em>A robot must know it is a robot.</em></li>
		</ul>
	</div>
</div>
<div id="mobile_nav">
<img src="images/mobileRRCnav_01.png" /><img src="images/mobileRRCnav_02.png" /><img src="images/mobileRRCnav_03.png" />
</div>
</body>
</html>
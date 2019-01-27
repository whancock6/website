<?php
session_start();
if(!isset($_SESSION[username])){
	header("location:mobile_memberLoginForm.php");
}
$db_username="reck";
$db_password="burdell";
$database="reck_club";
$hostname="mysql.localhost";         

$dsn = 'mysql:host=mysql.localhost;dbname=reck_club';
$db= new PDO($dsn, $db_username, $db_password);



if(isset($_SESSION[username])){
	$userId = $_SESSION[memberID];
}

$userInfo= $db->prepare("SELECT * FROM Member WHERE memberID=:user");
$userInfo->bindValue("user",$userId, PDO::PARAM_STR);
$userInfo->execute();

$stmt= $db->prepare("SELECT * FROM Member WHERE status='probate' OR status='member' OR status='social' ORDER BY firstName");
$stmt->execute();

$allCon= $db->prepare("SELECT * FROM Member WHERE status='probate' OR status='member' OR status='social' ORDER BY firstName");
$allCon->execute();
$results=$allCon->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);

$rankCalc=$db->prepare("SELECT memberID FROM Member WHERE status='probate' OR status='member' OR status='social' ORDER BY memberPoints DESC, lastName");
$rankCalc->execute();
$count = 0;
$rank=0;
while($row = $rankCalc->fetch(PDO::FETCH_ASSOC))
	{
		$count++;
		if($row[memberID] == $userId)
			{
			$rank = $count;
			}
	}


$rankings = $db->prepare("SELECT firstName, lastName, memberPoints, memberID,status FROM Member WHERE status='probate' OR status='member' OR status='social' ORDER BY memberPoints DESC, lastName");
$rankings->execute();

$members = $db->prepare("SELECT firstName, lastName, memberPoints, memberID FROM Member WHERE status='member' ORDER BY memberPoints DESC, lastName");
$members->execute();

$probates = $db->prepare("SELECT firstName, lastName, memberPoints, memberID FROM Member WHERE status='probate' ORDER BY memberPoints DESC, lastName");
$probates->execute();

$families = $db->prepare("SELECT familyName, familyPoints FROM Family ORDER BY familyPoints DESC, familyName");
$families->execute();

$currentMonth=date(m);
$events = $db->prepare("SELECT * FROM Event WHERE dateMonth =:month AND isFamilyEvent = '0' ORDER BY dateDay, eventName");
$events->bindValue("month",$currentMonth, PDO::PARAM_STR);
$events->execute();

$messages= $db->prepare("SELECT * FROM `Messages` ORDER BY date DESC LIMIT 10");
$messages->execute();

?>


<!DOCTYPE html> 
<html> 
<head> 
	<title>RRC Mobile</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<link href='http://fonts.googleapis.com/css?family=Signika:600' rel='stylesheet' type='text/css'>
	<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone4.png" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script>
	var currentMonth="<?php echo($currentMonth);?>";
	function createObject() {
		
		var request_type;
		var browser = navigator.appName;
		if(browser == "Microsoft Internet Explorer"){
		request_type = new ActiveXObject("Microsoft.XMLHTTP");
		}else{
		request_type = new XMLHttpRequest();
		}
		return request_type;
		}
	
	$(document).ready(function() {
		$('#months option[value='+currentMonth+']').attr('selected', true);
		$('select').selectmenu();
		$('select').selectmenu('refresh');
		
	
		var http = createObject();
		$(document).bind("ready", function() {
			$("#months").live("change", function() {
				$.mobile.showPageLoadingMsg();	
				$('#eventList').empty();
				currentMonth = $('#months').val();
				var nocache = Math.random();
				http.open('get', 'getEvents.php?month='+currentMonth+'&nocache='+nocache);
				http.onreadystatechange = changeEvents;
				http.send(null);				
			});
		});

			
		/**$('#months').unbind('change').change(function(){
			
			return false;
		});**/
		function changeEvents(){
			//alert("fuck");
			if(http.readyState == 4){
				var response = http.responseText;
				$('#eventList').append(response).trigger('create');
				$.mobile.hidePageLoadingMsg();	
			}
		}
		
		
	});
/**	
$(document).bind("pagebeforechange", function(e, data) {
	// We only want to handle changePage() calls where the caller is asking to load a page by URL.
	if (typeof data.toPage === "string") {
	// We only want to handle #qrcode url.
	
		if (data.toPage.indexOf("#profile") !== -1) {
			var hashes=data.toPage.split('?');	
			console.log(hashes[1]);
			$.mobile.changePage("#profile");
		}
	}
}); **/
var jsonObj = <?php echo($json);?>;

function profilePage(id){
	for (var i = 0; i < jsonObj.length; i++) {
			if(jsonObj[i].memberID == id){
				$('#profileName').text(jsonObj[i].firstName+" "+jsonObj[i].lastName);
				$('#profileStatus').text(jsonObj[i].status);
				$('#profileTel').text(jsonObj[i].phone);
				$('#profileEmail').text(jsonObj[i].email);
				$('#profileClass').text(jsonObj[i].gradYear);
				$('#profileTwitter').text(jsonObj[i].twitter);
				
				
			}
    // ...
	}
	
	//alert(jsonObj[0].firstName);
	$.mobile.changePage("#profile");
}


	</script>

<style>
.ui-btn-inline {
    *display : inline !important;
    zoom     : 1;
}
</style>	
	
	</head> 
<body> 

<div data-role="page" id="home" style="background:#CCB67C">
<div data-role="content" style="font-size:55px; text-shadow:none; color: #fff; font-family: 'Signika', sans-serif;">
		<center>
				<?php
					$row = $userInfo->fetch(PDO::FETCH_ASSOC);
					$memberPoints = $row[memberPoints];
				?>
				<div style="margin:0px; padding: 0px;">
					<?php echo($rank." ");?> rnk
				</div>
				<div style="margin:0px; padding: 0px;">
					<?php echo($memberPoints." ");?> pts
				</div>
				<div style="margin:0px; padding: 0px;">
					<?php 
					$eventCount=$row[mandatoryEventCount]+$row[sportsEventCount]+$row[socialEventCount]+$row[workEventCount];
					
					echo($eventCount." ");?> evt
				</div>
		</center>
		<a href="#points" data-role="button" style="margin:0.3em;">ADD POINTS</a>
		<a href="mobile_logOut.php" data-role="button" style="margin:0.3em;" rel="external">LOG OUT</a>
		<a href="#messages" data-role="button" style="margin:0.3em;">PLEASE DO NOT CLICK</a>
    </div>
	
	
	
	<div data-role="navbar"  data-position="fixed">
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>

	
</div><!-- /page -->

<div data-role="page" id="points" style="background:#fff">
	<select id="months" name="select-choice-1" class="months">
		<option value="01">January</option>
		<option value="02">February</option>
		<option value="03">March</option>
		<option value="04">April</option>
		<option value="05">May</option>
		<option value="06">June</option>
		<option value="07">July</option>
		<option value="08">August</option>
		<option value="09">September</option>
		<option value="10">October</option>
		<option value="11">November</option>
		<option value="12">December</option>
	</select>
	<fieldset data-role="controlgroup">
	<form id="eventList" action="mobile_updatePoints.php" method="post" data-ajax="false">
	   <?php
						while($row = $events->fetch(PDO::FETCH_ASSOC))
						{
							
							$eventId = $row[eventID];
							$myEvent = $db->prepare("SELECT * FROM AttendsEvent WHERE eventID =:event AND memberID =:user");
							$myEvent->bindValue("event",$eventId, PDO::PARAM_STR);
							$myEvent->bindValue("user",$userId, PDO::PARAM_STR);
							$myEvent->execute();
							
							$eventName = $row[eventName];
							$dateMonth = $row[dateMonth];
							$dateDay = $row[dateDay];
							$dateYear = $row[dateYear];
							$pointValue = $row[pointValue];
							echo"<input type=\"checkbox\" name=\"".$eventId."\" id=\"checkbox-".$eventId."\" class=\"custom\"";
							if($myEvent->rowCount()==1){
								echo("checked=\"true\"");
							}
							echo "/>";
							echo"<label for=\"checkbox-".$eventId."\"><span style=\"float:left;width:60%;\">".$eventName."</span><span>".$dateMonth."/".$dateDay."</span><span style=\"float:right;\">".$pointValue."</span></label>";
						}
		?>
		<input type="hidden" name="month" value="<?php echo($currentMonth);?>">
	   <input type="submit" value="Update" data-theme="a">
	</form>
    </fieldset>
	<div data-role="navbar" data-position="fixed">
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>

	
</div><!-- /page -->



<!-- Start of second page -->
<div data-role="page" id="rankings" style="background:#fff">
	<ul data-role="listview">
	<div data-role="navbar">
		<ul>
			<li><a href="#rankings" class="ui-btn-active ui-state-persist">All</a></li>
			<li><a href="#members">Members</a></li>
			<li><a href="#probates">Probates</a></li>
			<li><a href="#families">Families</a></li>
		</ul>
	</div>
	<li><span style="float:left; width:30%;">Rank</span><span style="width:20%;text-align:center;">Name</span><span style="float:right;">Points</span></li>
	<?php
		$rank=1;
		while($row = $rankings->fetch(PDO::FETCH_ASSOC))
		{
			$firstName = $row[firstName];
			$lastName = $row[lastName];
			$memberPoints = $row[memberPoints];
			echo"<li><span style=\"float:left; width:30%;\">".$rank."</span><span style=\"width:20%;text-align:center;\">".$firstName." ".$lastName."</span><span style=\"float:right;\">".$memberPoints."</span></li>";
			$rank++;
		}
	
	?>
	
</ul>
	<div data-role="navbar" data-position="fixed">
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>

	
</div><!-- /page -->

<!-- Start of second page -->
<div data-role="page" id="members" style="background:#CCB67C">
	<ul data-role="listview">
	<div data-role="navbar">
		<ul>
			<li><a href="#rankings" >All</a></li>
			<li><a href="#members" class="ui-btn-active ui-state-persist">Members</a></li>
			<li><a href="#probates">Probates</a></li>
			<li><a href="#families">Families</a></li>
		</ul>
	</div>
	<li><span style="float:left; width:30%;">Rank</span><span style="width:20%;text-align:center;">Name</span><span style="float:right;">Points</span></li>
	<?php
		$rank=1;
		while($row = $members->fetch(PDO::FETCH_ASSOC))
		{
			$status=$row[status];
			
				$firstName = $row[firstName];
				$lastName = $row[lastName];
				$memberPoints = $row[memberPoints];
				echo"<li><span style=\"float:left; width:30%;\">".$rank."</span><span style=\"width:20%;text-align:center;\">".$firstName." ".$lastName."</span><span style=\"float:right;\">".$memberPoints."</span></li>";
				$rank++;

		}
	
	?>
	
</ul>
	<div data-role="navbar" data-position="fixed">
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>
	
</div><!-- /page -->

<!-- Start of second page -->
<div data-role="page" id="probates" style="background:#CCB67C">
	<ul data-role="listview">
	<div data-role="navbar">
		<ul>
			<li><a href="#rankings" >All</a></li>
			<li><a href="#members" >Members</a></li>
			<li><a href="#probates" class="ui-btn-active ui-state-persist">Probates</a></li>
			<li><a href="#families">Families</a></li>
		</ul>
	</div>
	<li><span style="float:left; width:30%;">Rank</span><span style="width:20%;text-align:center;">Name</span><span style="float:right;">Points</span></li>
	<?php
		$rank=1;
		while($row = $probates->fetch(PDO::FETCH_ASSOC))
		{
			$status=$row[status];
			
				$firstName = $row[firstName];
				$lastName = $row[lastName];
				$memberPoints = $row[memberPoints];
				echo"<li><span style=\"float:left; width:30%;\">".$rank."</span><span style=\"width:20%;text-align:center;\">".$firstName." ".$lastName."</span><span style=\"float:right;\">".$memberPoints."</span></li>";
				$rank++;

		}
	
	?>
	
</ul>
	<div data-role="navbar" data-position="fixed">
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>

	
</div><!-- /page -->

<!-- Start of second page -->
<div data-role="page" id="families" style="background:#CCB67C">
	<ul data-role="listview">
	<div data-role="navbar">
		<ul>
			<li><a href="#rankings" >All</a></li>
			<li><a href="#members" >Members</a></li>
			<li><a href="#probates">Probates</a></li>
			<li><a href="#families" class="ui-btn-active ui-state-persist">Families</a></li>
		</ul>
	</div>
	<li><span style="float:left; width:30%;">Rank</span><span style="width:20%;text-align:center;">Family</span><span style="float:right;">Points</span></li>
	<?php
		$rank=1;
		while($row = $families->fetch(PDO::FETCH_ASSOC))
		{
			$status=$row[status];
			
				$familyName = $row[familyName];
				$familyPoints = $row[familyPoints];
				echo"<li><span style=\"float:left; width:30%;\">".$rank."</span><span style=\"width:20%;text-align:center;\">".$familyName."</span><span style=\"float:right;\">".$familyPoints."</span></li>";
				$rank++;

		}
	
	?>
	
</ul>
	<div data-role="navbar" data-position="fixed">
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>

	
</div><!-- /page -->

<!-- Start of third page -->
<div data-role="page" id="contacts" style="background:#fff">
<div data-role="content">
<ul data-role="listview" data-filter="true" data-filter-placeholder="Search people..." data-filter-theme="d" data-autodividers="true" data-divider-theme="a" >
	<?php
						while($row = $stmt->fetch(PDO::FETCH_ASSOC))
						{
							$firstName = $row[firstName];
							$lastName = $row[lastName];
							$contactId = $row[memberID];
							echo "<li><a href=\"javascript:profilePage(".$contactId.")\">" . $firstName ." ". $lastName ."</a></li>";
						}
	?>
</ul>
</div>
	<div data-role="navbar" data-position="fixed">
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>

	
</div><!-- /page -->

<!-- Start of third page -->
<div data-role="page" id="profile" style="background:#CCB67C; font-family: 'Signika', sans-serif;" >
<div data-role="content">
	<h1 style="color:#fff;" id="profileName">David Byas-Smith</h1>
	<ul data-role="listview" data-inset="true" >
		<li>Status: <span id="profileStatus">Member</span></li>
		<li>Phone: <span id="profileTel">404-783-2256</li>
		<li>Email: <span id="profileEmail">dbyassmith@gmail.com</li>
		<li>Graduating Class: <span id="profileClass">2013</span></li>
		<li>Twitter: <span id="profileTwitter">gtdbs</span></li>
	</ul>
	<a href="#contacts" data-role="button" style="margin:0.3em;" data-theme="a">Back</a>
</div>
	<div data-role="navbar" data-position="fixed">
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>

	
</div><!-- /page -->
<!-- Start of second page -->
<div data-role="page" id="messages" style="background:#fff">
<div data-role="header"> 
	<h1>Chat</h1> 
	<a href="index.html" data-icon="refresh" class="ui-btn-right" >Refresh</a>
</div> 
	<ul data-role="listview" data-divider-theme="a"	>
		
		<?php
		while($row = $messages->fetch(PDO::FETCH_ASSOC))
		{
			$sql_date = $row[date];
			$date = date("h:ia",strtotime($sql_date));
			echo("<li><div style=\"float:left;\">".$row[user]."</div><div style=\"float:right;\">".$date."</div><div style=\"clear:both;\"></div><div style=\"font-size: 12px;font-weight: normal; float:left;\">".$row[message]."</div><div style=\"clear:both;\"></div>");			
		}
		?>
	</ul>
	<input type="button" value="Load More Messages" data-theme="a">
	
	
	
	
	<div data-position="fixed" style="background:#fff">
	<form action="mobile_submitMessage.php" method="post" data-ajax="false">	
	<div data-role="fieldcontain"  >
	
		<textarea name="message" id="textarea" style="width:70%; float:left;"></textarea><input type="submit" value="Send" data-theme="a" data-inline="true">
		
	</div>
	</form>
	<div data-role="navbar">
		
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>
	</div>

	
</div><!-- /page -->
<!-- Start of second page -->
<div data-role="page" id="addEvent" style="background:#CCB67C">
	<form>
		<input type="text" name="name" id="basic" value="" placeholder="Event Name" />
	
		<div data-role="fieldcontain">
			<select name="select-choice-0" id="select-choice-0">
			   <option value="standard">Mandatory</option>
			   <option value="rush">Sports</option>
			   <option value="express">Social</option>
			   <option value="overnight">Work</option>
			</select>
		</div>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup" data-type="horizontal"> 
				<select id="select-choice-month" name="select-choice-month">
					<option value="jan">Jan</option>
					<option value="dec">Dec</option>
					<option value="feb">Feb</option>
					<option value="mar">Mar</option>
					<option value="apr">Apr</option>
					<option value="may">May</option>
					<option value="jun">Jun</option>
					<option value="jul">Jul</option>
					<option value="aug">Aug</option>
					<option value="sep">Sep</option>
					<option value="oct">Oct</option>
					<option value="nov">Nov</option>
					<option value="dec">Dec</option>
				</select>
				<select id="select-choice-day" name="select-choice-day">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">13</option>
					<option value="13">14</option>
					<option value="15">15</option>
				</select>
			 </fieldset>
		</div>
		
<input type="range" name="slider-step" id="slider-step" value="0" min="0" max="30" step="5" data-highlight="true"/> 
	</form>
	<div data-role="navbar">
		
		<ul>
			<li><a href="#home" data-icon="home">Home</a></li>
			<li><a href="#rankings" data-icon="star">Rankings</a></li>
			<li><a href="#contacts" data-icon="search">Contacts</a></li>
		</ul>
	</div>
	</div>

	
</div><!-- /page -->
</body>
</html>
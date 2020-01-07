<?php
	require "logged_in_check.php";
	require "set_session_vars_short.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	if($_POST[email]=="") { $_POST[email] = NULL; }
	if($_POST[phone]=="") { $_POST[phone] = NULL; }
	if($_POST[twitter]=="") { $_POST[twitter] = NULL; }
	if($_POST[streetAddress]=="") { $_POST[streetAddress] = NULL; }
	if($_POST[city]=="") { $_POST[city] = NULL; }
	if($_POST[state]=="") { $_POST[state] = NULL; }	
	if($_POST[zipCode]=="") { $_POST[zipCode] = NULL; }
    if($_POST[status]=="") { $_POST[status] = NULL; }
    if($_POST[joinYear]=="") { $_POST[joinYear] = NULL; }
	if($_POST[gradMonth]=="") { $_POST[gradMonth] = NULL; }
	if($_POST[gradYear]=="") { $_POST[gradYear] = NULL; }
	if($_POST[reckerPair]=="") { $_POST[reckerPair] = NULL; }

    if($_POST["memberID"]=="") { $_POST["memberID"] = $memberID; }
//    echo $_POST["memberID"];

	$query = $db->prepare("UPDATE Member SET firstName=:firstName, lastName=:lastName, email=:email, phone=:phone, twitter=:twitter, streetAddress=:streetAddress, 
		city=:city, state=:state, zipCode=:zipCode, status=:status, joinYear=:joinYear, gradMonth=:gradMonth, gradYear=:gradYear, reckerPair=:reckerPair WHERE memberID = :memberID");
	$query->execute(array('firstName'=>$_POST[firstName], 'lastName'=>$_POST[lastName], 'email'=>$_POST[email], 'phone'=>$_POST[phone], 'twitter'=>$_POST[twitter], 
		'streetAddress'=>$_POST[streetAddress], 'city'=>$_POST[city], 'state'=>$_POST[state], 'zipCode'=>$_POST[zipCode], 'status'=>$_POST[status],
        'joinYear'=>$_POST[joinYear], 'gradMonth'=>$_POST[gradMonth], 'gradYear'=>$_POST[gradYear],
        'reckerPair'=>$_POST[reckerPair], 'memberID'=>$_POST["memberID"]));

	$_SESSION[firstName] = $_POST[firstName];
	$_SESSION[lastName] = $_POST[lastName];
	$_SESSION[email] = $_POST[email];
	$_SESSION[phone] = $_POST[phone];
	$_SESSION[twitter] = $_POST[twitter];
	$_SESSION[streetAddress] = $_POST[streetAddress];
	$_SESSION[city] = $_POST[city];
	$_SESSION[state] = $_POST[state];
	$_SESSION[zipCode] = $_POST[zipCode];
	$_SESSION[status] = $_POST[status];
	$_SESSION[joinYear] = $_POST[joinYear];
	$_SESSION[gradMonth] = $_POST[gradMonth];
	$_SESSION[gradYear] = $_POST[gradYear];
	$_SESSION[reckerPair] = $_POST[reckerPair];
?>

<br/><br/><br/>
<h3>Profile Updated</h3><meta http-equiv="refresh" content="2; url=memberProfile.php?memberId=<?php echo $_POST["memberID"]; ?>">

<?php require "html_footer.txt"; ?>
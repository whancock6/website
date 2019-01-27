<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";

	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	$db->query("DROP TABLE IF EXISTS AttendsEvent");
	$db->query("DROP TABLE IF EXISTS Event");
	$db->query("DROP TABLE IF EXISTS HoldsPosition");
	$db->query("DROP TABLE IF EXISTS Position");
	$db->query("DROP TABLE IF EXISTS MemberLineItem");
	$db->query("DROP TABLE IF EXISTS LineItem");
	$db->query("DROP TABLE IF EXISTS Payment");
	$db->query("DROP TABLE IF EXISTS OnCommittee");
	$db->query("DROP TABLE IF EXISTS Committee");
	$db->query("DROP TABLE IF EXISTS Member");
	$db->query("DROP TABLE IF EXISTS Family");
	$db->query("DROP TABLE IF EXISTS Messages");
	$db->query("DROP TABLE IF EXISTS Docs");

	$db->query("CREATE TABLE Docs LIKE Docs_bkup");
	$db->query("CREATE TABLE Messages LIKE Messages_bkup");
	$db->query("CREATE TABLE Family LIKE Family_bkup");
	$db->query("CREATE TABLE Member LIKE Member_bkup");
	$db->query("CREATE TABLE Committee LIKE Committee_bkup");
	$db->query("CREATE TABLE OnCommittee LIKE OnCommittee_bkup");
	$db->query("CREATE TABLE Payment LIKE Payment_bkup");
	$db->query("CREATE TABLE LineItem LIKE LineItem_bkup");
	$db->query("CREATE TABLE MemberLineItem LIKE MemberLineItem_bkup");
	$db->query("CREATE TABLE Position LIKE Position_bkup");
	$db->query("CREATE TABLE HoldsPosition LIKE HoldsPosition_bkup");
	$db->query("CREATE TABLE Event LIKE Event_bkup");
	$db->query("CREATE TABLE AttendsEvent LIKE AttendsEvent_bkup");

	$db->query("INSERT INTO Docs SELECT * FROM Docs_bkup");
	$db->query("INSERT INTO Messages SELECT * FROM Messages_bkup");
	$db->query("INSERT INTO Family SELECT * FROM Family_bkup");
	$db->query("INSERT INTO Member SELECT * FROM Member_bkup");
	$db->query("INSERT INTO Committee SELECT * FROM Committee_bkup");
	$db->query("INSERT INTO OnCommittee SELECT * FROM OnCommittee_bkup");
	$db->query("INSERT INTO Payment SELECT * FROM Payment_bkup");
	$db->query("INSERT INTO LineItem SELECT * FROM LineItem_bkup");
	$db->query("INSERT INTO MemberLineItem SELECT * FROM MemberLineItem_bkup");
	$db->query("INSERT INTO Position SELECT * FROM Position_bkup");
	$db->query("INSERT INTO HoldsPosition SELECT * FROM HoldsPosition_bkup");
	$db->query("INSERT INTO Event SELECT * FROM Event_bkup");
	$db->query("INSERT INTO AttendsEvent SELECT * FROM AttendsEvent_bkup");

	echo "<h3>Reverted to Previous Version of Database</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageWebsite.php\">";
	
	require "html_footer.txt";
?>
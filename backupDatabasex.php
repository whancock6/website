<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";

	require "html_header_begin.txt";
	require "html_header_end.txt";

	$db->query("DELETE FROM BackupLog");
	$db->query("INSERT INTO BackupLog (LastBackupDate) VALUES (NOW())");

	$db->query("DROP TABLE IF EXISTS AttendsEvent_bkup");
	$db->query("DROP TABLE IF EXISTS Event_bkup");
	$db->query("DROP TABLE IF EXISTS HoldsPosition_bkup");
	$db->query("DROP TABLE IF EXISTS Position_bkup");
	$db->query("DROP TABLE IF EXISTS MemberLineItem_bkup");
	$db->query("DROP TABLE IF EXISTS LineItem_bkup");
	$db->query("DROP TABLE IF EXISTS Payment_bkup");
	$db->query("DROP TABLE IF EXISTS OnCommittee_bkup");
	$db->query("DROP TABLE IF EXISTS Committee_bkup");
	$db->query("DROP TABLE IF EXISTS Member_bkup");
	$db->query("DROP TABLE IF EXISTS Family_bkup");
	$db->query("DROP TABLE IF EXISTS Messages_bkup");
	$db->query("DROP TABLE IF EXISTS Docs_bkup");

	$db->query("CREATE TABLE Docs_bkup LIKE Docs");
	$db->query("CREATE TABLE Messages_bkup LIKE Messages");
	$db->query("CREATE TABLE Family_bkup LIKE Family");
	$db->query("CREATE TABLE Member_bkup LIKE Member");
	$db->query("CREATE TABLE Committee_bkup LIKE Committee");
	$db->query("CREATE TABLE OnCommittee_bkup LIKE OnCommittee");
	$db->query("CREATE TABLE Payment_bkup LIKE Payment");
	$db->query("CREATE TABLE LineItem_bkup LIKE LineItem");
	$db->query("CREATE TABLE MemberLineItem_bkup LIKE MemberLineItem");
	$db->query("CREATE TABLE Position_bkup LIKE Position");
	$db->query("CREATE TABLE HoldsPosition_bkup LIKE HoldsPosition");
	$db->query("CREATE TABLE Event_bkup LIKE Event");
	$db->query("CREATE TABLE AttendsEvent_bkup LIKE AttendsEvent");

	$db->query("INSERT INTO Docs_bkup SELECT * FROM Docs");
	$db->query("INSERT INTO Messages_bkup SELECT * FROM Messages");
	$db->query("INSERT INTO Family_bkup SELECT * FROM Family");
	$db->query("INSERT INTO Member_bkup SELECT * FROM Member");
	$db->query("INSERT INTO Committee_bkup SELECT * FROM Committee");
	$db->query("INSERT INTO OnCommittee_bkup SELECT * FROM OnCommittee");
	$db->query("INSERT INTO Payment_bkup SELECT * FROM Payment");
	$db->query("INSERT INTO LineItem_bkup SELECT * FROM LineItem");
	$db->query("INSERT INTO MemberLineItem_bkup SELECT * FROM MemberLineItem");
	$db->query("INSERT INTO Position_bkup SELECT * FROM Position");
	$db->query("INSERT INTO HoldsPosition_bkup SELECT * FROM HoldsPosition");
	$db->query("INSERT INTO Event_bkup SELECT * FROM Event");
	$db->query("INSERT INTO AttendsEvent_bkup SELECT * FROM AttendsEvent");

	echo "<h3>Database Backed Up</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageWebsite.php\">";

	require "html_footer.txt";
?>
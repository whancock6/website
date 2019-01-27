<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isTreasurer]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
?>

<?php
	$unitCostDollars=$_POST[newUnitCostDollars];
	
	if($_POST[newUnitCostCents]==""){
			$unitCostCents=0;
	} else {
			$unitCostCents=$_POST[newUnitCostCents];
	}
	
	$unitCost = $unitCostDollars + ($unitCostCents * .01);
	
	if($_POST[newDescription]=="") {
			$description=NULL;
	} else {
			$description=$_POST[newDescription];
	}
	
	$query = $db->prepare("UPDATE LineItem SET lineItemName=:lineItemName, dateYear=:dateYear, dateMonth=:dateMonth, dateDay=:dateDay, unitCost=:unitCost, description=:description WHERE lineItemID=:lineItemID");
	$query->execute(array('lineItemName'=>$_POST[newLineItemName], 'dateYear'=>$_POST[newDateYear], 'dateMonth'=>$_POST[newDateMonth], 'dateDay'=>$_POST[newDateDay], 'unitCost'=>$unitCost, 'description'=>$description, 'lineItemID'=>$_POST[lineItemID]));

	echo "<h3>Line Item Updated</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageLineItems.php?dateMonth=".$_POST[newDateMonth]."&dateDay=".$_POST[newDateDay]."&dateYear=".$_POST[newDateYear]."&lineItemID=".$_POST[lineItemID]."\">";
?>

<?php require "html_footer.txt"; ?>
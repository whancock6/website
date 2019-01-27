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
	$unitCostDollars=$_POST[unitCostDollars];
	
	if($_POST[unitCostCents]==""){
			$unitCostCents=0;
	} else {
			$unitCostCents=$_POST[unitCostCents];
	}
	
	$unitCost = $unitCostDollars + ($unitCostCents * .01);
	
	if($_POST[description]=="" OR $_POST[description]=="<description>") {
			$description=NULL;
	} else {
			$description=$_POST[description];
	}

   	$query = $db->prepare("INSERT INTO LineItem (lineItemName, dateYear, dateMonth, dateDay, unitCost, description) VALUES (:lineItemName, :dateYear, :dateMonth, :dateDay, :unitCost, :description)");
	$query->execute(array('lineItemName'=>$_POST[lineItemName], 'dateYear'=>$_POST[dateYear], 'dateMonth'=>$_POST[dateMonth], 'dateDay'=>$_POST[dateDay], 'unitCost'=>$unitCost, 'description'=>$description));

	if(isset($_POST[create])) {
		echo "<h3>Line Item Created</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=manageLineItems.php\">";
	}
	
	if(isset($_POST[createPlus])) {
	   	$query2 = $db->prepare("SELECT lineItemID FROM LineItem WHERE lineItemName=:lineItemName AND dateYear=:dateYear AND dateMonth=:dateMonth AND dateDay=:dateDay AND unitCost=:unitCost AND description=:description");
		$query2->execute(array('lineItemName'=>$_POST[lineItemName], 'dateYear'=>$_POST[dateYear], 'dateMonth'=>$_POST[dateMonth], 'dateDay'=>$_POST[dateDay], 'unitCost'=>$unitCost, 'description'=>$description));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query2->fetch();
		$lineItemID = $row[lineItemID];
				
		echo "<h3>Line Item Created</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=applyLineItems.php?dateMonth=".$_POST[dateMonth]."&dateDay=".$_POST[dateDay]."&dateYear=".$_POST[dateYear]."&lineItemID=".$lineItemID."\">";
	}
?>

<?php require "html_footer.txt"; ?>
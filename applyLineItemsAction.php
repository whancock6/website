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
	$lineItemID = $_POST[lineItemID];
   	$query = $db->prepare("SELECT dateDay, dateMonth, dateYear FROM LineItem WHERE lineItemID=:lineItemID");
	$query->execute(array('lineItemID'=>$lineItemID));
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch())  {
		$dateDay=$row[dateDay];
		$dateMonth=$row[dateMonth];
		$dateYear=$row[dateYear];
	}
	if(isset($_POST[individual])){
	   	$query2 = $db->query("SELECT memberID FROM Member WHERE status != 'alumni'");
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $query2->fetch())  {
			$tempMemberID = $row[memberID];
		   	$query3 = $db->prepare("SELECT * FROM MemberLineItem WHERE memberID=:tempMemberID AND lineItemID=:lineItemID");
			$query3->execute(array('tempMemberID'=>$tempMemberID, 'lineItemID'=>$lineItemID));
				$query3->setFetchMode(PDO::FETCH_ASSOC);
			$num_results = $query3->rowCount();
			if($_POST[$tempMemberID]!="" && $_POST[$tempMemberID]!=0){
				if($num_results == 0) {
				   	$query4 = $db->prepare("INSERT INTO MemberLineItem (memberID, lineItemID, quantity) VALUES (:tempMemberID, :lineItemID, :quantity)");
					$query4->execute(array('tempMemberID'=>$tempMemberID, 'lineItemID'=>$lineItemID, 'quantity'=>$_POST[$tempMemberID]));
				} else {
				   	$query4 = $db->prepare("UPDATE MemberLineItem SET quantity=:quantity WHERE memberID=:tempMemberID AND lineItemID=:lineItemID");
					$query4->execute(array('quantity'=>$_POST[$tempMemberID], 'tempMemberID'=>$tempMemberID, 'lineItemID'=>$lineItemID));
				}
			} else {
				if($num_results == 1) {
				   	$query4 = $db->prepare("DELETE FROM MemberLineItem WHERE memberID=:tempMemberID AND lineItemID=:lineItemID");
					$query4->execute(array('tempMemberID'=>$tempMemberID, 'lineItemID'=>$lineItemID));
				} else {}
			}
		}
	} elseif(isset($_POST[all])){
		$quantity = $_POST[allQuantity];
	   	$query2 = $db->query("SELECT memberID FROM Member WHERE status != 'alumni'");
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $query2->fetch())  {
			$tempMemberID = $row[memberID];
		   	$query3 = $db->prepare("SELECT * FROM MemberLineItem WHERE memberID=:tempMemberID AND lineItemID=:lineItemID");
			$query3->execute(array('tempMemberID'=>$tempMemberID, 'lineItemID'=>$lineItemID));
				$query3->setFetchMode(PDO::FETCH_ASSOC);
			$num_results = $query3->rowCount();
			if($quantity!="" && $quantity!=0){
				if($num_results == 0) {
				   	$query4 = $db->prepare("INSERT INTO MemberLineItem (memberID, lineItemID, quantity) VALUES (:tempMemberID, :lineItemID, :quantity)");
					$query4->execute(array('tempMemberID'=>$tempMemberID, 'lineItemID'=>$lineItemID, 'quantity'=>$quantity));
				} else {
				   	$query4 = $db->prepare("UPDATE MemberLineItem SET quantity=:quantity WHERE memberID=:tempMemberID AND lineItemID=:lineItemID");
					$query4->execute(array('quantity'=>$quantity, 'tempMemberID'=>$tempMemberID, 'lineItemID'=>$lineItemID));
				}
			} else {
				if($num_results == 1) {
				   	$query4 = $db->prepare("DELETE FROM MemberLineItem WHERE memberID=:tempMemberID AND lineItemID=:lineItemID");
					$query4->execute(array('tempMemberID'=>$tempMemberID, 'lineItemID'=>$lineItemID));
				} else {}
			}
		}	
	}


echo "<h3>Line Item Applied to Members</h3>";
echo "<meta http-equiv=\"refresh\" content=\"2; url=applyLineItems.php?dateMonth=".$dateMonth."&dateDay=".$dateDay."&dateYear=".$dateYear."&lineItemID=".$lineItemID."\">";

?>

<?php require "html_footer.txt"; ?>
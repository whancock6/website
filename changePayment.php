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
   	$query = $db->prepare("SELECT paymentID FROM Payment WHERE memberID=:memberID");
	$query->execute(array('memberID'=>$_POST[memberID]));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		
	while($row = $query->fetch()){
		$paymentID=$row[paymentID];
		
		if(isset($_POST[update.$paymentID]) || isset($_POST[updateAll])){
			if($_POST[newAmountDollars.$paymentID]!="" && $_POST[newAmountDollars.$paymentID]!=0){
				$amountDollars=$_POST[newAmountDollars.$paymentID];
				if($_POST[newAmountCents.$paymentID]==""){
						$amountCents=0;
				} else {
						$amountCents=$_POST[newAmountCents.$paymentID];
				}
				$amount = $amountDollars + ($amountCents * .01);
				$newDateYear = $_POST[newDateYear.$paymentID];
				$newDateMonth = $_POST[newDateMonth.$paymentID];
				$newDateDay = $_POST[newDateDay.$paymentID];
				$newMethodOfPayment = $_POST[newMethodOfPayment.$paymentID];
				$newCheckNumber = $_POST[newCheckNumber.$paymentID];
				$null = NULL;
				
				if(($newMethodOfPayment=="check" || $newMethodOfPayment=="credit" || $newMethodOfPayment=="reimbursement") && $newCheckNumber!=""){
				   	$query2 = $db->prepare("UPDATE Payment SET memberID=:memberID, dateYear=:dateYear, dateMonth=:dateMonth, dateDay=:dateDay, amount=:amount, methodOfPayment=:methodOfPayment, checkNumber=:checkNumber WHERE paymentID=:paymentID");
					$query2->execute(array('memberID'=>$_POST[memberID], 'dateYear'=>$newDateYear, 'dateMonth'=>$newDateMonth, 'dateDay'=>$newDateDay, 'amount'=>$amount, 'methodOfPayment'=>$newMethodOfPayment, 'checkNumber'=>$newCheckNumber, 'paymentID'=>$paymentID));
				} else {
				   	$query2 = $db->prepare("UPDATE Payment SET memberID=:memberID, dateYear=:dateYear, dateMonth=:dateMonth, dateDay=:dateDay, amount=:amount, methodOfPayment=:methodOfPayment, checkNumber=:checkNumber WHERE paymentID=:paymentID");
					$query2->execute(array('memberID'=>$_POST[memberID], 'dateYear'=>$newDateYear, 'dateMonth'=>$newDateMonth, 'dateDay'=>$newDateDay, 'amount'=>$amount, 'methodOfPayment'=>$newMethodOfPayment, 'checkNumber'=>$null, 'paymentID'=>$paymentID));
				}
					
				echo "<h3>Payment Updated</h3>";
				echo "<meta http-equiv=\"refresh\" content=\"2; url=managePayments.php?memberID=".$_POST[memberID]."\">";					
			} else {
				echo "<h3>Please do not leave any mandatory fields blank.</h3>";
				echo "<meta http-equiv=\"refresh\" content=\"3; url=managePayments.php?memberID=".$_POST[memberID]."\">";						
			}
		} elseif(isset($_POST[remove.$paymentID]) || isset($_POST[removeAll])){

		   	$query2 = $db->prepare("DELETE FROM Payment WHERE paymentID=:paymentID");
			$query2->execute(array('paymentID'=>$paymentID));

			echo "<h3>Payment Removed</h3>";
			echo "<meta http-equiv=\"refresh\" content=\"2; url=managePayments.php?memberID=".$_POST[memberID]."\">";
		}
	}
?>

<?php require "html_footer.txt"; ?>
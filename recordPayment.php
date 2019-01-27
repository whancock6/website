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
	if($_POST[memberID]!="none") {
		
		$amountDollars=$_POST[amountDollars];
		
		if($_POST[amountCents]==""){
				$amountCents=0;
		} else {
				$amountCents=$_POST[amountCents];
		}
		
		$amount = $amountDollars + ($amountCents * .01);
		
		if(($_POST[methodOfPayment]=="check" || $_POST[methodOfPayment]=="credit" || $_POST[methodOfPayment]=="reimbursement") && $_POST[checkNumber]!==""){
		   	$query = $db->prepare("INSERT INTO Payment (memberID, dateYear, dateMonth, dateDay, amount, methodOfPayment, checkNumber) VALUES (:memberID, :dateYear, :dateMonth, :dateDay, :amount, :methodOfPayment, :checkNumber)");
			$query->execute(array('memberID'=>$_POST[memberID], 'dateYear'=>$_POST[dateYear], 'dateMonth'=>$_POST[dateMonth], 'dateDay'=>$_POST[dateDay], 'amount'=>$amount, 'methodOfPayment'=>$_POST[methodOfPayment], 'checkNumber'=>$_POST[checkNumber]));
		} else {
		   	$query = $db->prepare("INSERT INTO Payment (memberID, dateYear, dateMonth, dateDay, amount, methodOfPayment) VALUES (:memberID, :dateYear, :dateMonth, :dateDay, :amount, :methodOfPayment)");
			$query->execute(array('memberID'=>$_POST[memberID], 'dateYear'=>$_POST[dateYear], 'dateMonth'=>$_POST[dateMonth], 'dateDay'=>$_POST[dateDay], 'amount'=>$amount, 'methodOfPayment'=>$_POST[methodOfPayment]));
		}

		echo "<h3>Payment Recorded</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=managePayments.php\">";
	} else {
		echo "<h3>Please do not leave any mandatory fields blank.</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=managePayments.php\">";		
	}		
?>

<?php require "html_footer.txt"; ?>
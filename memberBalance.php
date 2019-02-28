<?php
	require "logged_in_check.php";
	require "set_session_vars_short.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
?>
<br/>
<h3>Member Balance</h3>

<div align="center">
<a href="points.php">Back to Points</a><br><br>
</div><br/>

<?php
	$query = $db->prepare("SELECT firstName, lastName FROM Member WHERE memberID=:memberID");
	$query->execute(array('memberID'=>$memberID));
		$query->setFetchMode(PDO::FETCH_ASSOC);

     while($row = $query->fetch()) {
     	$currentFirstName = $row[firstName];
     	$currentLastName = $row[lastName];
     }	
	
	$query = $db->prepare("SELECT LineItem.lineItemName, LineItem.dateYear, LineItem.dateMonth, LineItem.dateDay, LineItem.unitCost, MemberLineItem.quantity 
	                       FROM MemberLineItem INNER JOIN LineItem ON MemberLineItem.lineItemID = LineItem.lineItemID 
	                       WHERE MemberLineItem.memberID=:memberID	                       
	                       UNION
	                       SELECT Payment.methodOfPayment, Payment.dateYear, Payment.dateMonth, Payment.dateDay, Payment.amount, Payment.checkNumber
	                       FROM Payment
	                       WHERE Payment.memberID=:memberID
	                       ORDER BY dateYear, dateMonth, dateDay");
	$query->execute(array('memberID'=>$memberID));
		$query->setFetchMode(PDO::FETCH_ASSOC);
	
	$num_results = $query->rowCount();
	
	echo "<table align=\"center\">\n";
	echo "<tr bgcolor=\"#b3a369\"><th colspan=\"6\">".$currentFirstName." ".$currentLastName."</th></tr>";
	if($num_results!=0){   	
	    echo "<tr><th>Date</th><th width=300>Line Item Name</th><th width=100>Unit Cost</th><th>Quantity</th><th width=30>&nbsp;</th><th>Total</th></tr>\n";
	    
	    while($row = $query->fetch()) {
	    	if($row[lineItemName]=="check" || $row[lineItemName]=="cash" || $row[lineItemName]=="credit" || $row[lineItemName]=="reimbursement") { 
                        $type = $row[lineItemName];
                        if($type=="credit"){
                                $lineItemType="credit/debit";
                        }else{
                                $lineItemType=$type;
                        }
                        if($type=="reimbursement"){
                                 if(isset($row[quantity])){
                                         echo "<tr bgcolor=\"#E8E8E8\"><td>".$row[dateMonth]."-".$row[dateDay]."-".$row[dateYear]."</td><td>Reimbursement - (".$row[quantity].")</td><td>$".$row[unitCost]."</td><td>&nbsp;</td><td>&nbsp;</td><td>$".$row[unitCost]."</td></tr>";
                                 }else{
                                         echo "<tr bgcolor=\"#E8E8E8\"><td>".$row[dateMonth]."-".$row[dateDay]."-".$row[dateYear]."</td><td>Reimbursement</td><td>$".$row[unitCost]."</td><td>&nbsp;</td><td>&nbsp;</td><td>$".$row[unitCost]."</td></tr>";
                                 }   
                        }elseif(isset($row[quantity])){
	    		echo "<tr bgcolor=\"#E8E8E8\"><td>".$row[dateMonth]."-".$row[dateDay]."-".$row[dateYear]."</td><td>Payment - ".$lineItemType." (".$row[quantity].")</td><td>$".$row[unitCost]."</td><td>&nbsp;</td><td>&nbsp;</td><td>$".$row[unitCost]."</td></tr>";
                        }else{
                        echo "<tr bgcolor=\"#E8E8E8\"><td>".$row[dateMonth]."-".$row[dateDay]."-".$row[dateYear]."</td><td>Payment - ".$lineItemType."</td><td>$".$row[unitCost]."</td><td>&nbsp;</td><td>&nbsp;</td><td>$".$row[unitCost]."</td></tr>";
                        }			  		
	    	} else {
				$memberBalance=$row[unitCost]*$row[quantity];
	   			$amountDollars=floor($memberBalance);
	   			$amountCents=($memberBalance-$amountDollars)*100;
	   			$amountCents=round($amountCents);
	   			if($amountCents==0) $amountCents="00";
	   			if($amountCents==1) $amountCents="01";
	   			if($amountCents==2) $amountCents="02";
	   			if($amountCents==3) $amountCents="03";
	   			if($amountCents==4) $amountCents="04";
	   			if($amountCents==5) $amountCents="05";
	   			if($amountCents==6) $amountCents="06";
	   			if($amountCents==7) $amountCents="07";
	   			if($amountCents==8) $amountCents="08";
	   			if($amountCents==9) $amountCents="09";    		
	    		echo "<tr><td>".$row[dateMonth]."-".$row[dateDay]."-".$row[dateYear]."</td><td>".$row[lineItemName]."</td><td>$".$row[unitCost]."</td><td>".$row[quantity]."</td><td>&nbsp;</td><td>($".$amountDollars.".".$amountCents.")</td></tr>";
	    	}
	    }
	    echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><hr/></td></tr>";
	   	$query2 = $db->prepare("SELECT SUM(unitCost*quantity) AS debit FROM MemberLineItem INNER JOIN LineItem ON MemberLineItem.lineItemID = LineItem.lineItemID WHERE MemberLineItem.memberID=:memberID");
		$query2->execute(array('memberID'=>$memberID));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		while($row2 = $query2->fetch()) {
			$tempDebitTotal=$row2[debit];
		}
	   	$query3 = $db->prepare("SELECT SUM(amount) AS credit FROM Payment WHERE memberID=:memberID");
		$query3->execute(array('memberID'=>$memberID));
			$query3->setFetchMode(PDO::FETCH_ASSOC);
		while($row3 = $query3->fetch()) {
			$tempCreditTotal=$row3[credit];
		} 
		$memberBalance=$tempCreditTotal-$tempDebitTotal;
		if($memberBalance>=0){
   			$amountDollars=floor($memberBalance);
   			$amountCents=($memberBalance-$amountDollars)*100;
   			$amountCents=round($amountCents);
   			if($amountCents==0) $amountCents="00";
   			if($amountCents==1) $amountCents="01";
   			if($amountCents==2) $amountCents="02";
   			if($amountCents==3) $amountCents="03";
   			if($amountCents==4) $amountCents="04";
   			if($amountCents==5) $amountCents="05";
   			if($amountCents==6) $amountCents="06";
   			if($amountCents==7) $amountCents="07";
   			if($amountCents==8) $amountCents="08";
   			if($amountCents==9) $amountCents="09";		
			echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><th colspan=\"2\">Balance:</th><td>$".$amountDollars.".".$amountCents."</td></tr>";	 
		} else {
			$memberBalance=$memberBalance*-1;
   			$amountDollars=floor($memberBalance);
   			$amountCents=($memberBalance-$amountDollars)*100;
   			$amountCents=round($amountCents);
   			if($amountCents==0) $amountCents="00";
   			if($amountCents==1) $amountCents="01";
   			if($amountCents==2) $amountCents="02";
   			if($amountCents==3) $amountCents="03";
   			if($amountCents==4) $amountCents="04";
   			if($amountCents==5) $amountCents="05";
   			if($amountCents==6) $amountCents="06";
   			if($amountCents==7) $amountCents="07";
   			if($amountCents==8) $amountCents="08";
   			if($amountCents==9) $amountCents="09";	
			echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><th colspan=\"2\">Balance:</th><td>($".$amountDollars.".".$amountCents.")</td></tr>";   						
		}   
	} else {
		echo "<tr><td colspan=\"6\">&nbsp;</td></tr>";
		echo "<tr><td colspan=\"6\">There are currently no line items associated with your account.</td></tr>";
	}
	echo "</table>";
?>

<br><br><br><br>

<?php require "html_footer.txt"; ?>
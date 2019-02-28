<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isTreasurer]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
<SCRIPT type="text/javascript">
	function reload(form){
	var sortBy=form.sortBy.options[form.sortBy.options.selectedIndex].value;
	self.location='viewMemberBalances.php?sortBy=' + sortBy;
	}
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br/>

<?php
	@$sortBy=$_GET[sortBy];
	
	if(isset($sortBy)) {
	} else {
	    $sortBy = "all";
	}
?>

<h3>Member Balances</h3>

<div align="center">
<a href="points.php">Back to Points</a>
</div><br/>
<form>
<table align="center">
<tr><td>Sort by: </td>
<td>
<select name="sortBy" id="sortBy" onChange="reload(this.form)">
   <option value="all"  <?PHP if($sortBy=="all") echo "selected";?>>All</option>
   <option value="mostOwed" <?PHP if($sortBy=="mostOwed") echo "selected";?>>Most Owed</option>
   <option value="members"  <?PHP if($sortBy=="members") echo "selected";?>>Members</option>
   <option value="probates"  <?PHP if($sortBy=="probates") echo "selected";?>>Probates</option>
   <option value="social"  <?PHP if($sortBy=="social") echo "selected";?>>Social</option>
</select>
</td></tr>
</table>
</form>
</br></br>
<?php
	echo "<table align=\"center\">";
	echo "<tr bgcolor=\"#b3a369\"><th>Member</th><th width=150>Balance</th><th>Check</th></tr>";
	
        if($sortBy=="all") {
		   	$query = $db->query("SELECT firstName, lastName, memberID FROM Member WHERE status!='alumni' ORDER BY lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        } elseif($sortBy=="mostOwed"){
		   	$query = $db->query("SELECT firstName, lastName, memberID, debit, credit, (credit - debit) AS balance FROM
		   					(SELECT firstName, lastName, Member.memberID, COALESCE(charges, 0) AS debit, COALESCE(payments, 0) AS credit
							FROM (Member LEFT OUTER JOIN (SELECT memberID, SUM(unitCost*quantity) AS charges FROM MemberLineItem INNER JOIN LineItem ON MemberLineItem.lineItemID = LineItem.lineItemID GROUP BY 1) lineItem
								ON Member.memberID = lineItem.memberID)
							LEFT OUTER JOIN (SELECT memberID, SUM(amount) AS payments FROM Payment GROUP BY 1) payment
								ON Member.memberID = payment.memberID
							WHERE status!='alumni')a ORDER BY balance, lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        } elseif($sortBy=="members") {
		   	$query = $db->query("SELECT firstName, lastName, memberID FROM Member WHERE status='member' ORDER BY lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        } elseif($sortBy=="probates") {
		   	$query = $db->query("SELECT firstName, lastName, memberID FROM Member WHERE status='probate' ORDER BY lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        } elseif($sortBy=="social") {
		   	$query = $db->query("SELECT firstName, lastName, memberID FROM Member WHERE status='social' ORDER BY lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
        }	
        
	while($row = $query->fetch()) {
		$tempMemberID = $row[memberID];
		echo "<form action=\"checkLineItems.php\" method=\"POST\">";	
		echo "<tr><td width=200>".$row[firstName]." ".$row[lastName]."</td>";
	   	$query2 = $db->prepare("SELECT SUM(unitCost*quantity) AS debit FROM MemberLineItem INNER JOIN LineItem ON MemberLineItem.lineItemID = LineItem.lineItemID WHERE MemberLineItem.memberID=:tempMemberID");
	   	$query2->execute(array('tempMemberID'=>$tempMemberID));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		while($row2 = $query2->fetch()) {
			$tempDebitTotal=$row2[debit];
		}
	   	$query3 = $db->prepare("SELECT SUM(amount) AS credit FROM Payment WHERE memberID=:tempMemberID");
	   	$query3->execute(array('tempMemberID'=>$tempMemberID));
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
			echo "<td align=\"center\">$".$amountDollars.".".$amountCents."</td>";
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
			echo "<td align=\"center\">($".$amountDollars.".".$amountCents.")</td>";		
		}
		echo "<td align=\"center\"><input type=\"submit\" value=\"Check Line Items\"></td></tr>";
		echo "<input type=\"hidden\" name=\"memberID\" value=\"".$tempMemberID."\">";
		echo "</form>";
	}
		
	echo "</table>";
?>
<br/><br/><br/><br/><br/>
<?php require "html_footer.txt"; ?>
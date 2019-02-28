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
	function number(e)
	{
	var key;
	var keychar;
	
	if (window.event)
	   key = window.event.keyCode;
	else if (e)
	   key = e.which;
	else
	   return true;
	keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	
	if ((key==null) || (key==0) || (key==8) || 
	    (key==9) || (key==13) || (key==27) )
	   return true;
	
	else if ((("0123456789").indexOf(keychar) > -1))
	   return true;
	else
	   return false;
	}
	var whitespace = " \t\n\r";
	function isEmpty(s) {
	   var i;
	   if((s == null) || (s.length == 0))
	      return true;
	   // Search string looking for characters that are not whitespace
	   for (i = 0; i < s.length; i++) {   
	      var c = s.charAt(i);
	      if (whitespace.indexOf(c) == -1) 
	        return false;
	    }
	    // At this point all characters are whitespace.
	    return true;
	}
	var intRegex = /^\d+$/;
	function validate() {
	  if (isEmpty(document.myform.amountDollars.value)) {
	        alert("Error: The dollar value of payment amount is required. Type 0 if payment amount is less than one dollar.");
	        document.myform.amountDollars.focus();
	        return false;
	    }
	  if (!intRegex.test(document.myform.amountDollars.value) && !isEmpty(document.myform.amountDollars.value)) {
	        alert("Error: The dollar value of payment amount must be an integer.");
	        document.myform.amountDollars.focus();
	        return false;
	    }
	  if (!intRegex.test(document.myform.amountCents.value) && !isEmpty(document.myform.amountCents.value)) {
	        alert("Error: The decimal value of payment amount must be an integer or blank.");
	        document.myform.amountCents.focus();
	        return false;
	    }
	  return true;
	}
	function confirmSubmit()
	{
	var agree=confirm("Are you sure you wish to REMOVE this payment?");
	if (agree)
		return true ;
	else
		return false;
	}
	function confirmSubmitAll()
	{
	var agree=confirm("Are you sure you wish to REMOVE ALL payments for this member?");
	if (agree)
		return true ;
	else
		return false;
	}
	function reload(form){
		var memberID=form.memberID.options[form.memberID.options.selectedIndex].value;
		self.location='managePayments.php?memberID=' + memberID;
	}
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br/>
<?php
                $today = getdate();
                $currentday = $today[mday];
                $currentmonth = $today[mon];
                $currentyear = $today[year];
                $stopyear = 2012;
                
                @$memberID=$_GET[memberID];
                
                if(isset($memberID)) {
                         $selectedMember = $memberID;
                } else {
                         $selectedMember = "none";
                }                
?>

<h3>Manage Payments</h3>
<div align="center">
<a href="points.php">Back to Points</a><br><br>
</div>

<form name="myform" id="myform" action="recordPayment.php" onsubmit="return validate();" method="POST">
<table align="center">
	<tr><th colspan="2">Record Payment</th></tr>
<?php
   	$query = $db->query("SELECT memberID, firstName, lastName FROM Member WHERE status != 'alumni' ORDER BY lastName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
?>
<tr bgcolor="#b3a369"><td>Select Member: </td><td>
<select name="memberID" id="memberID">
   <option value="none">---</option>
<?php
   while($row = $query->fetch()) {
          echo "<option value=\"".$row[memberID]."\" ";
          echo ">".$row[lastName].", ".$row[firstName]."</option>";
   }
?>
</select>
</td></tr>
<tr bgcolor="#b3a369"><td>
<label for="lineItemDate">Date: </label></td><td>
<select name="dateMonth" id="dateMonth">
	<option value="01" <?PHP if($currentmonth==1) echo "selected";?>>January</option>
	<option value="02" <?PHP if($currentmonth==2) echo "selected";?>>February</option>
	<option value="03" <?PHP if($currentmonth==3) echo "selected";?>>March</option>
	<option value="04" <?PHP if($currentmonth==4) echo "selected";?>>April</option>
	<option value="05" <?PHP if($currentmonth==5) echo "selected";?>>May</option>
	<option value="06" <?PHP if($currentmonth==6) echo "selected";?>>June</option>
	<option value="07" <?PHP if($currentmonth==7) echo "selected";?>>July</option>
	<option value="08" <?PHP if($currentmonth==8) echo "selected";?>>August</option>
	<option value="09" <?PHP if($currentmonth==9) echo "selected";?>>September</option>
	<option value="10" <?PHP if($currentmonth==10) echo "selected";?>>October</option>
	<option value="11" <?PHP if($currentmonth==11) echo "selected";?>>November</option>
	<option value="12" <?PHP if($currentmonth==12) echo "selected";?>>December</option>
</select>
<select name="dateDay" id="dateDay">
	<option value="01" <?PHP if($currentday==1) echo "selected";?>>01</option>
	<option value="02" <?PHP if($currentday==2) echo "selected";?>>02</option>
	<option value="03" <?PHP if($currentday==3) echo "selected";?>>03</option>
	<option value="04" <?PHP if($currentday==4) echo "selected";?>>04</option>
	<option value="05" <?PHP if($currentday==5) echo "selected";?>>05</option>
	<option value="06" <?PHP if($currentday==6) echo "selected";?>>06</option>
	<option value="07" <?PHP if($currentday==7) echo "selected";?>>07</option>
	<option value="08" <?PHP if($currentday==8) echo "selected";?>>08</option>
	<option value="09" <?PHP if($currentday==9) echo "selected";?>>09</option>
	<option value="10" <?PHP if($currentday==10) echo "selected";?>>10</option>
	<option value="11" <?PHP if($currentday==11) echo "selected";?>>11</option>
	<option value="12" <?PHP if($currentday==12) echo "selected";?>>12</option>
	<option value="13" <?PHP if($currentday==13) echo "selected";?>>13</option>
	<option value="14" <?PHP if($currentday==14) echo "selected";?>>14</option>
	<option value="15" <?PHP if($currentday==15) echo "selected";?>>15</option>
	<option value="16" <?PHP if($currentday==16) echo "selected";?>>16</option>
	<option value="17" <?PHP if($currentday==17) echo "selected";?>>17</option>
	<option value="18" <?PHP if($currentday==18) echo "selected";?>>18</option>
	<option value="19" <?PHP if($currentday==19) echo "selected";?>>19</option>
	<option value="20" <?PHP if($currentday==20) echo "selected";?>>20</option>
	<option value="21" <?PHP if($currentday==21) echo "selected";?>>21</option>
	<option value="22" <?PHP if($currentday==22) echo "selected";?>>22</option>
	<option value="23" <?PHP if($currentday==23) echo "selected";?>>23</option>
	<option value="24" <?PHP if($currentday==24) echo "selected";?>>24</option>
	<option value="25" <?PHP if($currentday==25) echo "selected";?>>25</option>
	<option value="26" <?PHP if($currentday==26) echo "selected";?>>26</option>
	<option value="27" <?PHP if($currentday==27) echo "selected";?>>27</option>
	<option value="28" <?PHP if($currentday==28) echo "selected";?>>28</option>
	<option value="29" <?PHP if($currentday==29) echo "selected";?>>29</option>
	<option value="30" <?PHP if($currentday==30) echo "selected";?>>30</option>
	<option value="31" <?PHP if($currentday==31) echo "selected";?>>31</option>
</select>
<select name="dateYear" id="dateYear">
	<?php
		$tempyear = $currentyear;
		while($tempyear >= $stopyear) {
			echo "<option value=\"".$tempyear."\" ";
			if($currentyear==$tempyear) { echo "selected"; }
			echo ">".$tempyear."</option>";
			$tempyear = $tempyear - 1;
		}
	?>
</select></td></tr>
<tr bgcolor="#b3a369">
	<td><label for="amount">Payment Amount: </label></td>
	<td>$<input type="text" name="amountDollars" size="4" maxlength="4" onKeyPress="return number(event)">.<input type="text" name="amountCents" size="2" maxlength="2" onKeyPress="return number(event)"></td>
</tr>
<tr bgcolor="#b3a369">
	<td><label for="methodOfPayment">Method of Payment: </label></td>
	<td><select name="methodOfPayment" id="methodOfPayment">
		<option value="cash">cash</option>
		<option value="check">check</option>
		<option value="credit">credit/debit</option>
		<option value="reimbursement">reimbursement</option>
	</select></td>
</tr>
<tr bgcolor="#b3a369">
	<td><label for="checkNumber">Description (Chk/Receipt #): </label></td>
	<td><input type="text" name="checkNumber" size="30" maxlength="30"></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Record"></td>
</tr>

</table>
</form>

<br/><hr/ width=800><br/>

<form name="changeForm" id="changeForm" action="changePayment.php" method="POST">
<table align="center">
<tr><th colspan="6">Edit/Remove Payment</th></tr>
<?php
   	$query = $db->query("SELECT memberID, firstName, lastName FROM Member WHERE status != 'alumni' ORDER BY lastName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	if($selectedMember!="none"){
	   	$query2 = $db->prepare("SELECT * FROM Payment WHERE memberID=:selectedMember ORDER BY dateYear, dateMonth, dateDay");
		$query2->execute(array('selectedMember'=>$selectedMember));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		$num_rows = $query2->rowCount();
	}
?>
<tr bgcolor="#b3a369"><td>&nbsp</td></td><td>Select Member: </td><td>
<select name="memberID" id="memberID" onChange="reload(this.form)">
   <option value="none">---</option>
<?php
   while($row = $query->fetch()) {
          echo "<option value=\"".$row[memberID]."\"";
           if($selectedMember==$row[memberID]) {
                  echo " selected";
           }
          echo ">".$row[lastName].", ".$row[firstName]."</option>";
   }    
?>
</select></td>
<?php
if($selectedMember!="none" && $num_rows!=0){
	echo "<td>&nbsp</td>";
	echo "<td><input type=\"submit\" name=\"updateAll\" value=\"Update All\"></td>";
	echo "<td><input type=\"submit\" name=\"removeAll\" value=\"Remove All\" onClick=\"return confirmSubmitAll()\"></td>";
} else {
	echo "<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td>";	
}
?>
</tr>
<?php
if($selectedMember!="none" && $num_rows!=0){
	echo "<tr><td colspan=6><hr/></td></tr>";
	echo "<tr bgcolor=\"#b3a369\"><th>Date</th><th width=200>Payment Amount</th><th width=50>Method</th><th>Description (Chk/Receipt #)</th><th>Update</th><th>Remove</th></tr>";

	while($row = $query2->fetch()) {
		echo "<tr bgcolor=\"#b3a369\"><td>";
   			echo "<select name=\"newDateMonth".$row[paymentID]."\" id=\"newDateMonth".$row[paymentID]."\">";
   				echo "<option value=\"01\"";
   					if($row[dateMonth]==1) echo " selected";
   				echo ">January</option>";
   				echo "<option value=\"02\"";
   					if($row[dateMonth]==2) echo " selected";
   				echo ">February</option>";
   				echo "<option value=\"03\"";
   					if($row[dateMonth]==3) echo " selected";
   				echo ">March</option>";
   				echo "<option value=\"04\"";
   					if($row[dateMonth]==4) echo " selected";
   				echo ">April</option>";
   				echo "<option value=\"05\"";
   					if($row[dateMonth]==5) echo " selected";
   				echo ">May</option>";
   				echo "<option value=\"06\"";
   					if($row[dateMonth]==6) echo " selected";
   				echo ">June</option>";
   				echo "<option value=\"07\"";
   					if($row[dateMonth]==7) echo " selected";
   				echo ">July</option>";    
   				echo "<option value=\"08\"";
   					if($row[dateMonth]==8) echo " selected";
   				echo ">August</option>";
   				echo "<option value=\"09\"";
   					if($row[dateMonth]==9) echo " selected";
   				echo ">September</option>";
   				echo "<option value=\"10\"";
   					if($row[dateMonth]==10) echo " selected";
   				echo ">October</option>";
   				echo "<option value=\"11\"";
   					if($row[dateMonth]==11) echo " selected";
   				echo ">November</option>";
   				echo "<option value=\"12\"";
   					if($row[dateMonth]==12) echo " selected";
   				echo ">December</option>";
   			echo "</select>";
   			echo "<select name=\"newDateDay".$row[paymentID]."\" id=\"newDateDay".$row[paymentID]."\">";    
   				echo "<option value=\"01\"";
   					if($row[dateDay]==1) echo " selected";
   				echo ">01</option>";		
   				echo "<option value=\"02\"";
   					if($row[dateDay]==2) echo " selected";
   				echo ">02</option>";	
   				echo "<option value=\"03\"";
   					if($row[dateDay]==3) echo " selected";
   				echo ">03</option>";	
   				echo "<option value=\"04\"";
   					if($row[dateDay]==4) echo " selected";
   				echo ">04</option>";	
   				echo "<option value=\"05\"";
   					if($row[dateDay]==5) echo " selected";
   				echo ">05</option>";	
   				echo "<option value=\"06\"";
   					if($row[dateDay]==6) echo " selected";
   				echo ">06</option>";	
   				echo "<option value=\"07\"";
   					if($row[dateDay]==7) echo " selected";
   				echo ">07</option>";	
   				echo "<option value=\"08\"";
   					if($row[dateDay]==8) echo " selected";
   				echo ">08</option>";	
   				echo "<option value=\"09\"";
   					if($row[dateDay]==9) echo " selected";
   				echo ">09</option>";	
   				echo "<option value=\"10\"";
   					if($row[dateDay]==10) echo " selected";
   				echo ">10</option>";	
   				echo "<option value=\"11\"";
   					if($row[dateDay]==11) echo " selected";
   				echo ">11</option>";
   				echo "<option value=\"12\"";
   					if($row[dateDay]==12) echo " selected";
   				echo ">12</option>";
   				echo "<option value=\"13\"";
   					if($row[dateDay]==13) echo " selected";
   				echo ">13</option>";
   				echo "<option value=\"14\"";
   					if($row[dateDay]==14) echo " selected";
   				echo ">14</option>";
   				echo "<option value=\"15\"";
   					if($row[dateDay]==15) echo " selected";
   				echo ">15</option>";
   				echo "<option value=\"16\"";
   					if($row[dateDay]==16) echo " selected";
   				echo ">16</option>";
   				echo "<option value=\"17\"";
   					if($row[dateDay]==17) echo " selected";
   				echo ">17</option>";
   				echo "<option value=\"18\"";
   					if($row[dateDay]==18) echo " selected";
   				echo ">18</option>";
   				echo "<option value=\"19\"";
   					if($row[dateDay]==19) echo " selected";
   				echo ">19</option>";
   				echo "<option value=\"20\"";
   					if($row[dateDay]==20) echo " selected";
   				echo ">20</option>";     
   				echo "<option value=\"21\"";
   					if($row[dateDay]==21) echo " selected";
   				echo ">21</option>";   
   				echo "<option value=\"22\"";
   					if($row[dateDay]==22) echo " selected";
   				echo ">22</option>";   
   				echo "<option value=\"23\"";
   					if($row[dateDay]==23) echo " selected";
   				echo ">23</option>";   
   				echo "<option value=\"24\"";
   					if($row[dateDay]==24) echo " selected";
   				echo ">24</option>";   
   				echo "<option value=\"25\"";
   					if($row[dateDay]==25) echo " selected";
   				echo ">25</option>";   
   				echo "<option value=\"26\"";
   					if($row[dateDay]==26) echo " selected";
   				echo ">26</option>";   
   				echo "<option value=\"27\"";
   					if($row[dateDay]==27) echo " selected";
   				echo ">27</option>";   
   				echo "<option value=\"28\"";
   					if($row[dateDay]==28) echo " selected";
   				echo ">28</option>";   
   				echo "<option value=\"29\"";
   					if($row[dateDay]==29) echo " selected";
   				echo ">29</option>";   
   				echo "<option value=\"30\"";
   					if($row[dateDay]==30) echo " selected";
   				echo ">30</option>";        
   				echo "<option value=\"31\"";
   					if($row[dateDay]==31) echo " selected";
   				echo ">31</option>";      
   			echo "</select>";	
   			echo "<select name=\"newDateYear".$row[paymentID]."\" id=\"newDateYear".$row[paymentID]."\">";
				$tempyear = $currentyear;
				while($tempyear >= $stopyear) {
					echo "<option value=\"".$tempyear."\" ";
					if($row[dateYear]==$tempyear) { echo "selected"; }
					echo ">".$tempyear."</option>";
					$tempyear = $tempyear - 1;
				}
   			echo "</select>";
		echo "</td>";
   			$amountDollars=floor($row[amount]);
   			$amountCents=($row[amount]-$amountDollars)*100;
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
		echo "<td>";
			echo "$<input type=\"text\" name=\"newAmountDollars".$row[paymentID]."\" value=\"".$amountDollars."\" size=\"2\" maxlength=\"4\" onKeyPress=\"return number(event)\">.<input type=\"text\" name=\"newAmountCents".$row[paymentID]."\" value=\"".$amountCents."\" size=\"2\" maxlength=\"2\" onKeyPress=\"return number(event)\">";
		echo "</td>";
		echo "<td>";
			echo "<select name=\"newMethodOfPayment".$row[paymentID]."\" id=\"newMethodOfPayment".$row[paymentID]."\"><option value=\"cash\"";
				if($row[methodOfPayment]=="cash") echo " selected";
			echo ">cash</option><option value=\"check\"";
				if($row[methodOfPayment]=="check") echo " selected";
			echo ">check</option><option value=\"credit\"";
				if($row[methodOfPayment]=="credit") echo " selected";
			echo ">credit/debit</option><option value=\"reimbursement\"";
				if($row[methodOfPayment]=="reimbursement") echo " selected";
			echo ">reimbursement</option></select>";
		echo "</td>";
		echo "<td>";
			echo "<input type=\"text\" name=\"newCheckNumber".$row[paymentID]."\" value=\"".$row[checkNumber]."\" size=\"30\" maxlength=\"30\">";
		echo "</td>";
		echo "<td><input type=\"submit\" name=\"update".$row[paymentID]."\" value=\"Update\"></td>";
		echo "<td><input type=\"submit\" name=\"remove".$row[paymentID]."\" value=\"Remove\" onClick=\"return confirmSubmit()\"></td></tr>";
	}
} elseif($selectedMember!="none" && $num_rows==0) {
	echo "<tr><td colspan=6><hr/></td></tr>";
	echo "<tr><td colspan=6>There are no payments recorded for this member.</td></tr>";		
}
?>

</table>
</form>

<br/><br/><br/><br/>		

<?php require "html_footer.txt"; ?>
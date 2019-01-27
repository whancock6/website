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
	function confirmSubmit() 
	{
	var agree=confirm("Are you sure you wish to apply this quantity to all members?");
	if (agree)
		return true ;
	else
		return false ;
	}	
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
	function reload(form){
	var day=form.dateDay.options[form.dateDay.options.selectedIndex].value;
	var month=form.dateMonth.options[form.dateMonth.options.selectedIndex].value;
	var year=form.dateYear.options[form.dateYear.options.selectedIndex].value;
	var lineItemID=form.lineItemID.options[form.lineItemID.options.selectedIndex].value;
	self.location='applyLineItems.php?dateMonth=' + month + '&dateDay=' + day + '&dateYear=' + year + '&lineItemID=' + lineItemID;
} 
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br>
	
<?php
        $today = getdate();
        $currentday = $today[mday];
        $currentmonth = $today[mon];
        $currentyear = $today[year];
        
       @$dateMonth=$_GET[dateMonth];
       @$dateDay=$_GET[dateDay];
       @$dateYear=$_GET[dateYear];
       @$lineItemID=$_GET[lineItemID];
       
        if(isset($dateMonth)) {
                 $selectedMonth = $dateMonth;
        } else {
                 $selectedMonth = $currentmonth;
        }
        if(isset($dateDay)) {
                 $selectedDay = $dateDay;
        } else {
                 $selectedDay = $currentday;
        }   
        if(isset($dateYear)) {
                 $selectedYear = $dateYear;
        } else {
                 $selectedYear = $currentyear;
        }
        if(isset($lineItemID) && $lineItemID!=="none" && $selectedDay!=0) {
		   	$query = $db->prepare("SELECT dateDay, dateMonth, dateYear FROM LineItem WHERE lineItemID=:lineItemID");
			$query->execute(array('lineItemID'=>$lineItemID));
				$query->setFetchMode(PDO::FETCH_ASSOC);
			 while($row = $query->fetch()) {
			 		if($row[dateDay]==$selectedDay && $row[dateMonth]==$selectedMonth && $row[dateYear]==$selectedYear){
			 				$selectedLineItem = $lineItemID;
			 		} else {
			 				$selectedLineItem = "none";
			 		}
			 }
        } elseif(isset($lineItemID) && $lineItemID!=="none" && $selectedDay==0) {
		   	$query = $db->prepare("SELECT dateMonth, dateYear FROM LineItem WHERE lineItemID=:lineItemID");
			$query->execute(array('lineItemID'=>$lineItemID));
				$query->setFetchMode(PDO::FETCH_ASSOC);
			 while($row = $query->fetch()) {
			 		if($row[dateMonth]==$selectedMonth && $row[dateYear]==$selectedYear){
			 				$selectedLineItem = $lineItemID;
			 		} else {
			 				$selectedLineItem = "none";
			 		}
			 }
        } else {
			$selectedLineItem = "none";
        }
?>

<h3>Apply Line Items to Members</h3>
<div align="center">
<a href="points.php">Back to Points</a><br/><br/>
</div> 

<form name="applyLineItem" action="applyLineItemsAction.php" method="POST">
<table align="center">
	<tr><th colspan="10">Apply Line Item</th></tr>
	<tr bgcolor="#dbcfba"><td>&nbsp</td><td>&nbsp</td><td>
	<label for="lineItemDate">Date: </label></td><td colspan="2">
	<select name="dateMonth" id="dateMonth" onChange="reload(this.form)">
		<option value="01"  <?PHP if($selectedMonth==1)echo "selected";?>>January</option>
		<option value="02"  <?PHP if($selectedMonth==2)echo "selected";?>>February</option>
		<option value="03"  <?PHP if($selectedMonth==3)echo "selected";?>>March</option>
		<option value="04"  <?PHP if($selectedMonth==4)echo "selected";?>>April</option>
		<option value="05"  <?PHP if($selectedMonth==5)echo "selected";?>>May</option>
		<option value="06"  <?PHP if($selectedMonth==6)echo "selected";?>>June</option>
		<option value="07"  <?PHP if($selectedMonth==7)echo "selected";?>>July</option>
		<option value="08"  <?PHP if($selectedMonth==8)echo "selected";?>>August</option>
		<option value="09"  <?PHP if($selectedMonth==9)echo "selected";?>>September</option>
		<option value="10"  <?PHP if($selectedMonth==10)echo "selected";?>>October</option>
		<option value="11"  <?PHP if($selectedMonth==11)echo "selected";?>>November</option>
		<option value="12"  <?PHP if($selectedMonth==12)echo "selected";?>>December</option>
	</select>
	<select name="dateDay" id="dateDay" onChange="reload(this.form)">
		<option value="00"  <?PHP if($selectedDay==0) echo "selected";?>>--</option>
		<option value="01"  <?PHP if($selectedDay==1) echo "selected";?>>01</option>
		<option value="02"  <?PHP if($selectedDay==2) echo "selected";?>>02</option>
		<option value="03"  <?PHP if($selectedDay==3) echo "selected";?>>03</option>
		<option value="04"  <?PHP if($selectedDay==4) echo "selected";?>>04</option>
		<option value="05"  <?PHP if($selectedDay==5) echo "selected";?>>05</option>
		<option value="06"  <?PHP if($selectedDay==6) echo "selected";?>>06</option>
		<option value="07"  <?PHP if($selectedDay==7) echo "selected";?>>07</option>
		<option value="08"  <?PHP if($selectedDay==8) echo "selected";?>>08</option>
		<option value="09"  <?PHP if($selectedDay==9) echo "selected";?>>09</option>
		<option value="10"  <?PHP if($selectedDay==10) echo "selected";?>>10</option>
		<option value="11"  <?PHP if($selectedDay==11) echo "selected";?>>11</option>
		<option value="12"  <?PHP if($selectedDay==12) echo "selected";?>>12</option>
		<option value="13"  <?PHP if($selectedDay==13) echo "selected";?>>13</option>
		<option value="14"  <?PHP if($selectedDay==14) echo "selected";?>>14</option>
		<option value="15"  <?PHP if($selectedDay==15) echo "selected";?>>15</option>
		<option value="16"  <?PHP if($selectedDay==16) echo "selected";?>>16</option>
		<option value="17"  <?PHP if($selectedDay==17) echo "selected";?>>17</option>
		<option value="18"  <?PHP if($selectedDay==18) echo "selected";?>>18</option>
		<option value="19"  <?PHP if($selectedDay==19) echo "selected";?>>19</option>
		<option value="20"  <?PHP if($selectedDay==20) echo "selected";?>>20</option>
		<option value="21"  <?PHP if($selectedDay==21) echo "selected";?>>21</option>
		<option value="22"  <?PHP if($selectedDay==22) echo "selected";?>>22</option>
		<option value="23"  <?PHP if($selectedDay==23) echo "selected";?>>23</option>
		<option value="24"  <?PHP if($selectedDay==24) echo "selected";?>>24</option>
		<option value="25"  <?PHP if($selectedDay==25) echo "selected";?>>25</option>
		<option value="26"  <?PHP if($selectedDay==26) echo "selected";?>>26</option>
		<option value="27"  <?PHP if($selectedDay==27) echo "selected";?>>27</option>
		<option value="28"  <?PHP if($selectedDay==28) echo "selected";?>>28</option>
		<option value="29"  <?PHP if($selectedDay==29) echo "selected";?>>29</option>
		<option value="30"  <?PHP if($selectedDay==30) echo "selected";?>>30</option>
		<option value="31"  <?PHP if($selectedDay==31) echo "selected";?>>31</option>
	</select>
	<select name="dateYear" id="dateYear" onChange="reload(this.form)">
		<?php
			$tempyear = $currentyear;
			$stopyear = 2012;
			while($tempyear >= $stopyear) {
				echo "<option value=\"".$tempyear."\" ";
				if($selectedYear==$tempyear) { echo "selected"; }
				echo ">".$tempyear."</option>";
				$tempyear = $tempyear - 1;
			}
		?>
	</select>
	</td><td>&nbsp</td>
	<?php
	if($selectedLineItem!="none"){
		echo "<td><label for=\"allQuantity\">Quantity: </label></td><td><input type=\"text\" name=\"allQuantity\" size=4 maxlength=4 onKeyPress=\"return number(event)\"></td>";
	} else {
		echo "<td>&nbsp</td><td>&nbsp</td>";
	}
	?>
	<td>&nbsp</td><td>&nbsp</td></tr>
	<tr bgcolor="#dbcfba"><td>&nbsp</td><td>&nbsp</td><td>
	<label for="lineItemID">Line Item Name: </label></td><td colspan="2">
	<select name="lineItemID" id="lineItemID" onChange="reload(this.form)">
		<option value="none">---</option>
	<?php
		if($selectedDay != 0) {
	   	$query = $db->prepare("SELECT * FROM LineItem WHERE dateMonth=:selectedMonth AND dateDay=:selectedDay AND dateYear=:selectedYear ORDER BY dateDay");
		$query->execute(array('selectedMonth'=>$selectedMonth, 'selectedDay'=>$selectedDay, 'selectedYear'=>$selectedYear));
			$query->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $query->fetch()) {
	            echo "<option value=\"";
	            echo $row[lineItemID];
	            echo "\"";
	            if($row[lineItemID]==$selectedLineItem) echo " selected";
	            echo ">".$row[lineItemName]."</option>";
			}
		} elseif($selectedDay == 0) {
	   	$query = $db->prepare("SELECT * FROM LineItem WHERE dateMonth=:selectedMonth AND dateYear=:selectedYear ORDER BY dateDay");
		$query->execute(array('selectedMonth'=>$selectedMonth, 'selectedYear'=>$selectedYear));
			$query->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $query->fetch()) {
	            echo "<option value=\"";
	            echo $row[lineItemID];
	            echo "\"";
	            if($row[lineItemID]==$selectedLineItem) echo " selected";
	            echo ">".$row[lineItemName]." (".$row[dateMonth]."-".$row[dateDay].")</option>";
			}
		}
	?>
	</select></td><td>&nbsp</td>
	<?php
	if($selectedLineItem!="none"){
		echo "<td colspan=\"2\"><input type=\"submit\" name=\"all\" value=\"Apply to All\" onClick=\"return confirmSubmit()\"></td>";
	} else {
		echo "<td>&nbsp</td><td>&nbsp</td>";
	}	
	?>
	<td>&nbsp</td><td>&nbsp</td></tr>
	<?php
		if($selectedLineItem!="none") {
		   	$query = $db->query("SELECT memberID, firstName, lastName FROM Member WHERE status != 'alumni' ORDER BY lastName");
				$query->setFetchMode(PDO::FETCH_ASSOC);
			$count=0;
			echo "<tr><th>Member</th><th>Quantity</th><th>Member</th><th>Quantity</th><th>Member</th><th>Quantity</th><th>Member</th><th>Quantity</th><th>Member</th><th>Quantity</th></tr><tr>";	
			while($row = $query->fetch()){
				$tempMemberID=$row[memberID];
			   	$query2 = $db->prepare("SELECT quantity FROM MemberLineItem WHERE memberID=:tempMemberID AND lineItemID=:selectedLineItem");
				$query2->execute(array('tempMemberID'=>$tempMemberID, 'selectedLineItem'=>$selectedLineItem));
					$query2->setFetchMode(PDO::FETCH_ASSOC);
				$quantity=NULL;
				while($row2 = $query2->fetch()){
					$quantity=$row2[quantity];
				}
				echo "<td>".$row[firstName]." ".$row[lastName]."</td><td><input type=\"text\" name=\"".$row[memberID]."\" value=\"".$quantity."\" size=4 maxlength=4 onKeyPress=\"return number(event)\"></td>";	
				$count++;
				if(($count % 5)==0){
					echo "</tr><tr>";	
				}
			}
			echo "</tr>";
			echo "<tr><td colspan=\"10\">";
			echo "<input type=\"submit\" name=\"individual\" value=\"Apply\">";
			echo "</td></tr>";
		}
	?>	
	</table>
	</form>
	
<br/><br/><br/><br/>		

<?php require "html_footer.txt"; ?>
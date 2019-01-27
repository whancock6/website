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
	  if (isEmpty(document.myform.lineItemName.value)) {
	        alert("Error: Line item name is required.");
	        document.myform.lineItemName.focus();
	        return false;
	    }
	  if (isEmpty(document.myform.unitCostDollars.value)) {
	        alert("Error: The dollar value of unit cost is required. Type 0 if unit cost is less than one dollar.");
	        document.myform.unitCostDollars.focus();
	        return false;
	    }
	  if (!intRegex.test(document.myform.unitCostDollars.value) && !isEmpty(document.myform.unitCostDollars.value)) {
	        alert("Error: The dollar value of unit cost must be an integer.");
	        document.myform.unitCostDollars.focus();
	        return false;
	    }
	  if (!intRegex.test(document.myform.unitCostCents.value) && !isEmpty(document.myform.unitCostCents.value)) {
	        alert("Error: The decimal value of unit cost must be an integer or blank.");
	        document.myform.unitCostCents.focus();
	        return false;
	    }
	  return true;
	}
	function newvalidate() {
	  if (isEmpty(document.changeForm.newLineItemName.value)) {
	        alert("Error: Line item name is required.");
	        document.changeForm.newLineItemName.focus();
	        return false;
	    }
	  if (isEmpty(document.changeForm.newUnitCostDollars.value)) {
	        alert("Error: The dollar value of unit cost is required. Type 0 if unit cost is less than one dollar.");
	        document.changeForm.newUnitCostDollars.focus();
	        return false;
	    }
	  if (!intRegex.test(document.changeForm.newUnitCostDollars.value) && !isEmpty(document.changeForm.newUnitCostDollars.value)) {
	        alert("Error: The dollar value of unit cost must be an integer.");
	        document.changeForm.newUnitCostDollars.focus();
	        return false;
	    }
	  if (!intRegex.test(document.changeForm.newUnitCostCents.value) && !isEmpty(document.changeForm.newUnitCostCents.value)) {
	        alert("Error: The decimal value of unit cost must be an integer or blank.");
	        document.changeForm.newUnitCostCents.focus();
	        return false;
	    }
	  return true;
	}
	function confirmSubmit() {
	var agree=confirm("Are you sure you wish to DELETE this line item?");
	if (agree)
		return true ;
	else
		return false ;
	}
	function reload(form) {
		var day=form.dateDay.options[form.dateDay.options.selectedIndex].value;
		var month=form.dateMonth.options[form.dateMonth.options.selectedIndex].value;
		var year=form.dateYear.options[form.dateYear.options.selectedIndex].value; 
		self.location='manageLineItems.php?dateMonth=' + month + '&dateDay=' + day + '&dateYear=' + year;
	}
	function reload2(form) {
		var day=form.dateDay.options[form.dateDay.options.selectedIndex].value;
		var month=form.dateMonth.options[form.dateMonth.options.selectedIndex].value; 
		var year=form.dateYear.options[form.dateYear.options.selectedIndex].value;
		var lineItemID=form.lineItemID.options[form.lineItemID.options.selectedIndex].value;
		self.location='manageLineItems.php?dateMonth=' + month + '&dateDay=' + day + '&dateYear=' + year + '&lineItemID=' + lineItemID;
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

<h3>Manage Line Items</h3>
<div align="center">
<a href="points.php">Back to Points</a><br/><br/>
</div>                                       

<form name="myform" id="myform" onsubmit="return validate();" action="createLineItem.php" method="POST">
<table align="center">
	<tr><th colspan="2">Create Line Item</th></tr>         
	<tr bgcolor="#dbcfba"><td>
		<label for="lineItemName">Line Item Name: </label></td><td>
		<input type="text" name="lineItemName" size=32 maxlength=32>
	</td></tr>
	<tr bgcolor="#dbcfba"><td>
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
				if($selectedYear==$tempyear) { echo "selected"; }
				echo ">".$tempyear."</option>";
				$tempyear = $tempyear - 1;
			}
		?>
	</select></td></tr>
	<tr bgcolor="#dbcfba">
		<td><label for="unitCost">Unit Cost: </label></td>
		<td>$<input type="text" name="unitCostDollars" size="4" maxlength="4">.<input type="text" name="unitCostCents" size="2" maxlength="2"></td>
	</tr>
	<tr bgcolor="#dbcfba">
		<td><label for="description">Description: <br/>(optional, limit 100 characters)</label></td>	
		<td><textarea name="description" columns="3" rows="3" onKeyPress="return (this.value.length < 100);"><description></textarea></td>
	</tr>
	<tr><td colspan="2"><input type="submit" name="create" value="Create">&nbsp&nbsp&nbsp<input type="submit" name="createPlus" value="Create and Apply to Members"></td></tr>
</table>
</form>

<br/><hr/ width=800><br/>

<form name="deleteForm" action="deleteLineItem.php" method="POST">
<table align="center">
	<tr><th colspan="2">Delete Line Item</th></tr>
	<tr bgcolor="#dbcfba"><td>
	<label for="lineItemDate">Date: </label></td><td>
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
			while($tempyear >= $stopyear) {
				echo "<option value=\"".$tempyear."\" ";
				if($selectedYear==$tempyear) { echo "selected"; }
				echo ">".$tempyear."</option>";
				$tempyear = $tempyear - 1;
			}
		?>
	</select>
	</td></tr>
	<tr bgcolor="#dbcfba"><td>
	<label for="lineItemID">Line Item Name: </label></td><td>
	<select name="lineItemID" id="lineItemID">
	                     <option value="">---</option>
	<?php
		if($selectedDay != 0) {
	   	$query = $db->prepare("SELECT * FROM LineItem WHERE dateMonth=:selectedMonth AND dateDay=:selectedDay AND dateYear=:selectedYear ORDER BY dateDay");
		$query->execute(array('selectedMonth'=>$selectedMonth, 'selectedDay'=>$selectedDay, 'selectedYear'=>$selectedYear));
			$query->setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()) {
				            echo "<option value=\"";
				            echo $row[lineItemID];
				            echo "\"";
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
				            echo ">".$row[lineItemName]." (".$row[dateMonth]."-".$row[dateDay].")</option>";
				}
		}
	?>
	</select></td></tr>
	<tr><td colspan="2">
	<input type="submit" value="Delete" onClick="return confirmSubmit()">
	</td></tr>
	</table>
	</form>
	
	<br/><hr/ width=800><br/>
	
	<form name="changeForm" id="changeForm" onsubmit="return newvalidate();" action="changeLineItem.php" method="POST">
	<table align="center">
	<tr><th colspan="2">Edit Line Item</th></tr>
	<tr bgcolor="#dbcfba"><td>
		<label for="lineItemDate">Date: </label></td><td>
		<select name="dateMonth" id="dateMonth" onChange="reload2(this.form)">
			<option value="01"  <?PHP if($selectedMonth==1) echo "selected";?>>January</option>
			<option value="02"  <?PHP if($selectedMonth==2) echo "selected";?>>February</option>
			<option value="03"  <?PHP if($selectedMonth==3) echo "selected";?>>March</option>
			<option value="04"  <?PHP if($selectedMonth==4) echo "selected";?>>April</option>
			<option value="05"  <?PHP if($selectedMonth==5) echo "selected";?>>May</option>
			<option value="06"  <?PHP if($selectedMonth==6) echo "selected";?>>June</option>
			<option value="07"  <?PHP if($selectedMonth==7) echo "selected";?>>July</option>
			<option value="08"  <?PHP if($selectedMonth==8) echo "selected";?>>August</option>
			<option value="09"  <?PHP if($selectedMonth==9) echo "selected";?>>September</option>
			<option value="10"  <?PHP if($selectedMonth==10) echo "selected";?>>October</option>
			<option value="11"  <?PHP if($selectedMonth==11) echo "selected";?>>November</option>
			<option value="12"  <?PHP if($selectedMonth==12) echo "selected";?>>December</option>
		</select>
		<select name="dateDay" id="dateDay" onChange="reload2(this.form)">
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
		<select name="dateYear" id="dateYear" onChange="reload2(this.form)">
			<?php
				$tempyear = $currentyear;
				while($tempyear >= $stopyear) {
					echo "<option value=\"".$tempyear."\" ";
					if($selectedYear==$tempyear) { echo "selected"; }
					echo ">".$tempyear."</option>";
					$tempyear = $tempyear - 1;
				}
			?>
		</select>
		</td></tr>
		<tr bgcolor="#dbcfba"><td>
		<label for="lineItemID">Line Item Name: </label></td><td>
		<select name="lineItemID" id="lineItemID" onChange="reload2(this.form)">
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
		</select></td></tr>
		<?php
		if($selectedLineItem!="none") {
		   	$query = $db->prepare("SELECT * FROM LineItem WHERE lineItemID = :selectedLineItem");
			$query->execute(array('selectedLineItem'=>$selectedLineItem));
				$query->setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()) {
					echo "<tr><td colspan=2><hr/></td></tr>";
					echo "<tr bgcolor=\"#dbcfba\"><td>";
						echo "<label for=\"newLineItemName\">Line Item Name: </label></td><td>";
						echo "<input type=\"text\" name=\"newLineItemName\" value=\"".$row[lineItemName]."\" size=32 maxlength=32>";
					echo "</td></tr>";
					echo "<tr bgcolor=\"#dbcfba\"><td>";
               			echo "<label for=\"newLineItemDate\">Date: </label></td><td>";
               			echo "<select name=\"newDateMonth\" id=\"newDateMonth\">";
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
               			echo "<select name=\"newDateDay\" id=\"newDateDay\">";    
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
               			echo "<select name=\"newDateYear\" id=\"newDateYear\">";
							$tempyear = $currentyear;
							while($tempyear >= $stopyear) {
								echo "<option value=\"".$tempyear."\" ";
								if($row[dateYear]==$tempyear) { echo "selected"; }
								echo ">".$tempyear."</option>";
								$tempyear = $tempyear - 1;
							}
               			echo "</select></td></tr>";
               			$unitCostDollars=floor($row[unitCost]);
               			$unitCostCents=($row[unitCost]-$unitCostDollars)*100;
               			$unitCostCents=round($unitCostCents);
      
               			if($unitCostCents==0) $unitCostCents="00";
               			if($unitCostCents==1) $unitCostCents="01";
               			if($unitCostCents==2) $unitCostCents="02";
               			if($unitCostCents==3) $unitCostCents="03";
               			if($unitCostCents==4) $unitCostCents="04";
               			if($unitCostCents==5) $unitCostCents="05";
               			if($unitCostCents==6) $unitCostCents="06";
               			if($unitCostCents==7) $unitCostCents="07";
               			if($unitCostCents==8) $unitCostCents="08";
               			if($unitCostCents==9) $unitCostCents="09";
               			
               			echo "<tr bgcolor=\"#dbcfba\">";
							echo "<td><label for=\"newUnitCost\">Unit Cost: </label></td>";
							echo "<td>$<input type=\"text\" name=\"newUnitCostDollars\" value=\"".$unitCostDollars."\" size=\"4\" maxlength=\"4\">.<input type=\"text\" name=\"newUnitCostCents\" value=\"".$unitCostCents."\" size=\"2\" maxlength=\"2\"></td>";
						echo "</tr>";
						echo "<tr bgcolor=\"#dbcfba\">";
							echo "<td><label for=\"newDescription\">Description: <br/>(optional, limit 100 characters)</label></td>";
							echo "<td><textarea name=\"newDescription\" columns=\"3\" rows=\"3\" onKeyPress=\"return (this.value.length < 100);\">".$row[description]."</textarea></td>";
						echo "</tr>";
						echo "<tr><td colspan=\"2\">";	
               			echo "<input type=\"submit\" value=\"Update\">";
               			echo "</td></tr>";	
				}	
		}
		?>
	</table>
	</form>

<br/><br/><br/><br/>		

<?php require "html_footer.txt"; ?>
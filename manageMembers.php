<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isSecretary]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
<SCRIPT type="text/javascript">
	function confirmSubmit() 
	{
	var agree=confirm("Are you sure you wish to DELETE this member?");
	if (agree)
		return true ;
	else
		return false ;
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
	function hasWhiteSpace(s) {
	  return s.indexOf(' ') >= 0;
	}
	function validate() {
	  if (isEmpty(document.myform.username.value)) {
	        alert("Error: Username is required.");
	        document.myform.username.focus();
	        return false;
	    }
	  if (hasWhiteSpace(document.myform.username.value)) {
	        alert("Error: Username cannot contain a space. Try again.");
	        document.myform.username.focus();
	        return false;
	    }
	  if (hasWhiteSpace(document.myform.password.value)) {
	        alert("Error: Password cannot contain a space. Try again.");
	        document.myform.password.focus();
	        return false;
	    }
	  if (isEmpty(document.myform.firstName.value)) {
	        alert("Error: First name is required.");
	        document.myform.firstName.focus();
	        return false;
	    }
	  if (isEmpty(document.myform.lastName.value)) {
	        alert("Error: Last name is required.");
	        document.myform.lastName.focus();
	        return false;
	    }
	  if (!intRegex.test(document.myform.zipCode.value) && !isEmpty(document.myform.zipCode.value)) {
	        alert("Error: Zip code must be an integer.");
	        document.myform.zipCode.focus();
	        return false;
	    }
	  if (!intRegex.test(document.myform.joinYear.value) && !isEmpty(document.myform.joinYear.value)) {
	        alert("Error: Join year must be an integer.");
	        document.myform.joinYear.focus();
	        return false;
	    }
	  if (!intRegex.test(document.myform.gradYear.value) && !isEmpty(document.myform.gradYear.value)) {
	        alert("Error: Graduation year must be an integer.");
	        document.myform.gradYear.focus();
	        return false;
	    }
	  return true;		  
	}
	function validateCreate() {
	  if (isEmpty(document.createForm.username.value)) {
	        alert("Error: Username is required.");
	        document.createForm.username.focus();
	        return false;
	    }
	  if (hasWhiteSpace(document.createForm.username.value)) {
	        alert("Error: Username cannot contain a space. Try again.");
	        document.createForm.username.focus();
	        return false;
	    }
	  if (hasWhiteSpace(document.createForm.password.value)) {
	        alert("Error: Password cannot contain a space. Try again.");
	        document.createForm.password.focus();
	        return false;
	    }
	  if (isEmpty(document.createForm.firstName.value)) {
	        alert("Error: First name is required.");
	        document.createForm.firstName.focus();
	        return false;
	    }
	  if (isEmpty(document.createForm.lastName.value)) {
	        alert("Error: Last name is required.");
	        document.createForm.lastName.focus();
	        return false;
	    }
	  return true;
	}
	function reload(form){
	var selectedMember=form.selectedMember.options[form.selectedMember.options.selectedIndex].value;
	self.location='manageMembers.php?selectedMember=' + selectedMember;
	}
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br>

<?php
	@$selectedMember=$_GET[selectedMember];
	
	if(isset($selectedMember)) {
	} else {
	    $selectedMember = "none";
	}

	$query = $db->query("SELECT firstName, lastName, memberID FROM Member ORDER BY lastName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
?>


<h3>Manage Members</h3>
<div align="center">
<a href="points.php">Back to Points</a><br><br>
</div><br>

<form>
<table align="center">
<tr><th colspan="2">Edit Member</th></tr>
<tr bgcolor="#b3a369"><td>Select Member: </td>
<td>
<select name="selectedMember" id="selectedMember" onChange="reload(this.form)">
   <option value="none"  <?PHP if($selectedMember=='NULL') echo "selected";?>>---</option>

<?php
   while($row = $query->fetch()) {
          echo "<option value=\"".$row[memberID]."\" ";
           if($selectedMember==$row[memberID]) {
                  echo "selected";
           }
          echo ">".$row[lastName].", ".$row[firstName]."</option>";
   }    
?>

</select>
</td></tr>
</table>
</form>
</br></br>

<?php
	if($selectedMember != "none") {
		$query2 = $db->query("SELECT * FROM Member WHERE memberID = $selectedMember");
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		
		$row2 = $query2->fetch();
	} else {}

if($selectedMember != "none") {
?>
<form id="myform" name="myform" onsubmit="return validate();" action="manageMemberSettings.php" method="POST">
<table align="center">
<input type="hidden" name="memberID" value="<?php echo($row2[memberID]) ?>">
<tr bgcolor="#b3a369"><td>
<label for="username">Username: </label></td><td>
<input type="text" name="username" size=32 maxlength=32 value="<?php echo($row2[username]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="password">Reset Password: </label></td><td>
<input type="text" name="password" size=32 maxlength=32 value=""></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="firstName">First Name: </label></td><td>
<input type="text" name="firstName" size=32 maxlength=32 value="<?php echo($row2[firstName]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="lastName">Last Name: </label></td><td>
<input type="text" name="lastName" size=32 maxlength=32 value="<?php echo($row2[lastName]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="email">E-mail: </label></td><td>
<input type="text" name="email" size=32 maxlength=32 value="<?php echo($row2[email]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="phone">Phone Number: </label></td><td>
<input type="text" name="phone" size=32 maxlength=32 value="<?php echo($row2[phone]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="twitter">Twitter Handle: </label></td><td>
<input type="text" name="twitter" size=32 maxlength=32 value="<?php echo($row2[twitter]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="streetAddress">Street Address: </label></td><td>
<input type="text" name="streetAddress" size=32 maxlength=100 value="<?php echo($row2[streetAddress]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="city">City: </label></td><td>
<input type="text" name="city" size=32 maxlength=50 value="<?php echo($row2[city]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="state">State: </label></td><td>
<select name="state" id="state">
	<option value="" <?PHP if($row2[state]==NULL) echo "selected";?>>---</option>
	<option value="AL" <?PHP if($row2[state]=="AL") echo "selected";?>>AL</option>
	<option value="AK" <?PHP if($row2[state]=="AK") echo "selected";?>>AK</option>
	<option value="AZ" <?PHP if($row2[state]=="AZ") echo "selected";?>>AZ</option>
	<option value="AR" <?PHP if($row2[state]=="AR") echo "selected";?>>AR</option>
	<option value="CA" <?PHP if($row2[state]=="CA") echo "selected";?>>CA</option>
	<option value="CO" <?PHP if($row2[state]=="CO") echo "selected";?>>CO</option>
	<option value="CT" <?PHP if($row2[state]=="CT") echo "selected";?>>CT</option>
	<option value="DE" <?PHP if($row2[state]=="DE") echo "selected";?>>DE</option>
	<option value="FL" <?PHP if($row2[state]=="FL") echo "selected";?>>FL</option>
	<option value="GA" <?PHP if($row2[state]=="GA") echo "selected";?>>GA</option>
	<option value="HI" <?PHP if($row2[state]=="HI") echo "selected";?>>HI</option>
	<option value="ID" <?PHP if($row2[state]=="ID") echo "selected";?>>ID</option>
	<option value="IL" <?PHP if($row2[state]=="IL") echo "selected";?>>IL</option>
	<option value="IN" <?PHP if($row2[state]=="IN") echo "selected";?>>IN</option>
	<option value="IA" <?PHP if($row2[state]=="IA") echo "selected";?>>IA</option>
	<option value="KS" <?PHP if($row2[state]=="KS") echo "selected";?>>KS</option>
	<option value="KY" <?PHP if($row2[state]=="KY") echo "selected";?>>KY</option>
	<option value="LA" <?PHP if($row2[state]=="LA") echo "selected";?>>LA</option>
	<option value="ME" <?PHP if($row2[state]=="ME") echo "selected";?>>ME</option>
	<option value="MD" <?PHP if($row2[state]=="MD") echo "selected";?>>MD</option>
	<option value="MA" <?PHP if($row2[state]=="MA") echo "selected";?>>MA</option>
	<option value="MI" <?PHP if($row2[state]=="MI") echo "selected";?>>MI</option>
	<option value="MN" <?PHP if($row2[state]=="MN") echo "selected";?>>MN</option>
	<option value="MS" <?PHP if($row2[state]=="MS") echo "selected";?>>MS</option>
	<option value="MO" <?PHP if($row2[state]=="MO") echo "selected";?>>MO</option>
	<option value="MT" <?PHP if($row2[state]=="MT") echo "selected";?>>MT</option>
	<option value="NE" <?PHP if($row2[state]=="NE") echo "selected";?>>NE</option>
	<option value="NV" <?PHP if($row2[state]=="NV") echo "selected";?>>NV</option>
	<option value="NH" <?PHP if($row2[state]=="NH") echo "selected";?>>NH</option>
	<option value="NJ" <?PHP if($row2[state]=="NJ") echo "selected";?>>NJ</option>
	<option value="NM" <?PHP if($row2[state]=="NM") echo "selected";?>>NM</option>
	<option value="NY" <?PHP if($row2[state]=="NY") echo "selected";?>>NY</option>
	<option value="NC" <?PHP if($row2[state]=="NC") echo "selected";?>>NC</option>
	<option value="ND" <?PHP if($row2[state]=="ND") echo "selected";?>>ND</option>
	<option value="OH" <?PHP if($row2[state]=="OH") echo "selected";?>>OH</option>
	<option value="OK" <?PHP if($row2[state]=="OK") echo "selected";?>>OK</option>
	<option value="OR" <?PHP if($row2[state]=="OR") echo "selected";?>>OR</option>
	<option value="PA" <?PHP if($row2[state]=="PA") echo "selected";?>>PA</option>
	<option value="RI" <?PHP if($row2[state]=="RI") echo "selected";?>>RI</option>
	<option value="SC" <?PHP if($row2[state]=="SC") echo "selected";?>>SC</option>
	<option value="SD" <?PHP if($row2[state]=="SD") echo "selected";?>>SD</option>
	<option value="TN" <?PHP if($row2[state]=="TN") echo "selected";?>>TN</option>
	<option value="TX" <?PHP if($row2[state]=="TX") echo "selected";?>>TX</option>
	<option value="UT" <?PHP if($row2[state]=="UT") echo "selected";?>>UT</option>
	<option value="VT" <?PHP if($row2[state]=="VT") echo "selected";?>>VT</option>
	<option value="VA" <?PHP if($row2[state]=="VA") echo "selected";?>>VA</option>
	<option value="WA" <?PHP if($row2[state]=="WA") echo "selected";?>>WA</option>
	<option value="WV" <?PHP if($row2[state]=="WV") echo "selected";?>>WV</option>
	<option value="WI" <?PHP if($row2[state]=="WI") echo "selected";?>>WI</option>
	<option value="WY" <?PHP if($row2[state]=="WY") echo "selected";?>>WY</option>
</select></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="zipCode">Zip Code: </label></td><td>
<input type="text" name="zipCode" size=32 maxlength=5 value="<?php echo($row2[zipCode]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="joinYear">Year Joined RRC: </label></td><td>
<input type="text" name="joinYear" size=32 maxlength=4 value="<?php echo($row2[joinYear]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="gradDate">Graduation Date: </label></td><td>
<select name="gradMonth" id="gradMonth">
    <option value="" <?PHP if($row2[gradMonth]==NULL) echo "selected";?>>---</option>
	<option value="01"  <?PHP if($row2[gradMonth]==1) echo "selected";?>>January</option>
	<option value="02"  <?PHP if($row2[gradMonth]==2) echo "selected";?>>February</option>
	<option value="03"  <?PHP if($row2[gradMonth]==3) echo "selected";?>>March</option>
	<option value="04"  <?PHP if($row2[gradMonth]==4) echo "selected";?>>April</option>
	<option value="05"  <?PHP if($row2[gradMonth]==5) echo "selected";?>>May</option>
	<option value="06"  <?PHP if($row2[gradMonth]==6) echo "selected";?>>June</option>
	<option value="07"  <?PHP if($row2[gradMonth]==7) echo "selected";?>>July</option>
	<option value="08"  <?PHP if($row2[gradMonth]==8) echo "selected";?>>August</option>
	<option value="09"  <?PHP if($row2[gradMonth]==9) echo "selected";?>>September</option>
	<option value="10" <?PHP if($row2[gradMonth]==10) echo "selected";?>>October</option>
	<option value="11" <?PHP if($row2[gradMonth]==11) echo "selected";?>>November</option>
	<option value="12" <?PHP if($row2[gradMonth]==12) echo "selected";?>>December</option>
</select>
<input type="text" name="gradYear" size=15 maxlength=4 value="<?php echo($row2[gradYear]) ?>"></td></tr>
<tr bgcolor="#b3a369"><td>
<label for="reckerPair">Big Recker Pair: </label></td><td>
<select name="reckerPair" id ="reckerPair">
                      <option value="">---</option>
<?php
	$query = $db->query("SELECT memberID, firstName, lastName FROM Member ORDER BY lastName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		echo "<option value=\"";
		echo $row[memberID];
		echo "\"";
		if($row2[reckerPair] == $row[memberID]) {
			echo " selected";
		}
		echo ">".$row[lastName].", ".$row[firstName]."</option>";
	}
?>
</select>
</td></tr>
<tr bgcolor="#b3a369"><td>
<label for="status">Status: </label></td><td>
<select name="status" id="status">
	<option value="probate"  <?PHP if($row2[status]=="probate") echo "selected";?>>probate</option>
	<option value="member"  <?PHP if($row2[status]=="member") echo "selected";?>>member</option>
	<option value="social"  <?PHP if($row2[status]=="social") echo "selected";?>>social</option>
	<option value="alumni"  <?PHP if($row2[status]=="alumni") echo "selected";?>>alumni</option>
</select>
</td></tr>

<tr><td colspan="2">
<input type="submit" value="Update">
</td></tr></table>
</form>

</br></br>

<?php
} else{
?>

<br/><hr/ width=800><br/>

<form name="createForm" id="createForm" onsubmit="return validateCreate();" action="createMember.php" method="POST">
<table align="center">
<tr><th colspan="2">Create Member</th></tr>
<tr bgcolor="#b3a369"><td>
<label for="username">Username: </label></td><td>
<input type="text" name="username" size=32 maxlength=32>
</td></tr>
<tr bgcolor="#b3a369"><td>
<label for="password">Password: </label></td><td>
<input type="text" name="password" size=32 maxlength=32>
</td></tr>
<tr bgcolor="#b3a369"><td>
<label for="firstName">First Name: </label></td><td>
<input type="text" name="firstName" size=32 maxlength=32>
</td></tr>
<tr bgcolor="#b3a369"><td>
<label for="lastName">Last Name: </label></td><td>
<input type="text" name="lastName" size=32 maxlength=32>
</td></tr>
<tr bgcolor="#b3a369"><td>
<label for="status">Status: </label></td><td>
<select name="status" id="status">
	<option value="probate">probate</option>
	<option value="member">member</option>
	<option value="social">social</option>
	<option value="alumni">alumni</option>
</select>
</td></tr>
<tr><td colspan="2">
<input type="submit" value="Create">
</td></tr>
</table>
</form>

<br/><hr/ width=800><br/>

<?php
	$query3 = $db->query("SELECT memberID, firstName, lastName FROM Member ORDER BY lastName");
		$query3->setFetchMode(PDO::FETCH_ASSOC);
?>

<form name="deleteForm" action="deleteMember.php" method="POST">
<table align="center">
<tr><th colspan="2">Delete Member</th></tr>
<tr bgcolor="#b3a369"><td>Select Member: </td>
<td>
<select name="memberID" id="memberID">
   <option value="none">---</option>
<?php
   while($row3 = $query3->fetch()) {
          echo "<option value=\"".$row3[memberID]."\" ";
           if($selectedMember==$row3[memberID]) {
                  echo "selected";
           }
          echo ">".$row3[lastName].", ".$row3[firstName]."</option>";
   }    
?>
</select>
</td></tr>
<tr><td colspan="2">
<input type="submit" value="Delete" onClick="return confirmSubmit()">
</td></tr>
</table>
</form>

<?php
}
?>

</br></br>

<?php require "html_footer.txt"; ?>
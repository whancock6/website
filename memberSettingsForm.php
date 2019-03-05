<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
		<script type="text/javascript">
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
			function hasWhiteSpace(s) {
			  return s.indexOf(' ') >= 0;
			}
			function passwordCheck() {
			  if (hasWhiteSpace(document.thisform.newPassword.value)) {
			        alert("Error: Password cannot contain a space. Try again.");
			        document.thisform.newPassword.focus();
			        return false;
			    }
			  if (document.thisform.newPassword.value != document.thisform.confirmPassword.value) {
			        alert("Error: Password does not match. Try again.");
			        document.thisform.newPassword.focus();
			        return false;
			    }
			  return true;
			}
		</script>
<?php require "html_header_end.txt"; ?>

<br/>
<h3>Member Settings</h3>
<div align="center">
<a href="points.php">Back to Points</a><br><br>
</div>
<form name="myform" id="myform" onsubmit="return validate();" action="memberSettings.php" method="POST">
<table align="center">
<tr><td>
<label for="firstName">First Name: </label></td><td>
<input type="text" name="firstName" id="firstName" size=32 maxlength=32 value="<?php echo($firstName) ?>"></td></tr>
<tr><td>
<label for="lastName">Last Name: </label></td><td>
<input type="text" name="lastName" id="lastName" size=32 maxlength=32 value="<?php echo($lastName) ?>"></td></tr>
<tr><td>
<label for="email">E-mail: </label></td><td>
<input type="text" name="email" size=32 maxlength=32 value="<?php echo($email) ?>"></td></tr>
<tr><td>
<label for="phone">Phone Number: </label></td><td>
<input type="text" name="phone" size=32 maxlength=32 value="<?php echo($phone) ?>"></td></tr>
<tr><td>
<label for="twitter">Twitter Handle: </label></td><td>
<input type="text" name="twitter" size=32 maxlength=32 value="<?php echo($twitter) ?>"></td></tr>
<tr><td>
<label for="streetAddress">Street Address: </label></td><td>
<input type="text" name="streetAddress" size=32 maxlength=100 value="<?php echo($streetAddress) ?>"></td></tr>
<tr><td>
<label for="city">City: </label></td><td>
<input type="text" name="city" size=32  maxlength=50 value="<?php echo($city) ?>"></td></tr>
<tr><td>
<label for="state">State: </label></td><td>
<select name="state" id="state">
<option value="" <?PHP if($state==NULL) echo "selected";?>>---</option>
<option value="AL" <?PHP if($state=="AL") echo "selected";?>>AL</option>
<option value="AK" <?PHP if($state=="AK") echo "selected";?>>AK</option>
<option value="AZ" <?PHP if($state=="AZ") echo "selected";?>>AZ</option>
<option value="AR" <?PHP if($state=="AR") echo "selected";?>>AR</option>
<option value="CA" <?PHP if($state=="CA") echo "selected";?>>CA</option>
<option value="CO" <?PHP if($state=="CO") echo "selected";?>>CO</option>
<option value="CT" <?PHP if($state=="CT") echo "selected";?>>CT</option>
<option value="DE" <?PHP if($state=="DE") echo "selected";?>>DE</option>
<option value="FL" <?PHP if($state=="FL") echo "selected";?>>FL</option>
<option value="GA" <?PHP if($state=="GA") echo "selected";?>>GA</option>
<option value="HI" <?PHP if($state=="HI") echo "selected";?>>HI</option>
<option value="ID" <?PHP if($state=="ID") echo "selected";?>>ID</option>
<option value="IL" <?PHP if($state=="IL") echo "selected";?>>IL</option>
<option value="IN" <?PHP if($state=="IN") echo "selected";?>>IN</option>
<option value="IA" <?PHP if($state=="IA") echo "selected";?>>IA</option>
<option value="KS" <?PHP if($state=="KS") echo "selected";?>>KS</option>
<option value="KY" <?PHP if($state=="KY") echo "selected";?>>KY</option>
<option value="LA" <?PHP if($state=="LA") echo "selected";?>>LA</option>
<option value="ME" <?PHP if($state=="ME") echo "selected";?>>ME</option>
<option value="MD" <?PHP if($state=="MD") echo "selected";?>>MD</option>
<option value="MA" <?PHP if($state=="MA") echo "selected";?>>MA</option>
<option value="MI" <?PHP if($state=="MI") echo "selected";?>>MI</option>
<option value="MN" <?PHP if($state=="MN") echo "selected";?>>MN</option>
<option value="MS" <?PHP if($state=="MS") echo "selected";?>>MS</option>
<option value="MO" <?PHP if($state=="MO") echo "selected";?>>MO</option>
<option value="MT" <?PHP if($state=="MT") echo "selected";?>>MT</option>
<option value="NE" <?PHP if($state=="NE") echo "selected";?>>NE</option>
<option value="NV" <?PHP if($state=="NV") echo "selected";?>>NV</option>
<option value="NH" <?PHP if($state=="NH") echo "selected";?>>NH</option>
<option value="NJ" <?PHP if($state=="NJ") echo "selected";?>>NJ</option>
<option value="NM" <?PHP if($state=="NM") echo "selected";?>>NM</option>
<option value="NY" <?PHP if($state=="NY") echo "selected";?>>NY</option>
<option value="NC" <?PHP if($state=="NC") echo "selected";?>>NC</option>
<option value="ND" <?PHP if($state=="ND") echo "selected";?>>ND</option>
<option value="OH" <?PHP if($state=="OH") echo "selected";?>>OH</option>
<option value="OK" <?PHP if($state=="OK") echo "selected";?>>OK</option>
<option value="OR" <?PHP if($state=="OR") echo "selected";?>>OR</option>
<option value="PA" <?PHP if($state=="PA") echo "selected";?>>PA</option>
<option value="RI" <?PHP if($state=="RI") echo "selected";?>>RI</option>
<option value="SC" <?PHP if($state=="SC") echo "selected";?>>SC</option>
<option value="SD" <?PHP if($state=="SD") echo "selected";?>>SD</option>
<option value="TN" <?PHP if($state=="TN") echo "selected";?>>TN</option>
<option value="TX" <?PHP if($state=="TX") echo "selected";?>>TX</option>
<option value="UT" <?PHP if($state=="UT") echo "selected";?>>UT</option>
<option value="VT" <?PHP if($state=="VT") echo "selected";?>>VT</option>
<option value="VA" <?PHP if($state=="VA") echo "selected";?>>VA</option>
<option value="WA" <?PHP if($state=="WA") echo "selected";?>>WA</option>
<option value="WV" <?PHP if($state=="WV") echo "selected";?>>WV</option>
<option value="WI" <?PHP if($state=="WI") echo "selected";?>>WI</option>
<option value="WY" <?PHP if($state=="WY") echo "selected";?>>WY</option>
</select></td></tr>
<tr><td>
<label for="zipCode">Zip Code: </label></td><td>
<input type="text" name="zipCode" size=32 maxlength=5 value="<?php echo($zipCode) ?>"></td></tr>
<tr><td>
<label for="joinYear">Year Joined RRC: </label></td><td>
<input type="text" name="joinYear" size=32 maxlength=4 value="<?php echo($joinYear) ?>"></td></tr>
<tr><td>
<label for="gradDate">Graduation Date: </label></td><td>
<select name="gradMonth" id="gradMonth">
	<option value=""  <?PHP if($gradMonth==NULL) echo "selected";?>>---</option>
	<option value="01"  <?PHP if($gradMonth==1) echo "selected";?>>January</option>
	<option value="02"  <?PHP if($gradMonth==2) echo "selected";?>>February</option>
	<option value="03"  <?PHP if($gradMonth==3) echo "selected";?>>March</option>
	<option value="04"  <?PHP if($gradMonth==4) echo "selected";?>>April</option>
	<option value="05"  <?PHP if($gradMonth==5) echo "selected";?>>May</option>
	<option value="06"  <?PHP if($gradMonth==6) echo "selected";?>>June</option>
	<option value="07"  <?PHP if($gradMonth==7) echo "selected";?>>July</option>
	<option value="08"  <?PHP if($gradMonth==8) echo "selected";?>>August</option>
	<option value="09"  <?PHP if($gradMonth==9) echo "selected";?>>September</option>
	<option value="10" <?PHP if($gradMonth==10) echo "selected";?>>October</option>
	<option value="11" <?PHP if($gradMonth==11) echo "selected";?>>November</option>
	<option value="12" <?PHP if($gradMonth==12) echo "selected";?>>December</option>
</select>
<input type="text" name="gradYear" size=15 maxlength=4 value="<?php echo($gradYear) ?>"></td></tr>
<tr><td>
<label for="reckerPair">Big Recker Pair: </label></td><td>
<select name="reckerPair" id ="reckerPair">
                      <option value="" <?PHP if($reckerPair==NULL) echo "selected";?>>---</option>
<?php
	$query = $db->query("SELECT memberID, firstName, lastName FROM Member ORDER BY lastName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
	            echo "<option value=\"";
	            echo $row[memberID];
	            echo "\"";
	            if($reckerPair == $row[memberID]) {
	                             echo " selected";
	            }
	            echo ">".$row[lastName].", ".$row[firstName]."</option>";
	}
?>
</select>
</td></tr>
<tr><td>
<label for="status">Status: </label></td><td><?php echo($status) ?></td></tr>

<tr><td colspan="2">
<input type="submit" value="Update">
</td></tr></table>
</form>
<br/><br/><br/>
<form name="thisform" id="thisform" onsubmit="return passwordCheck();" action="memberChangePassword.php" method="POST">
<table align="center"><tr><td>
<label for="newPassword">New Password: </label></td><td>
<input type="password" name="newPassword" size=32 maxlength=32></td></tr><tr><td>
<label for="confirmPassword">Confirm Password: </label></td><td>
<input type="password" name="confirmPassword" size=32 maxlength=32></td></tr><tr><td colspan="2">
<input type="submit" value="Change Password"></td></tr>
</table>
</form>	

<?php require "html_footer.txt"; ?>
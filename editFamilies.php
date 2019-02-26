<?php
	require "logged_in_check.php";
	if ($_SESSION[isAdmin]==0 && $_SESSION[isVP]==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
<SCRIPT type="text/javascript" language="javascript1.2">
	function moveData1(dir) {
	    var sF = document.getElementById(((dir == "back")?"family1Select":"sourceSelect"));
	    var dF = document.getElementById(((dir == "back")?"sourceSelect":"family1Select"));
	    if(sF.length == 0 || sF.selectedIndex == -1) return;
	    while (sF.selectedIndex != -1) {
	        dF.options[dF.length] = new Option(sF.options[sF.selectedIndex].text, sF.options[sF.selectedIndex].value);
	        sF.options[sF.selectedIndex] = null;
	    }
	}
	function moveData2(dir) {
	    var sF = document.getElementById(((dir == "back")?"family2Select":"sourceSelect"));
	    var dF = document.getElementById(((dir == "back")?"sourceSelect":"family2Select"));
	    if(sF.length == 0 || sF.selectedIndex == -1) return;
	    while (sF.selectedIndex != -1) {
	        dF.options[dF.length] = new Option(sF.options[sF.selectedIndex].text, sF.options[sF.selectedIndex].value);
	        sF.options[sF.selectedIndex] = null;
	    }
	}
	function moveData3(dir) {
	    var sF = document.getElementById(((dir == "back")?"family3Select":"sourceSelect"));
	    var dF = document.getElementById(((dir == "back")?"sourceSelect":"family3Select"));
	    if(sF.length == 0 || sF.selectedIndex == -1) return;
	    while (sF.selectedIndex != -1) {
	        dF.options[dF.length] = new Option(sF.options[sF.selectedIndex].text, sF.options[sF.selectedIndex].value);
	        sF.options[sF.selectedIndex] = null;
	    }
	}
	function moveData4(dir) {
	    var sF = document.getElementById(((dir == "back")?"family4Select":"sourceSelect"));
	    var dF = document.getElementById(((dir == "back")?"sourceSelect":"family4Select"));
	    if(sF.length == 0 || sF.selectedIndex == -1) return;
	    while (sF.selectedIndex != -1) {
	        dF.options[dF.length] = new Option(sF.options[sF.selectedIndex].text, sF.options[sF.selectedIndex].value);
	        sF.options[sF.selectedIndex] = null;
	    }
	}
	function selectAll(selectBox,selectAll) { 
	    // have we been passed an ID 
	    if (typeof selectBox == "string") { 
	        selectBox = document.getElementById(selectBox);
	    } 
	    // is the select box a multiple select box? 
	    if (selectBox.type == "select-multiple") { 
	        for (var i = 0; i < selectBox.options.length; i++) { 
	             selectBox.options[i].selected = selectAll; 
	        } 
	    }
	}
</SCRIPT>
<?php require "html_header_end.txt"; ?>
<br/>

<h3>Edit Families</h3>
<div align="center">
<a href="families.php">Back to Families</a><br/><br/>
</div><br/>

<form action="updateFamilies.php" method="POST">
	<table align="center" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<!--Far Left Column-->
			<td>
				<table>
					<tr>
						<td align="center">
							<?php
								$query = $db->query("SELECT familyName FROM Family WHERE familyID=1");
									$query->setFetchMode(PDO::FETCH_ASSOC);
								$row = $query->fetch();
								echo "<input type=\"text\" width=\"250\" name=\"family1name\" value=\"".$row[familyName]."\">";
							?>	
						</td>	
					</tr>
					<tr>
						<td align="center"><select style="width: 200px" name="Family1Select[]" id="family1Select" size="15" multiple="multiple" ondblclick="moveData(); return false;">
							<?php
								$query = $db->query("SELECT * FROM Member WHERE memFamilyID = 1 AND status!='alumni' ORDER BY lastName, firstName");
									$query->setFetchMode(PDO::FETCH_ASSOC);
					      		while($row = $query->fetch()) {
					      			echo "<option value=\"".$row[memberID]."\">".$row[firstName]." ".$row[lastName]."</option>";
					      		}								
							?>
						</select></td>
					</tr>
					<tr>
						<td align="center">
							<?php
								$query = $db->query("SELECT familyName FROM Family WHERE familyID=2");
									$query->setFetchMode(PDO::FETCH_ASSOC);
								$row = $query->fetch();
								echo "<input type=\"text\" width=\"250\" name=\"family2name\" value=\"".$row[familyName]."\">";
							?>	
						</td>	
					</tr>
					<tr>
						<td align="center"><select style="width: 200px" name="Family2Select[]" id="family2Select" size="15" multiple="multiple" ondblclick="moveData(); return false;">
							<?php
								$query = $db->query("SELECT * FROM Member WHERE memFamilyID = 2 AND status!='alumni' ORDER BY lastName, firstName");
									$query->setFetchMode(PDO::FETCH_ASSOC);
					      		while($row = $query->fetch()) {
					      			echo "<option value=\"".$row[memberID]."\">".$row[firstName]." ".$row[lastName]."</option>";
					      		}								
							?>
						</select></td>
					</tr>
				</table>
			</td>
			<!--Left Column-->
			<td>
				<table>
					<tr>
						<td width="50" align="center" valign="middle"><input type="submit" name="forward" id="button" value="<<<" onclick="moveData1(); return false;"/></td>
					</tr>
					<tr>
						<td width="50" align="center" valign="middle"><input type="submit" name="back" id="button" value=">>>" onclick="moveData1('back'); return false;"/></td>
					</tr>
					<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
					<tr>
						<td width="50" align="center" valign="middle"><input type="submit" name="forward" id="button" value="<<<" onclick="moveData2(); return false;"/></td>
					</tr>
					<tr>
						<td width="50" align="center" valign="middle"><input type="submit" name="back" id="button" value=">>>" onclick="moveData2('back'); return false;"/></td>
					</tr>
					<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
				</table>	
			</td>
			<!--Center Column-->
			<td>
				<table>
					<tr>
						<th>Family-less Members</th>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td align="center"><select style="width: 200px" name="SourceSelect[]" id="sourceSelect" size="30" multiple="multiple" ondblclick="moveData(); return false;">
							<?php
								$query = $db->query("SELECT * FROM Member WHERE memFamilyID IS NULL AND status!='alumni' ORDER BY lastName, firstName");
									$query->setFetchMode(PDO::FETCH_ASSOC);
					      		while($row = $query->fetch()) {
					      			echo "<option value=\"".$row[memberID]."\">".$row[firstName]." ".$row[lastName]."</option>";
					      		}
							?>
						</select></td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td><input type="submit" value="Update" onclick="selectAll('sourceSelect',true); selectAll('family1Select',true); selectAll('family2Select',true); selectAll('family3Select',true);  selectAll('family4Select',true); return true;"></td>
					</tr>
				</table>
			</td>
			<!--Right Column-->
			<td>
				<table>
					<tr>
						<td width="50" align="center" valign="middle"><input type="submit" name="forward" id="button" value=">>>" onclick="moveData3(); return false;"/></td>
					</tr>
					<tr>
						<td width="50" align="center" valign="middle"><input type="submit" name="back" id="button" value="<<<" onclick="moveData3('back'); return false;"/></td>
					</tr>
					<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
					<tr>
						<td width="50" align="center" valign="middle"><input type="submit" name="forward" id="button" value=">>>" onclick="moveData4(); return false;"/></td>
					</tr>
					<tr>
						<td width="50" align="center" valign="middle"><input type="submit" name="back" id="button" value="<<<" onclick="moveData4('back'); return false;"/></td>
					</tr>
					<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
				</table>	
			</td>
			<!--Far Right Column-->
			<td>
				<table>
					<tr>
						<td align="center">
							<?php
								$query = $db->query("SELECT familyName FROM Family WHERE familyID=3");
									$query->setFetchMode(PDO::FETCH_ASSOC);
								$row = $query->fetch();
								echo "<input type=\"text\" width=\"250\" name=\"family3name\" value=\"".$row[familyName]."\">";
							?>	
						</td>	
					</tr>
					<tr>
						<td align="center"><select style="width: 200px" name="Family3Select[]" id="family3Select" size="15" multiple="multiple" ondblclick="moveData(); return false;">
							<?php
								$query = $db->query("SELECT * FROM Member WHERE memFamilyID = 3 AND status!='alumni' ORDER BY lastName, firstName");
									$query->setFetchMode(PDO::FETCH_ASSOC);
					      		while($row = $query->fetch()) {
					      			echo "<option value=\"".$row[memberID]."\">".$row[firstName]." ".$row[lastName]."</option>";
					      		}								
							?>
						</select></td>
					</tr>
					<tr>
						<td align="center">
							<?php
								$query = $db->query("SELECT familyName FROM Family WHERE familyID=4");
									$query->setFetchMode(PDO::FETCH_ASSOC);
								$row = $query->fetch();
								echo "<input type=\"text\" width=\"250\" name=\"family4name\" value=\"".$row[familyName]."\">";
							?>	
						</td>	
					</tr>
					<tr>
						<td align="center"><select style="width: 200px" name="Family4Select[]" id="family4Select" size="15" multiple="multiple" ondblclick="moveData(); return false;">
							<?php
								$query = $db->query("SELECT * FROM Member WHERE memFamilyID = 4 AND status!='alumni' ORDER BY lastName, firstName");
									$query->setFetchMode(PDO::FETCH_ASSOC);
					      		while($row = $query->fetch()) {
					      			echo "<option value=\"".$row[memberID]."\">".$row[firstName]." ".$row[lastName]."</option>";
					      		}								
							?>
						</select></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>

<br/><br/><br/><br/>

<?php require "html_footer.txt"; ?>
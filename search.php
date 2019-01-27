<?php
	require "logged_in_check.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
?>
<SCRIPT language=JavaScript>
function reload(form){
	var q = form.q.value;
	self.location = 'search.php?q=' + q;
}
</SCRIPT>
<?php require "html_header_end.txt"; ?>

<br/>

<?php
	@$q=$_GET[q];
	if(isset($q)) {
     	$q = $q;
    } else {
        $q = "";
    }
?>

<h3>Reck Club Site Search</h3>

<div align="center">
<a href="points.php">Back to Points</a><br/>
<br/><br/><br/>

<form>
	<table align="center">
		<tr><td>Enter your question: </td></tr>
		<tr><td><input type="text" name="q" id="q" size="75"></td></tr>
		<tr><td><input type="button" value="Ask your question!" onclick="reload(this.form)"></td></tr>
	</table>
</form>

<br/><br/><br/>

<?php 
	if ($q != "") {
		echo "<table align=\"center\">
			<tr><td>Your question: </td><td>".$q."</td></tr>
		</table><br/><br/>";
		$q = strtoupper($q);
/* THWG */
		if (preg_match("/WHAT/i", $q)) {
			if (preg_match("/THE/i", $q)) {
				if (preg_match("/GOOD/i", $q)) {
					if (preg_match("/WORD/i", $q)) {
						echo "<table align=\"center\"><tr><td>TO HELL WITH georgia</td></tr></table>";
					}
				}
			}
		}
/* PROBATES */
		elseif (preg_match("/PROBATE/i", $q)) {
			if (preg_match("/([0-9]{4})/", $q, $year)) {
				$query = $db->prepare("SELECT CONCAT(firstName, ' ', lastName) AS FullName, email FROM Member WHERE joinYear=:year");
				$query->execute(array('year'=>$year[0]));
					$query->setFetchMode(PDO::FETCH_ASSOC);
				$probates = $query->fetchAll();

				echo "<table align=\"center\"><tr><td colspan=\"2\"><u>".$year[0]." PROBATES:</u></td></tr>";
				foreach ($probates as $p) {
					echo "<tr><td>".$p[FullName]."</td><td>".$p[email]."</td></tr>";
				}
				echo "</table>";
			}
		}
/* POSITIONS */		
		elseif (preg_match("/DRIVER|PRESIDENT|PREZ|VICE PRESIDENT|VP|SECRETARY|TREASURER|MEMBER AT LARGE|MEMBERS AT LARGE|MAL|EXEC|HOMECOMING CHAIR|ALUMNI CHAIR|TECHNOLOGY CHAIR|TECH CHAIR|PUBLICITY CHAIR|PUB CHAIR|PR CHAIR|TRADITIONS CHAIR|TRADITION CHAIR|T-NIGHT CHAIR|TNIGHT CHAIR|BASKETBALL CHAIR|BASEBALL CHAIR|FOOTBALL CHAIR|NON-REVENUE SPORTS CHAIR|NON-REVENUE CHAIR|NON-REV SPORTS CHAIR|NON REV SPORTS CHAIR|NONREV SPORTS CHAIR|NON-REV CHAIR|NON REV CHAIR|NONREV CHAIR|MINI 500 CHAIR|MINI 5 CHAIR|MINI5 CHAIR|RECK PARADE PROGRAMS CHAIR|PROGRAMS CHAIR|FRESHMAN CAKE RACE CHAIR|CAKE RACE CHAIR|T-BOOK CHAIR|TBOOK CHAIR|MEMBERSHIP CHAIR|PROBATE CHAIR|FLASHCARDS CHAIR|FLASHCARD CHAIR|RECK PARADE CHAIR|PARADE CHAIR/i", $q, $position)) {
			if ($position[0] == "PREZ") { $position[0]="PRESIDENT"; }
			elseif ($position[0] == "VP") { $position[0]="VICE PRESIDENT"; }
			elseif ($position[0] == "MEMBER AT LARGE" || $position[0] == "MEMBERS AT LARGE" || $position[0] == "MAL") { $position[0]="MEMBER AT LARGE (MAL)"; }
			elseif ($position[0] == "EXEC") { $position[0]="DRIVER, PRESIDENT, VICE PRESIDENT, SECRETARY, TREASURER, MEMBER AT LARGE (MAL)"; }
			elseif ($position[0] == "TECH CHAIR") { $position[0]="TECHNOLOGY CHAIR"; }
			elseif ($position[0] == "PUB CHAIR" || $position[0] == "PR CHAIR") { $position[0]="PUBLICITY CHAIR"; }
			elseif ($position[0] == "TRADITION CHAIR") { $position[0]="TRADITIONS CHAIR"; }
			elseif ($position[0] == "TNIGHT CHAIR") { $position[0]="T-NIGHT CHAIR"; }
			elseif ($position[0] == "NON-REVENUE CHAIR" || $position[0] == "NON-REV SPORTS CHAIR" || $position[0] == "NON REV SPORTS CHAIR" || $position[0] == "NONREV SPORTS CHAIR" || $position[0] == "NON-REV CHAIR" || $position[0] == "NON REV CHAIR" || $position[0] == "NONREV CHAIR") { $position[0]="NON-REVENUE SPORTS CHAIR"; }
			elseif ($position[0] == "MINI 5 CHAIR" || $position[0] == "MINI5 CHAIR") { $position[0]="MINI 500 CHAIR"; }
			elseif ($position[0] == "PROGRAMS CHAIR") { $position[0]="RECK PARADE PROGRAMS CHAIR"; }
			elseif ($position[0] == "CAKE RACE CHAIR") { $position[0]="FRESHMAN CAKE RACE CHAIR"; }
			elseif ($position[0] == "TBOOK CHAIR") { $position[0]="T-BOOK CHAIR"; }
			elseif ($position[0] == "PROBATE CHAIR") { $position[0]="MEMBERSHIP CHAIR"; }
			elseif ($position[0] == "FLASHCARD CHAIR") { $position[0]="FLASHCARDS CHAIR"; }
			elseif ($position[0] == "PARADE CHAIR") { $position[0]="RECK PARADE CHAIR"; }
			else {}
			if (preg_match("/([0-9]{4})/", $q, $year)) {
				if ($position[0] == "DRIVER, PRESIDENT, VICE PRESIDENT, SECRETARY, TREASURER, MEMBER AT LARGE (MAL)") {
					$query = $db->prepare("SELECT p.positionName, hp.year, CONCAT(firstName, ' ', lastName) AS FullName, m.email FROM Member m INNER JOIN HoldsPosition hp ON m.memberID=hp.memberID INNER JOIN Position p ON p.positionID=hp.positionID WHERE :position LIKE CONCAT('%', p.positionName, '%') AND hp.year=:year ORDER BY p.positionID");
				} else {
					$query = $db->prepare("SELECT p.positionName, hp.year, CONCAT(firstName, ' ', lastName) AS FullName, m.email FROM Member m INNER JOIN HoldsPosition hp ON m.memberID=hp.memberID INNER JOIN Position p ON p.positionID=hp.positionID WHERE p.positionName=:position AND hp.year=:year ORDER BY p.positionID");
				}
				$query->execute(array('position'=>$position[0], 'year'=>$year[0]));
					$query->setFetchMode(PDO::FETCH_ASSOC);
				$positionInfo = $query->fetchAll();

				echo "<table align=\"center\"><tr><td><u>Year</u></td><td>&nbsp;&nbsp;&nbsp;</td><td><u>Position</u></td><td>&nbsp;&nbsp;&nbsp;</td><td><u>Name</u></td><td>&nbsp;&nbsp;&nbsp;</td><td><u>Email</u></td></tr>";
				foreach ($positionInfo as $pi) {
					echo "<tr><td>".$pi[year]."</td><td></td><td>".$pi[positionName]."</td><td></td><td>".$pi[FullName]."</td><td></td><td>".$pi[email]."</td></tr>";
				}
				echo "</table>";
			} else {
				if ($position[0] == "DRIVER, PRESIDENT, VICE PRESIDENT, SECRETARY, TREASURER, MEMBER AT LARGE (MAL)") {
					$query = $db->prepare("SELECT p.positionName, hp.year, CONCAT(firstName, ' ', lastName) AS FullName, m.email FROM Member m INNER JOIN HoldsPosition hp ON m.memberID=hp.memberID INNER JOIN Position p ON p.positionID=hp.positionID WHERE :position LIKE CONCAT('%', p.positionName, '%') ORDER BY hp.year DESC, p.positionID");
				} else {
					$query = $db->prepare("SELECT p.positionName, hp.year, CONCAT(firstName, ' ', lastName) AS FullName, m.email FROM Member m INNER JOIN HoldsPosition hp ON m.memberID=hp.memberID INNER JOIN Position p ON p.positionID=hp.positionID WHERE p.positionName=:position ORDER BY hp.year DESC, p.positionID");
				}
				$query->execute(array('position'=>$position[0]));
					$query->setFetchMode(PDO::FETCH_ASSOC);
				$positionInfo = $query->fetchAll();

				echo "<table align=\"center\"><tr><td><u>Year</u></td><td>&nbsp;&nbsp;&nbsp;</td><td><u>Position</u></td><td>&nbsp;&nbsp;&nbsp;</td><td><u>Name</u></td><td>&nbsp;&nbsp;&nbsp;</td><td><u>Email</u></td></tr>";
				foreach ($positionInfo as $pi) {
					echo "<tr><td>".$pi[year]."</td><td></td><td>".$pi[positionName]."</td><td></td><td>".$pi[FullName]."</td><td></td><td>".$pi[email]."</td></tr>";
				}
				echo "</table>";
			}
		}
/* COMMITTEES */
		elseif (preg_match("/COMMITTEE|COMITTEE|COMMITEE|COMITEE/i", $q)) {
			if (preg_match("/T-NIGHT|TNIGHT|TRADITION|ALUMNI|HOMECOMING|NON-REV|NON REV|NONREV|BASEBALL|T-BOOK|TBOOK|FOOTBALL|PUB|PR|TECH/i", $q, $committee)) {
				if ($committee[0] == "TNIGHT") { $committee[0]="T-NIGHT"; }
				elseif ($committee[0] == "TRADITION") { $committee[0]="TRADITIONS"; }
				elseif ($committee[0] == "NON-REV" || $committee[0] == "NON REV" || $committee[0] == "NONREV") { $committee[0]="NON-REVENUE SPORTS"; }
				elseif ($committee[0] == "TBOOK") { $committee[0]="T-BOOK"; }
				elseif ($committee[0] == "PUB" || $committee[0] == "PR") { $committee[0]="PUBLIC RELATIONS"; }
				elseif ($committee[0] == "TECH") { $committee[0]="TECHNOLOGY"; }
				else {}
				if (preg_match("/([0-9]{4})/", $q, $year)) {
					$query = $db->prepare("SELECT c.committeeName, oc.year, CONCAT(firstName, ' ', lastName) AS FullName, m.email FROM Member m INNER JOIN OnCommittee oc ON m.memberID=oc.memberID INNER JOIN Committee c ON c.committeeID=oc.committeeID WHERE c.committeeName=:committee AND oc.year=:year ORDER BY lastname");
					$query->execute(array('committee'=>$committee[0], 'year'=>$year[0]));
						$query->setFetchMode(PDO::FETCH_ASSOC);
					$committeeInfo = $query->fetchAll();

					echo "<table align=\"center\"><tr><td><u>  Year  </u></td><td><u>  Committee  </u></td><td><u>  Name  </u></td><td><u>  Email  </u></td></tr>";
					foreach ($committeeInfo as $ci) {
						echo "<tr><td>".$ci[year]."</td><td>".$ci[committeeName]."</td><td>".$ci[FullName]."</td><td>".$ci[email]."</td></tr>";
					}
					echo "</table>";
				} else {
					$query = $db->prepare("SELECT c.committeeName, oc.year, CONCAT(firstName, ' ', lastName) AS FullName, m.email FROM Member m INNER JOIN OnCommittee oc ON m.memberID=oc.memberID INNER JOIN Committee c ON c.committeeID=oc.committeeID WHERE c.committeeName=:committee ORDER BY oc.year DESC, lastname");
					$query->execute(array('committee'=>$committee[0]));
						$query->setFetchMode(PDO::FETCH_ASSOC);
					$committeeInfo = $query->fetchAll();

					echo "<table align=\"center\"><tr><td><u>  Year  </u></td><td><u>  Committee  </u></td><td><u>  Name  </u></td><td><u>  Email  </u></td></tr>";
					foreach ($committeeInfo as $ci) {
						echo "<tr><td>".$ci[year]."</td><td>".$ci[committeeName]."</td><td>".$ci[FullName]."</td><td>".$ci[email]."</td></tr>";
					}
					echo "</table>";
				}
			}
		}
/* PROFILES */
		elseif (preg_match("/PROFILE/i", $q)) {
			if(preg_match_all("/\b([\w\-\']*)\b/i", $q, $names)) {
				$query = $db->prepare("SELECT memberID FROM Member WHERE firstName LIKE CONCAT('%', :n, '%') OR :n LIKE CONCAT('%', firstname, '%') ORDER BY lastName, firstName");
				$firstName = array();
				foreach ($names[0] as $n) {
					if ($n != "") {
						$query->execute(array('n'=>$n));
						$count = $query->rowCount();
						if ($count > 0) {
								$query->setFetchMode(PDO::FETCH_ASSOC);
							$memberInfo = $query->fetchAll();

							foreach ($memberInfo as $m) {
								$firstName[] = $m[memberID];
							}
						}
					}
				}
				$query = $db->prepare("SELECT memberID FROM Member WHERE lastName LIKE CONCAT('%', :n, '%') OR :n LIKE CONCAT('%', lastname, '%') ORDER BY lastName, firstName");
				$lastName = array();
				foreach ($names[0] as $n) {
					if ($n != "") {
						$query->execute(array('n'=>$n));
						$count = $query->rowCount();
						if ($count > 0) {
								$query->setFetchMode(PDO::FETCH_ASSOC);
							$memberInfo = $query->fetchAll();

							foreach ($memberInfo as $m) {
								$lastName[] = $m[memberID];
							}
						}
					}
				}
				$bothNames = array_unique(array_intersect($firstName, $lastName));
				if (count($firstName) == 0 && count($lastName) == 0) {
					echo "<table align=\"center\"><tr><td>No results found for that name. Please try again.</td></tr></table>";
				} else {
					if (count($bothNames) != 1) {
						$allNames = array_unique(array_merge($firstName, $lastName));
						echo "<table align=\"center\"><tr><td><u>Please choose a name:</u></td></tr>";
						$query = $db->prepare("SELECT firstName, lastName FROM Member WHERE memberID = :id");
						foreach ($allNames as $an) {
							$query->execute(array('id'=>$an));
								$query->setFetchMode(PDO::FETCH_ASSOC);
							$memberName = $query->fetchAll();

							foreach ($memberName as $mName) {
								echo "<tr><td><a href=\"search.php?q=Profile+".$mName[firstName]."+".$mName[lastName]."\">".$mName[firstName]." ".$mName[lastName]."</a></td></tr>";
							}
						}
						echo "</table>";
					} else {
						$query = $db->prepare("SELECT m.firstName, m.lastName, m.email, m.joinYear, m.gradYear, rp.firstName AS rpFirstName, rp.lastName AS rpLastName FROM Member m INNER JOIN Member rp ON m.reckerPair=rp.memberID WHERE m.memberID = :id");
						$query->execute(array('id'=>current($bothNames)));
							$query->setFetchMode(PDO::FETCH_ASSOC);
						$profileInfo = $query->fetchAll();

						$query = $db->prepare("SELECT hp.year, p.positionName FROM HoldsPosition hp INNER JOIN Position p ON hp.positionID=p.positionID WHERE hp.memberID = :id ORDER BY hp.year DESC");
						$query->execute(array('id'=>current($bothNames)));
						$posCount = $query->rowCount();
							$query->setFetchMode(PDO::FETCH_ASSOC);
						$positionInfo = $query->fetchAll();

						$query = $db->prepare("SELECT oc.year, c.committeeName FROM OnCommittee oc INNER JOIN Committee c ON oc.committeeID=c.committeeID WHERE oc.memberID = :id ORDER BY oc.year DESC");
						$query->execute(array('id'=>current($bothNames)));
						$comCount = $query->rowCount();
							$query->setFetchMode(PDO::FETCH_ASSOC);
						$committeeInfo = $query->fetchAll();

						echo "<table align=\"center\">";
						echo "<tr><td>";

						echo "</td></tr>";

						echo "<table align=\"center\">";
						foreach ($profileInfo as $pi) {
							echo "<tr><td colspan=\"5\"><u>The Ramblin' Reck Club Profile of ".$pi[firstName]." ".$pi[lastName]."</u></td></tr>";
							echo "<tr><td colspan=\"5\"></td></tr>";
							echo "<tr><td colspan=\"5\"></td></tr>";
							echo "<tr><td><b>Email: </b></td><td>".$pi[email]."</td><td>&nbsp&nbsp&nbsp&nbsp</td><td><b>Joined RRC In: </b></td><td>".$pi[joinYear]."</td></tr>";
							echo "<tr><td><b>Big Recker Pair: </b></td><td>".$pi[rpFirstName]." ".$pi[rpLastName]."</td><td>&nbsp&nbsp&nbsp&nbsp</td><td><b>Graduation Year: </b></td><td>".$pi[gradYear]."</td></tr>";
							echo "<tr><td colspan=\"5\"><hr></td></tr>";
							echo "<tr><td colspan=\"2\" valign=\"top\">";
								echo "<table>";
								echo "<tr><td colspan=\"2\"><b>Positions: </b></td></tr>";
								if ($posCount == 0) {
									echo "<tr><td colspan=\"2\">&lt;no results&gt;</td></tr>";
								} else {
									foreach ($positionInfo as $posi) {
										echo "<tr><td>".$posi[year]."</td><td>".$posi[positionName]."</td></tr>";
									}
								}
								echo "</table>";
							echo "</td><td>&nbsp&nbsp&nbsp&nbsp</td><td colspan=\"2\" valign=\"top\">";
								echo "<table>";
								echo "<tr><td colspan=\"2\"><b>Committees: </b></td></tr>";
								if ($comCount == 0) {
									echo "<tr><td colspan=\"2\">&lt;no results&gt;</td></tr>";
								} else {
									foreach ($committeeInfo as $comi) {
										echo "<tr><td>".$comi[year]."</td><td>".$comi[committeeName]."</td></tr>";
									}
								}
								echo "</table>";
							echo "</td></tr>";
						}
						echo "</table>";
					}
				}
			}
		}
	}
?>

<br/><br/><br/><br/><br/><br/>
<?php require "html_footer.txt"; ?>
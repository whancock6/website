<?php
require "logged_in_check.php";
require "database_connect.php";
require "set_session_vars_short.php";
require "html_header_begin.txt";
?>
<title>Friends | Ramblin' Reck Club</title>
<style>
    .navigation-link {
        background:none!important;
        color: #005ace;
        border:none;
        padding:0!important;
        font: inherit;
        /*border is optional*/
        /*border-bottom:1px solid #444;*/
        cursor: pointer;
    }

    .navigation-link:hover {
        text-decoration: underline;
        color: #39f;
    }
</style>
<?php require "html_header_end.txt"; ?>

<h3>Friends List</h3>

<div align="center">
<!--    <a href="points.php">Back to Points</a><br/><br/>-->
    <?php
        echo "<form action=\"allAttended.php\" method=\"POST\">";
        echo "<tr><td><button class='navigation-link' type=\"submit\">Back to Profile</button></td></tr>";
        echo "<input type=\"hidden\" name=\"memberID\" value=\"".$_GET[memberId]."\">";
        echo "</form>";
    ?>
</div>

<?php

$currentMemID = $_GET[memberId];

$query = $db->prepare("SELECT firstName, lastName, memberPoints FROM Member WHERE memberID=:currentMemID");
$query->execute(array('currentMemID'=>$currentMemID));
$query->setFetchMode(PDO::FETCH_ASSOC);

$row = $query->fetch();
$currentFirstName = $row[firstName];
$currentLastName = $row[lastName];
$currentMemberPoints = $row[memberPoints];

$attendanceQuery = $db->prepare("SELECT eventId from reck_club.AttendsEvent WHERE memberID=:currentMemID");
$attendanceQuery->execute(array('currentMemID'=>$currentMemID));
$attendanceQuery->setFetchMode(PDO::FETCH_ASSOC);
$eventIds = [];

while ($row = $attendanceQuery->fetch()) {
    $eventIds[] = $row[eventId];
}

$eventIdsString = "'".implode("','", $eventIds) . "'";

$eventGroupsQuery = $db->prepare("SELECT eventID,memberID FROM reck_club.AttendsEvent WHERE eventID IN($eventIdsString) AND NOT memberID=:curMemId GROUP BY memberID, eventID");
//print_r($eventGroupsQuery);
$eventGroupsQuery->execute(array('curMemId' => $currentMemID));
$eventGroupsQuery->setFetchMode(PDO::FETCH_ASSOC);
$memberEventArray = [];
while($row = $eventGroupsQuery->fetch()) {
    if (!key_exists($row[memberID], $memberEventArray) && (!empty($row[memberID]) && isset($row[memberID]) && strlen($row[memberID] > 0) && !is_null($row[memberID]))) {
        $memberEventArray[$row[memberID]] = [];
    }

    $memberEventArray[$row[memberID]][] = $row[eventID];
}

$memberCountArray = [];
foreach ($memberEventArray as $currentMemberId => $events) {
    $memberCountArray[$currentMemberId] = sizeof($events);
}

//print_r($memberCountArray);
$memberIdString = "'".implode("','", array_keys($memberCountArray)) . "'";
$peopleQuery = $db->query("SELECT memberID, firstName, lastName FROM Member WHERE memberID IN($memberIdString)");
$peopleQuery->execute();
$peopleQuery->setFetchMode(PDO::FETCH_ASSOC);
$people = [];

while ($row = $peopleQuery->fetch()) {
    if (!key_exists($row[memberID], $people) && (!empty($row[memberID]) && isset($row[memberID]) && strlen($row[memberID] > 0) && !is_null($row[memberID]))) {
        $people[$row[memberID]] = '';
    }

    $people[$row[memberID]] = $row[firstName] . ' ' . $row[lastName];
}

?>

<table align="center">
    <td colspan="5">
        <div id="spacing_div" style="width:400px;"></div>
    </td>
    <tr bgcolor="#b3a369"><th colspan="5"><?php echo($currentFirstName) ?> <?php echo($currentLastName) ?></th></tr>
    <tr><td colspan="5">Total Events Attended: <?php echo sizeof($eventIds) ?></td></tr>
</table>
<table align="center" width="408px">
    <tr bgcolor="#b3a369"><th colspan="5">Friends</th></tr>
    <?php
    $sortedKeys = arsort($memberCountArray);
    if (sizeof($sortedKeys) > 0) {
        echo "<tr><th>Rank</th><th colspan=\"3\">Member</th><th colspan=\"2\">% Events Shared</th></tr>";
        $count = 1;
        foreach ($memberCountArray as $currentMemberId => $eventCount) {
            $name = $people[$currentMemberId];
            if (strlen($name) > 0) {
                if ($currentMemberId == $memberID) {
                    echo "<tr bgcolor=\"#b3a369\">";
                } else {
                    echo "<tr>";
                }
                echo "<td>" . $count . "</td>";
                echo "<td colspan='3'>" . $people[$currentMemberId] . "</td>";

                $attendancePct = number_format(($eventCount/sizeof($eventIds))*100,1);
                echo "<td colspan='2'>" . $eventCount . '/' . sizeof($eventIds) . ' (' . $attendancePct . '%)</td></tr>';
                $count++;
            }
        }
    } else {
        echo "<tr><td>No members with shared events.</td></tr>";
    }
    ?>

</table>
<br/><br/><br/><br/>

<?php require "html_footer.txt"; ?>
<?php
    require "logged_in_check.php";
    require "database_connect.php";
    require "set_session_vars_short.php";
    require "html_header_begin.txt";
    $pageTitle = "Friends";
?>

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

<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<body>
<?php require "partials/header.php"; ?>

<div class="container">
    <div class="row mb-3">
        <div class="col-12">
            <h3 class="float-left">Friends List for: <?php echo $currentFirstName . " " . $currentLastName; ?></h3>
            <h3 class="float-right">Total Events Attended: <?php echo sizeof($eventIds) ?></h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <table class="table table-hover table-sm mb-3">
                <?php
                    $sortedKeys = arsort($memberCountArray);
                    if (sizeof($sortedKeys) > 0) {
                        echo "<thead><tr><th>Rank</th><th>Member</th><th>% Events Shared</th></tr></thead>";
                        echo "<tbody>";
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
                                echo "<td>" . $people[$currentMemberId] . "</td>";

                                $attendancePct = number_format(($eventCount/sizeof($eventIds))*100,1);
                                echo "<td>" . $eventCount . '/' . sizeof($eventIds) . ' (' . $attendancePct . '%)</td></tr>';
                                $count++;
                            }
                        }
                        echo "</tbody>";
                    } else {
                        echo "<tbody><tr><td>No members with shared events.</td></tr></tbody>";
                    }
                ?>
            </table>
        </div>
    </div>
</div>
<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>
</body>

</html>

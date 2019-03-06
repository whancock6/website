<?php
require "logged_in_check.php";
require "set_session_vars_full.php";
require "database_connect.php";
$pageTitle = "Sports Dashboard";
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<body>
<?php require "partials/header.php"; ?>
<div class="container">
    <h2 class="float-left">Sports Dashboard</h2>
    <br/>
    <br/>
<?php

    function checkExistence($haystack, $needle) {
        foreach ($haystack as $element) {
            if (stripos($needle, $element) !== FALSE) {
                return $element;
            }
        }
        return null;
    }

    $query = $db->query("SELECT eventID, eventName, dateDay, dateMonth, dateYear FROM reck_club.Event WHERE type = 'sports'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $sportsEvents = [];
    while ($row = $query->fetch()) {
        if (!key_exists($row[eventID], $sportsEvents) && (!empty($row[eventID]) && isset($row[eventID]) && strlen($row[eventID] > 0) && !is_null($row[eventID]))) {
            $sportsEvents[$row[eventID]] = [
                'name' => $row[eventName],
                'dateDay' => $row[dateDay],
                'dateMonth' => $row[dateMonth],
                'dateYear' => $row[dateYear]
            ];
        }
    }

    $eventIdsString = "'".implode("','", array_keys($sportsEvents)) . "'";

    $eventAttendanceQuery = $db->query("SELECT memberID, eventID FROM reck_club.AttendsEvent WHERE eventID IN($eventIdsString) GROUP BY eventID, memberID");
    $eventAttendanceQuery->setFetchMode(PDO::FETCH_ASSOC);
    $eventArray = [];
    while($row = $eventAttendanceQuery->fetch()) {
        if (!key_exists($row[eventID], $eventArray) && (!empty($row[eventID]) && isset($row[eventID]) && strlen($row[eventID]) > 0 && !is_null($row[eventID]))) {
            $eventArray[$row[eventID]] = [];
        }

        $eventArray[$row[eventID]][] = $row[memberId];
    }

    $eventAttendanceCount = [];
    foreach ($eventArray as $eventId => $members) {
        $eventAttendanceCount[$eventId] = sizeof($members);
    }

    $sports = [
        // D1 Sports
        'baseball' => 'Baseball',
        'softball' => 'Softball',
        'mbb' => 'Men\'s Basketball',
        'wbb' => 'Women\'s Basketball',
        'track' => 'Track and Field',
        'men\'s tennis' => 'Men\'s Tennis',
        'women\'s tennis' => 'Women\'s Basketball',
        'volleyball' => 'Volleyball',
        'swim' => 'Swimming and Diving',
        'cross country' => 'Cross Country',
        'football' => 'Football',
        // Lacrosse alternate titles
        'men\'s lax' => 'Men\'s Lacrosse',
        'women\'s lax' => 'Women\'s Lacrosse',
        'men\'s lacrosse' => 'Men\'s Lacrosse',
        'women\'s lacrosse' => 'Women\'s Lacrosse',
        'club hockey' => 'Club Hockey',
        'hockey' => 'Club Hockey',
        'club volleyball' => 'Club Volleyball',
        'club swim' => 'Club Swim'
    ];

    $sportEventArray = [];

    foreach ($sportsEvents as $eventId => $eventData) {
        $eventName = $eventData['name'];
        if (checkExistence(array_keys($sports), $eventName) !== null && stripos($eventName, '@') === false) { // ignoring away games
            $sport = checkExistence(array_keys($sports), $eventName);
            if (!key_exists($sport, $sportEventArray) && (!empty($sport) && isset($sport) && strlen($sport) > 0 && !is_null($sport))) {
                $sportEventArray[$sport] = [];
            }

            $d=strtotime($eventData['dateMonth'] . '/' . $eventData['dateDay'] . '/' . $eventData['dateYear']);
            $sportEventArray[$sport][] = [
                'name' => $eventName,
                'eventId' => $eventId,
                'attendance' => ((isset($eventAttendanceCount[$eventId]) && $eventAttendanceCount[$eventId] !== null)) ? $eventAttendanceCount[$eventId] : 0,
                'date' => date("F d, Y", $d),
                'dayOfWeek' => date("l", $d),
                'month' => date('F', $d)
            ];
        }
    }

    $query = $db->query("SELECT COUNT(*) as CNT FROM reck_club.Member WHERE NOT status = 'alumni' AND (NOT username = 'gpburdell' AND NOT username = 'gerome.stephens')"); // remove Gerome and GPB from the member count
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $row = $query->fetch();
    $totalMembers = $row[CNT];

    foreach ($sportEventArray as $sport => $eventData) {
        echo "<b>" . $sports[$sport] . "</b><br/>";
        $totalAttendance = 0;
        $daysCount = [];
        $monthsCount = [];
        echo "<u>Events</u>: <br/>";
        foreach ($eventData as $event) {
            echo "<i>Event: " . $event['name'] . "</i> (Attendance: " . ((isset($event['attendance']) && $event['attendance'] !== null) ? $event['attendance'] : 0) . " of " . $totalMembers . " members; Date: " . $event['dayOfWeek'] . ", " . $event['date'] . ")<br/>";
            $totalAttendance += $event['attendance'];

            if (!key_exists($event['dayOfWeek'], $daysCount) && (!empty($event['dayOfWeek']) && isset($event['dayOfWeek']) && strlen($event['dayOfWeek']) > 0 && !is_null($event['dayOfWeek']))) {
                $daysCount[$event['dayOfWeek']] = [
                    'events' => 0,
                    'attendance' => 0
                ];
            }
            $daysCount[$event['dayOfWeek']]['events']++;
            $daysCount[$event['dayOfWeek']]['attendance'] += $event['attendance'];

            if (!key_exists($event['month'], $monthsCount) && (!empty($event['month']) && isset($event['month']) && strlen($event['month']) > 0 && !is_null($event['month']))) {
                $monthsCount[$event['month']] = [
                    'events' => 0,
                    'attendance' => 0
                ];
            }
            $monthsCount[$event['month']]['events']++;
            $monthsCount[$event['month']]['attendance'] += $event['attendance'];
        }
        //var_dump($daysCount);
        uasort($daysCount, function($a, $b) {
            return ($b['attendance'] / $b['events'])  - ($a['attendance'] / $a['events']);
        });
        uasort($monthsCount, function($a, $b) {
            return ($b['attendance'] / $b['events'])  - ($a['attendance'] / $a['events']);
        });
        //var_dump($daysCount);

        echo "<u>Total Attendance</u>: " . $totalAttendance . ' members<br/>';
        if ($totalAttendance > 0) {
            $avgAtt = number_format($totalAttendance / sizeof(array_keys($eventData)),1);
            echo "<u>Avg Attendance</u>: " . $avgAtt . ' members/gm' . ' (Member Utilization: ' . number_format(($avgAtt / $totalMembers) * 100,1) . '%)<br/>';
            $bestSHOTWDay = array_keys($daysCount)[0];
            $bestSHOTWDayAtt = number_format($daysCount[$bestSHOTWDay]['attendance'] / $daysCount[$bestSHOTWDay]['events'],1);
            echo "<u>Best Day for SHOTW (based on Avg Attendance)</u>: " . $bestSHOTWDay . " (" . $bestSHOTWDayAtt . " avg members" . ' --> member utilization: ' . number_format(($bestSHOTWDayAtt / $totalMembers) * 100,1) . '%)' . '<br/>';
            $bestMonth = array_keys($monthsCount)[0];
            $bestMonthAtt = number_format($monthsCount[$bestMonth]['attendance'] / $monthsCount[$bestMonth]['events'],1);
            echo "<u>Best Month for Attendance (based on Avg Attendance)</u>: " . $bestMonth . " (" . $bestMonthAtt . " avg members" . ' --> member utilization: ' . number_format(($bestMonthAtt / $totalMembers) * 100,1) . '%)';
        }
        echo '<br/><br/>';
    }
?>
</div>

<?php require 'partials/footer.php'; ?>
<?php require 'partials/scripts.php'; ?>
</body>
</html>

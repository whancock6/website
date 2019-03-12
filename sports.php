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
    <h2>Sports Dashboard</h2>
    <p class="mb-3"><small><em>Please do not use this page on mobile devices. The amount of data displayed prevents this page from being easily readable on smaller screens.</em></small></p>
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
        'women\'s tennis' => 'Women\'s Tennis',
        'men\'s tennis' => 'Men\'s Tennis',
        'club volleyball' => 'Club Volleyball',
        'volleyball' => 'Volleyball',
        'club swim' => 'Club Swim',
        'swim' => 'Swimming and Diving',
        'cross country' => 'Cross Country',
        'football' => 'Football',
        // Lacrosse alternate titles
        'women\'s lax' => 'Women\'s Lacrosse',
        'men\'s lax' => 'Men\'s Lacrosse',
        'women\'s lacrosse' => 'Women\'s Lacrosse',
        'men\'s lacrosse' => 'Men\'s Lacrosse',
        'club hockey' => 'Club Hockey',
        'hockey' => 'Club Hockey'
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

    uasort($sportEventArray, function($a, $b) {
        $aAttendance = 0;
        $bAttendance = 0;
        foreach ($a as $event) {
            $aAttendance += $event['attendance'];
        }

        foreach ($b as $event) {
            $bAttendance += $event['attendance'];
        }

        return ($bAttendance / sizeof($b))  - ($aAttendance / sizeof($a));
    });

    $overallAttendance = 0;
    $numEvents = 0;
    $overallDaysCount = [];
    $overallMonthCount = [];
    foreach ($sportEventArray as $sport => $eventData) {
        foreach ($eventData as $event) {
            $overallAttendance += $event['attendance'];
            $numEvents++;

            if (!key_exists($event['dayOfWeek'], $overallDaysCount) && (!empty($event['dayOfWeek']) && isset($event['dayOfWeek']) && strlen($event['dayOfWeek']) > 0 && !is_null($event['dayOfWeek']))) {
                $overallDaysCount[$event['dayOfWeek']] = [
                    'events' => 0,
                    'attendance' => 0
                ];
            }
            $overallDaysCount[$event['dayOfWeek']]['events']++;
            $overallDaysCount[$event['dayOfWeek']]['attendance'] += $event['attendance'];

            if (!key_exists($event['month'], $overallMonthCount) && (!empty($event['month']) && isset($event['month']) && strlen($event['month']) > 0 && !is_null($event['month']))) {
                $overallMonthCount[$event['month']] = [
                    'events' => 0,
                    'attendance' => 0
                ];
            }
            $overallMonthCount[$event['month']]['events']++;
            $overallMonthCount[$event['month']]['attendance'] += $event['attendance'];
        }
    }
    uasort($overallDaysCount, function($a, $b) {
        return ($b['attendance'] / $b['events'])  - ($a['attendance'] / $a['events']);
    });
    uasort($overallMonthCount, function($a, $b) {
        return ($b['attendance'] / $b['events'])  - ($a['attendance'] / $a['events']);
    });

    echo "<p class='m-1'><strong>Overall Sports Attendance</strong>: " . $overallAttendance . " members</p>";
    echo "<p class='m-1'><strong>Total Sports Events</strong>: " . $numEvents . " events</p>";
    $avgOvrAtt = number_format(($overallAttendance / $numEvents), 1);
    $avgOvrAttPct = number_format(($avgOvrAtt / $totalMembers) * 100, 1);
    echo "<p class='m-1'><strong>Avg Sports Attendance</strong>: " . $avgOvrAtt . " members/gm (" .$avgOvrAttPct . "% of club)</p>";

    $bestOverallSHOTWDay = array_keys($overallDaysCount)[0];
    $bestOverallSHOTWDayAtt = number_format($overallDaysCount[$bestOverallSHOTWDay]['attendance'] / $overallDaysCount[$bestOverallSHOTWDay]['events'],1);
    echo "<p class='m-1'><strong>Preferred Day for SHOTW (based on Avg Attendance)</strong>: " . $bestOverallSHOTWDay . " (" . $bestOverallSHOTWDayAtt . " members/gm" . '; ' . number_format(($bestOverallSHOTWDayAtt / $totalMembers) * 100,1) . '% of club)' . '</p>';

    $bestOverallMonth = array_keys($overallMonthCount)[0];
    $bestOverallMonthAtt = number_format($overallMonthCount[$bestOverallMonth]['attendance'] / $overallMonthCount[$bestOverallMonth]['events'],1);
    echo "<p class='m-1 mb-3'><strong>Preferred Month for Attendance (based on Avg Attendance)</strong>: " . $bestOverallMonth . " (" . $bestOverallMonthAtt . " members/gm" . '; ' . number_format(($bestOverallMonthAtt / $totalMembers) * 100,1) . '% of club)</p>';
//    echo '<br/><br/>';

    $rank = 1;
    foreach ($sportEventArray as $sport => $eventData) {
        //echo "<b>" . $sports[$sport] . "</b><br/>";
        echo "<div class=\"col-12 mb-3\">
    <div class=\"card\">
        <div class=\"card-body\">
            <h5 class=\"card-title\"><strong>#" . $rank . "</strong> " . $sports[$sport] . "</h5>";
        $totalAttendance = 0;
        $totalEvents = 0;
        $daysCount = [];
        $monthsCount = [];
        foreach ($eventData as $event) {
            $totalAttendance += $event['attendance'];
            $totalEvents++;

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
        uasort($daysCount, function($a, $b) {
            return ($b['attendance'] / $b['events'])  - ($a['attendance'] / $a['events']);
        });
        uasort($monthsCount, function($a, $b) {
            return ($b['attendance'] / $b['events'])  - ($a['attendance'] / $a['events']);
        });
        echo "<p class=\"d-flex card-text justify-content-between m-1\"><strong>Total Attendance</strong> " . $totalAttendance . " (" . number_format(($totalAttendance / $overallAttendance) * 100, 1) . "% of total)</p>";
        echo "<p class=\"d-flex card-text justify-content-between m-1\"><strong>Total Events</strong> " . $totalEvents . " (" . number_format(($totalEvents / $numEvents) * 100, 1) . "% of total)</p>";
        if ($totalAttendance > 0) {
            $avgAtt = number_format($totalAttendance / sizeof(array_keys($eventData)),1);
            echo "<p class=\"d-flex card-text justify-content-between m-1\"><strong>Avg Attendance</strong> " . $avgAtt . " members/gm (" . number_format(($avgAtt / $totalMembers) * 100, 1) . "% of club)</p>";
            $bestSHOTWDay = array_keys($daysCount)[0];
            $bestSHOTWDayAtt = number_format($daysCount[$bestSHOTWDay]['attendance'] / $daysCount[$bestSHOTWDay]['events'],1);
            echo "<p class=\"d-flex card-text justify-content-between m-1\"><strong>Preferred Day</strong> " . $bestSHOTWDay . " (" . $bestSHOTWDayAtt . " members/gm)</p>";
            $bestMonth = array_keys($monthsCount)[0];
            $bestMonthAtt = number_format($monthsCount[$bestMonth]['attendance'] / $monthsCount[$bestMonth]['events'],1);
            echo "<p class=\"d-flex card-text justify-content-between m-1\"><strong>Preferred Month</strong> " . $bestMonth . " (" . $bestMonthAtt . " members/gm)</p>";
            echo "<a class=\"btn btn-link p-0\" role=\"button\" href=\"#collapseTarget-". $sport . "\" data-toggle=\"collapse\" data-target=\"#collapseTarget-". $sport . "\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Show Events List</a>";
        }
        echo '</div>';
        echo '        
        <div class="collapse" id="collapseTarget-' . $sport . '">
            <ul class="list-group list-group-flush">';
        foreach ($eventData as $event) {
            echo "<li href=\"#\" class=\"list-group-item\">";
            echo "<div class=\"d-flex row\">";
            echo "<h6 class=\"col-4 mb-1\"><strong>" . $event['name'] . "</strong></h6>";
            echo "<p class=\"col-4 text-center mb-1\">Attendance: " . ((isset($event['attendance']) && $event['attendance'] !== null) ? $event['attendance'] : 0) . "/" . $totalMembers . " (" . number_format(($event['attendance'] / $totalMembers) * 100, 1) ."%)</p>";
            echo "<p class=\"col-4 mb-1\"><small class='float-right'>" . $event['dayOfWeek'] . ", " . $event['date'] . "</small></p>";
            echo "</div>";
            echo "</li>";
            //echo "<i>Event: " . $event['name'] . "</i> (Attendance: " . ((isset($event['attendance']) && $event['attendance'] !== null) ? $event['attendance'] : 0) . " of " . $totalMembers . " members; Date: " . $event['dayOfWeek'] . ", " . $event['date'] . ")<br/>";
        }
         echo'   </ul>
        </div>';
        echo '</div></div>';
        $rank++;
    }
?>

<!--<div class="col-12 mb-3">-->
<!--    <div class="card">-->
<!--        <div class="card-body">-->
<!--            <h5 class="card-title">Sport</h5>-->
<!--            <p class="d-flex card-text justify-content-between"><strong>Total Attendance:</strong> <em>2 members (1.7% of total attendance)</em></p>-->
<!--            <p class="d-flex card-text justify-content-between"><strong>Avg Attendance:</strong> <em>1.0 members/gm (2.0% of membership)</em></p>-->
<!--            <p class="d-flex card-text justify-content-between"><strong>Best Day for SHOTW:</strong> <em>Sunday (1.0 members/gm -> 2.0% of membership)</em></p>-->
<!--            <p class="d-flex card-text justify-content-between"><strong>Best Month for Attendance:</strong> <em>November (1.0 members/gm -> 2.0% of membership)</em></p>-->
<!---->
<!--            <button class="btn btn-link p-0" type="button" data-toggle="collapse" data-target="#collapseTarget" aria-expanded="false" aria-controls="collapseExample">Show Events List</button>-->
<!--        </div>-->
<!--        <div class="collapse" id="collapseTarget">-->
<!--            <ul class="list-group list-group-flush">-->
<!--                <li href="#" class="list-group-item">-->
<!--                    <div class="d-flex justify-content-between">-->
<!--                        <h6 class="mb-1"><strong>Event Name</strong></h6>-->
<!--                        <p class="mb-1">Attendance: 10/69 (10%)</p>-->
<!--                        <p class="mb-1"><small>03/06/2019</small></p>-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="list-group-item">Dapibus ac facilisis in</li>-->
<!--                <li class="list-group-item">Vestibulum at eros</li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

</div>

<?php require 'partials/footer.php'; ?>
<?php require 'partials/scripts.php'; ?>
</body>
</html>

<?php
	require "logged_in_check.php";
	require "database_connect.php";
	require "set_session_vars_full.php";
	$pageTitle = "Stats";
    require "partials/head.php";
?>
<html>
<body>
<?php require "partials/header.php" ?>
<div class="container">
    <h2>Events Stats</h2>
    <div class="row mb-3">

    </div>
    <div class="row mb-3">
        <div class="col-8 offset-2">
            <img class="img img-responsive img-fluid mb-3" src="/images/remember.png" />
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <h4>Total Points Visualization</h4>
            <div id="chart1_div"></div>
            <p class="text-center"><strong>The points whores really screw with the average.</strong></p>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <h4>Event Breakdown</h4>
            <?php
            $query2 = $db->prepare("SELECT type FROM Event");
            $query2->setFetchMode(PDO::FETCH_ASSOC);

            $mandatory=0;
            $sports=0;
            $social=0;
            $work=0;
            $events=0;

            while($row = $query2->fetch()) {
                $events++;
                echo($events);
                if($row[type]=='mandatory'){
                    $mandatory++;
                }
                else if($row[type]=='sports'){
                    $sports++;
                }
                else if($row[type]=='social'){
                    $social++;
                }
                else if($row[type]=='work'){
                    $work++;
                }
            }
            ?>

            <div id="chart2_div"></div>
        </div>
</div>
<?php require 'partials/footer.php'; ?>
<?php require 'partials/scripts.php'; ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    var chart1DataSet = [
        ['Name','Total Points','Average'],
        <?php

        // CREATE TABLE OF INDIVIDUAL RANKINGS
        //---------------------------------------------------

        $query = $db->query("SELECT AVG(memberPoints) as AVRG FROM Member WHERE status IN ('probate', 'member')");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $row = $query->fetch();
        $pointAVG = number_format($row[AVRG],2);

        $query = $db->query("SELECT firstName, lastName, memberPoints, memberID FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName");
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $count = 1;

        while($row = $query->fetch())
        {
            echo "['".addslashes($row[firstName])."', ".$row[memberPoints].",".$pointAVG."],";
            $count++;
        }
        ?>
    ];

    var chart2DataSet = [
        ['Name','Mandatory','Social','Sports','Work'],
        <?php

        // CREATE TABLE OF INDIVIDUAL RANKINGS
        //---------------------------------------------------



        $query = $db->query("SELECT firstName, mandatoryEventCount, sportsEventCount, socialEventCount, workEventCount FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName");
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $count = 1;

        while($row = $query->fetch())
        {
            echo "['".addslashes($row[firstName]),"',";
            echo "".$row[mandatoryEventCount].", ".$row[socialEventCount].", ".$row[sportsEventCount].", ".$row[workEventCount]."],";
            $count++;
        }
        ?>


    ];

    function drawCharts(){
        drawChart1();
        drawChart2();
    }
    function drawChart1() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable(chart1DataSet);

        // Create and draw the visualization.
        new google.visualization.ComboChart(document.getElementById('chart1_div')).
        draw(data,
            {
                // title:"Total Points Visualization",
                //width:1000, height:400,
                legend: {position: 'none'},
                seriesType: "bars",
                series: {1: {type: "line"}},
                colors: ['#b3a369','#003057'],
                chartArea:{left:50,top:30,right:50,width:"100%",height:"75%"},
                hAxis: {title: "Member"}}

        );
    }
    function drawChart2() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable(chart2DataSet);

        // Create and draw the visualization.
        new google.visualization.ColumnChart(document.getElementById('chart2_div')).
        draw(data,
            {title:"Total Events Visualization",
                //width:1000, height:400,
                isStacked:true,
                legend: {position: 'none'},
                chartArea:{left:50,top:30,right:50,width:"100%",height:"75%"},
                colors:['#D0D0D0','#005ACE','#FFCB00','#149F3D'],
                hAxis: {title: "Member"}}

        );
    }
    $(window).resize(function(){
        drawCharts();
    });
</script>
</body>
</html>
<?php $pageTitle = "Mini 500"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<!--<link href="https://fonts.googleapis.com/css?family=Saira+Semi+Condensed:400,600&display=swap" rel="stylesheet">-->

<body>
<?php require "../partials/public-header.php" ?>

<div class="container mb-3">
    <div class="row">
        <div class="col-12">
            <img class="img-fluid img-responsive" src="/homecoming/images/Mini500Banner.png">
        </div>
    </div>
</div>
<div class="container mb-3">
    <div class="row">
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:Isabel.Wickliffe@gatech.edu"><b>Isabel Wickliffe</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Reck Club Homecoming Chair</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:brandon.dobson@gatech.edu"><b>Brandon Dobson</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Mini 500 Sub-Chair</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:rhurst8@gatech.edu"><b>Rachel Hurst</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Mini 500 Sub-Chair</i></p>
        </div>
    </div>
    <hr class="mb-3">
</div>

<div class="container">
    <div class='row text-center'>
        <div class='col-sm-4 col-xs-12'>
            <a class='btn btn-md btn-secondary' href="#race-day-info">Race Day Info</a>
        </div>
        <div class='col-sm-4 col-xs-12'>
            <a class='btn btn-md btn-primary' href="/assets/2019-Mini-500-Rule-Book.pdf" target="_blank">2019 Mini 500 Rule Book</a>
        </div>
        <div class='col-sm-4 col-xs-12'>
            <a class='btn btn-md btn-secondary' href="/assets/A-Guide-to-Mini-500.pdf" target="_blank">Guide to Mini 500</a>
        </div>
    </div>
    <hr class="mb-3">
<?php

    $info1 = array(
                [
                    "image" => '/homecoming/images/M55.jpg',
                    "title" => 'The Tradition',
                    "main" => 'The Mini 500 is an annual tricycle race around Peters Parking Deck that occurs on the
                               Friday afternoon before the homecoming football game. It is one of Georgia Tech’s 
                               most unique traditions put on by Ramblin’ Reck Club since 1969. Teams are comprised 
                               of seven members: 4 to take turns as the driver and three on the pit crew. 
                               Each team is required to rotate the front tire of their tricycle three times 
                               throughout the course of the race. All teams try to complete 8 laps without 
                               destroying their tricycle.'
                ],
                [
                    "image" => '/homecoming/images/M51.jpg',
                    "title" => 'Sign Ups',
                    "main" => 'Sign ups for Mini 500 are within the general homecoming sign ups and will be 
                              September 24th through September 27th at tickets.studentcenter.gatech.edu. 
                              Mini 500 costs $100 dollars to participate in and include the tricycle and 
                              t-shirts for members of your Mini 500 team.'

                ],
                [
                    "image" => '/homecoming/images/M52.jpg',
                    "title" => 'Tricycle Pickup',
                    "main" => 'Each team must pick up their tricycle from the Spring room on the second floor of the 
                               student center during the designated pick up days and times, October 10th and October 11th, 
                               or they will not be allowed to race. Each team participating will receive a reminder 
                               email about these days'

                ],
                [
                    "image" => '/homecoming/images/M53.jpg',
                    "title" => 'Tricycle Modifications',
                    "main" => "Each team must paint their tricycle in order to participate. <b>RED TRICYCLES WILL NOT RACE.</b> 
                                 This is the only modification that a team must make, but it is highly encouraged that a 
                                 team uses their knowledge and skills as GT students to modify their Tricycle further 
                                 because if no further modifications are made the tricycle is almost guaranteed to not 
                                 make it through the race.
                        Common modifications are:
                        <li>Changing out the front tire to be a larger and more reinforced tire</li>
                        <li>Adding padding to the seat and handlebars for your arms to rest on</li>
                        <li>Adding a foot stopper to the back of the tricycle</li>"
                ],
                );
    
    foreach ($info1 as $item) {
        echo "<div class='row mb-3'>";
        echo "<div class='col-sm-5 col-xs-12'><img class= \"img-fluid\" src=\"" . $item["image"] . "\"/></div>";
        echo "<div class='col-sm-7 col-xs-12'>";
        echo "<h2><strong>". $item["title"] . "</strong></h2><p> " . $item["main"] . "<p></div>";
        echo "</div>";
    }
?>
</div>
<div class="container">

<?php
    $info2 = array(
    [
        "image" => '/homecoming/images/M54.jpg',
        "title" => 'Check-In',
        "main" => 'The Race will be around Peters Parking Deck with the Pits for each team lining the 
                            Peters Parking Deck side of Fowler Street and the start being at the corner of Fowler St. 
                            and Bobby Dodd Way. Each team will receive an email with their assigned pit number. 
                            The team will report to THEIR PIT between 5:00pm and 5:25PM and check in with their 
                            pit boss (A member of Ramblin Reck Club). Everything a team will need for the race other 
                            than their tricycle and wheel rotation mechanisms will be at their starting pit.'

    ],
    [
        "image" => '/homecoming/images/M58.jpg',
        "title" => 'Racers',
        "main" => 'Each team will have four members who are deemed racers. They will take turns completing 
                                a lap each until each racer has completed two laps for a total of eight laps done by 
                                the team. There are many different techniques used by racers to propel the tricycle 
                                so just choose what works best for you!'
    ],
    [
        "image" => '/homecoming/images/M57.jpg',
        "title" => 'Apparel',
        "main" => 'It is difficult to propel a tricycle as a full grown human and may result in a few scraps 
                                 and bruises so we recommend wearing some form of bottom that covers your legs 
                                 (jeans, sweatpants, leggings) as well are wearing reinforcement on your shoes 
                                 (such as duct tape) or shoes you don’t care about because they will be hitting the 
                                pavement and may get scuffed up!'
    ],
    [
        "image" => '/homecoming/images/M56.jpg',
        "title" => 'Pit Crew',
        "main" => 'The team will also have 3 pit members who will remain in the pit and facilitate changes
                                in drivers as well as the three front wheel rotations that must be performed 
                                after every 2 laps.'

    ],
    [
        "image" => '/homecoming/images/M59.jpg',
        "title" => 'The Wheel Rotation',
        "main" => 'After every two laps the team is required to perform a rotation of their front tire.
                                This will be monitored by the pit boss assigned to the teams pit and completed after 
                                lap 2, 4, and 6. A wheel reversal consists of removing the front tire, rotating it, and 
                                then reattaching the front tire.'
    ]
);

        echo "<br><div class= 'blog-header'>";
        echo "<div class='col-12' style=\"text-align: center;\">";
        echo "<h1 id='race-day-info'><strong>Race Day Info</strong></h1></div></div><br>";


        foreach ($info2 as $item) {
            echo "<div class='row mb-3'>";
            echo "<div class='col-sm-5 col-xs-12'><img class= \"img-fluid\" src=\"" . $item["image"] . "\"/></div>";
            echo "<div class='col-sm-7 col-xs-12'>";
            echo "<h2><strong>". $item["title"] .
                "</strong></h2><p> " . $item["main"] . "<p><br></div>";
            echo "</div>";
        }

?>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-muted"><i>Have any questions? Reach out to Isabel Wickliffe, Reck Club Homecoming Chair, at <a href="mailto:isabel.wickliffe@gatech.edu">isabel.wickliffe@gatech.edu</a>.</i></p>
        </div>
    </div>
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>
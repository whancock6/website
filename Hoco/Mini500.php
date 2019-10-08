<?php $pageTitle = "Mini500"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<link href="https://fonts.googleapis.com/css?family=Saira+Semi+Condensed:400,600&display=swap" rel="stylesheet">
<?php require "../partials/public-header.php" ?>

<body style="font-family: 'Saira Semi Condensed', sans-serif;">

<br>


<div class="container">
    <div class="row">
        <div class="col-12">
            <img class="img-fluid" src="/Hoco/images/Mini500Banner.png">
        </div>
    </div>
</div>

<br><br>

<?php

$info1 = array(
                [
                    "image" => '<img class= "img-fluid" src="/Hoco/images/M55.jpg">',
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
                    "image" => '<img class= "img-fluid" src="/Hoco/images/M51.jpg">',
                    "title" => 'Sign Ups',
                    "main" => 'Sign ups for Mini 500 are within the general homecoming sign ups and will be 
                              September 24th through September 27th at tickets.studentcenter.gatech.edu. 
                              Mini 500 costs $100 dollars to participate in and include the tricycle and 
                              t-shirts for members of your Mini 500 team.'

                ],
                [
                    "image" => '<img class= "img-fluid" src="/Hoco/images/M52.jpg">',
                    "title" => 'Tricycle Pickup',
                    "main" => 'Each team must pick up their tricycle from the Spring room on the second floor of the 
                               student center during the designated pick up days and times, October 10th and October 11th, 
                               or they will not be allowed to race. Each team participating will receive a reminder 
                               email about these days'

                ],
                [
                    "image" => '<img class= "img-fluid" src="/Hoco/images/M53.jpg">',
                    "title" => 'Tricycle Modifications',
                    "main" => 'Each team must paint their tricycle in order to participate. RED TRICYCLES WILL NOT RACE. 
                                 This is the only modification that a team must make, but it is highly encouraged that a 
                                 team uses their knowledge and skills as GT students to modify their Tricycle further 
                                 because if no further modifications are made the tricycle is almost guaranteed to not 
                                 make it through the race.
                        Common modifications are:
                        <li>Changing out the front tire to be a larger and more reinforced tire</li>
                        <li>Adding padding to the seat and handlebars for your arms to rest on</li>
                        <li>Adding a foot stopper to the back of the tricycle</li>'
                ],
                );

$info2 = array(
    [
        "image" => '<img class= "img-fluid" src="/Hoco/images/M54.jpg">',
        "title" => 'Check-In',
        "main" => 'The Race will be around Peters Parking Deck with the Pits for each team lining the 
                            Peters Parking Deck side of Fowler Street and the start being at the corner of Fowler St. 
                            and Bobby Dodd Way. Each team will receive an email with their assigned pit number. 
                            The team will report to THEIR PIT between 5:00pm and 5:25PM and check in with their 
                            pit boss (A member of Ramblin Reck Club). Everything a team will need for the race other 
                            than their tricycle and wheel rotation mechanisms will be at their starting pit.'

    ],
    [
        "image" => '<img class= "img-fluid" src="/Hoco/images/M58.jpg">',
        "title" => 'Racers',
        "main" => 'Each team will have four members who are deemed racers. They will take turns completing 
                                a lap each until each racer has completed two laps for a total of eight laps done by 
                                the team. There are many different techniques used by racers to propel the tricycle 
                                so just choose what works best for you!'
    ],
    [
        "image" => '<img class= "img-fluid" src="/Hoco/images/M57.jpg">',
        "title" => 'Apparel',
        "main" => 'It is difficult to propel a tricycle as a full grown human and may result in a few scraps 
                                 and bruises so we recommend wearing some form of bottom that covers your legs 
                                 (jeans, sweatpants, leggings) as well are wearing reinforcement on your shoes 
                                 (such as duct tape) or shoes you don’t care about because they will be hitting the 
                                pavement and may get scuffed up!'
    ],
    [
        "image" => '<img class= "img-fluid" src="/Hoco/images/M56.jpg">',
        "title" => 'Pit Crew',
        "main" => 'The team will also have 3 pit members who will remain in the pit and facilitate changes
                                in drivers as well as the three front wheel rotations that must be performed 
                                after every 2 laps.'

    ],
    [
        "image" => '<img class= "img-fluid" src="/Hoco/images/M59.jpg">',
        "title" => 'The Wheel Rotation',
        "main" => 'After every two laps the team is required to perform a rotation of their front tire.
                                This will be monitored by the pit boss assigned to the teams pit and completed after 
                                lap 2, 4, and 6. A wheel reversal consists of removing the front tire, rotating it, and 
                                then reattaching the front tire.'
    ]
);

        echo "<div class='container'>";

        echo "
            <div class='row align-times-center'> 
                
                <div class='col-6' style=\"text-align:center\">           
                    <a style=\"text-align:center\" href=\"/assets/2019-Mini-500-Rule-Book.pdf\" target=\"_blank\"><u><strong>Click here for the 2019 Mini 500 Rule Book</strong></u></a>
                </div>
                <div class='col-6' style=\"text-align:center\">           
                    <a style=\"text-align:center\" href=\"/assets/A-Guide-to-Mini-500.pdf\" target=\"_blank\"><strong><u>Click here for the Guide to Mini 500</u></strong></a>
                </div>
            </div>
            <br>
        
        ";

        foreach ($info1 as $item) {
            echo "<div class= 'row align-items-center'>";
            echo "<div class='col-5'>" . $item["image"] . "</div>";
            echo "<div class='col-7'>";
            echo "<h2 style=\"font-family: 'Saira Semi Condensed', sans-serif;\"><strong>". $item["title"] .
                "</strong></h2><p style=\"font-family: 'Saira Semi Condensed', sans-serif;\"> " . $item["main"] . "<p><br></div>";
            echo "</div>";
            echo "<div class='row'><br></div>";
        }

        //insert the race day info thing here

        echo "<br><div class= 'blog-header'>";
        echo "<div class='col-12' style=\"text-align: center;\">";
        echo "<h1 style=\"font-family: 'Saira Semi Condensed', sans-serif;\"><strong>Race Day Info</strong></h1></div></div><br>";


        foreach ($info2 as $item) {
            echo "<div class= 'row align-items-center'>";
            echo "<div class='col-5'>" . $item["image"] . "</div>";
            echo "<div class='col-7'>";
            echo "<h2 style=\"font-family: 'Saira Semi Condensed', sans-serif;\"><strong>". $item["title"] .
                "</strong></h2><p style=\"font-family: 'Saira Semi Condensed', sans-serif;\"> " . $item["main"] . "<p><br></div>";
            echo "</div>";
            echo "<div class='row'><br></div>";
        }

?>
    <div class="row">
        <div class="col-4">
            <p style="text-align:center">
                <strong>Isabel Wickliffe</strong><br>
                HOCO Reck Club Chair<br>
                <a href="mailto:Isabel.Wickliffe@gatech.edu">Isabel.Wickliffe@gatech.edu</a>
            </p>
        </div>
        <div class="col-4">
            <p style="text-align:center">
                <strong>Brandon Dobson</strong><br>
                Mini-500 Sub-Chair<br>
                <a href="mailto:brandon.dobson@gatech.edu">Brandon.Dobson@gatech.edu</a>
            </p>
        </div>
        <div class="col-4">
            <p style="text-align:center">
                <strong>Rachel Hurst</strong><br>
                Mini-500 Sub-Chair<br>
                <a href="mailto:Rhurst8@gatech.edu">Rhurst8@gatech.edu</a>
            </p>
        </div>
    </div>
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>
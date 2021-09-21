<?php $pageTitle = "Wreck Parade"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>

<div class="container mb-3">
    <div class= 'blog-header'>
        <div class='col-12' style="text-align: center;">
            <h1>Ramblin Wreck Parade</h1>
        </div>
    </div>
</div>

<div class="container mb-3">
    <div class="row">
        <div class="col-12">
            <img class="img-fluid img-responsive" src="/homecoming/images/WreckParadeBanner2020.png">
        </div>
    </div>
</div>
<div class="container mb-3">
    <div class="row">
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:rrchomecoming@gmail.com"><b>Ani Benge & Jack Crawford</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Reck Club Homecoming Co-Chairs</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:wreckparade@gmail.com"><b>Ross LeRoy</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Wreck Parade Sub-Chair</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:wreckparade@gmail.com"><b>Will Hancock</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Wreck Parade Sub-Chair</i></p>
        </div>
    </div>
    <hr class="mb-3">
</div>
<div class="container">
    <div class= 'blog-header'>
        <div class='col-12' style="text-align: center;">
            <h1>9:00 AM October 30th</h1>
        </div>

        <!--    </div>-->

        <div class='row text-center'>
            <div class='col-sm-4 col-xs-12 mb-0 mb-sm-3'>
                <a class='btn btn-md btn-primary' href="#race-day-logistics">Event Information</a>
            </div>
            <!--        sign up button-->
            <div class='col-sm-4 col-xs-12 mb-3 mb-sm-6' style="text-align: center;">
                <a class='btn btn-md btn-secondary' href="https://forms.gle/HhY5QLjPHhzyQGyq7">Event Waiver</a>
            </div>
            <div class='col-sm-4 col-xs-12 mb-sm-3'>
                <?php //If you change the name of the rules section further down, change the href here too. ?>
                <a class='btn btn-md btn-primary' href="#race-rules">Event Rules</a>
            </div>
            <div class='row text-center'>
                <!--        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-6' style="text-align: center;">-->
                <i>The Ramblin Reck Club’s sign-up form is for individual registrations. Organizations wishing to receive
                    points must also sign up for this event using SCPC’s Homecoming waiver,
                    found at <a href="https://gatech.universitytickets.com/w/event.aspx?id=1837&p=1">this link</a></i>
            </div>
        </div>
<div class="container">
    <hr class="mb-3">
    <div class="row justify-content-center">
        <div margin="col-4">
            <iframe margin="0 auto" width="560" height="315" src="https://www.youtube.com/embed/JrRwcHtUDyc" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
    <hr class="mb-3">
</div>

<div class="container">

    <?php

    $info1 = array(
        [
            "image" => '/homecoming/images/wp-001.jpg',
            "title" => 'The Tradition',
            "main" => '<p>The Ramblin’ Wreck Parade was created in 1929 as the Old Ford Race, which occurred for 
                                    two years as a race from Atlanta to Athens.  However, in 1932, the administration 
                                    deemed the event to be unsafe, and thus led to the adjustment to the Ramblin\' 
                                    Wreck Parade in order to preserve the tradition. </p><p>The Wreck Parade is 
                                    held the Saturday morning of Homecoming and is the last event before the 
                                    homecoming football game. The original Wreck Parade consisted of two vehicle 
                                    categories: Fixed Bodies and Classic Cars. Since 1932, the Wreck Parade has 
                                    been an annual tradition, with the exception of 1942 and 1943, due to the gas 
                                    shortages during World War II. In 1944, the parade was reintroduced with a third 
                                    category - contraptions - which are built and powered by students.</p>'
        ],
        [
            "image" => '/homecoming/images/wp-002.jpg',
            "title" => 'Sign Ups',
            "main" => '<p>Participants must sign BOTH
                        our waiver <a href="https://forms.gle/HhY5QLjPHhzyQGyq7">found here</a> and through SCPC
                        which can be found at <a href="https://gatech.universitytickets.com/w/event.aspx?id=1837&p=1">this link.</a> </p>'

        ],
        [
            "image" => '/homecoming/images/wp-003.jpg',
            "title" => 'Logistics',
            "main" => '<p>The Wreck parade will begin at the McCamish Parking Lot and proceed up Fowler street finishing
                        across Ferst Drive. The parade will commence at 9:00AM on October 30th. A full list of the rules
                        can be <a href="https://docs.google.com/document/d/1Vdwo-ry5RfMOV2bIns11-hk6edXz6lolbpRMjc6g06s/edit?usp=sharing">found here.</a></p>'
        ],
        [
            "image" => '/homecoming/images/wp-001.jpg',
            "title" => 'Categories',
            "main" => '<p>Wreck Parade features three categories for entries: classic car, fixed body and contraption. 
                                    Classic Car: A restored car which is over 25 years old.  This category is 
                                    specifically inspired by our very own 1930 Model A Ford!
                                    </p><p>Fixed Body: A vehicle which features a display designed and built by 
                                    students and reflects the Homecoming theme. These vehicles are driven by 
                                    machine power, and are most similar to parade floats. It may be towed by or 
                                    attached to a car or other vehicle, or may be a car or other vehicle itself that 
                                    is 70 percent covered in decorations. Allowed decorations include banners, 
                                    pomp, streamers, etc as long as decorations adhere to the Entry Regulations above. 
                                    </p><p> Contraption: Similar to fixed body entries, these vehicles are designed 
                                    and built by students and follow the Homecoming theme!  However, these entries are 
                                    complete human-powered, so creativity and engineering skills can easily be showcased!</p>'
        ]
    );

    foreach ($info1 as $item) {
        echo "<div class='row mb-3'>";
        echo "<div class='col-md-5 col-sm-12'><img class= \"img-fluid mb-3 mb-md-0\" src=\"" . $item["image"] . "\"/></div>";
        echo "<div class='col-md-7 col-sm-12'>";
        echo "<h4>". $item["title"] . "</h4> " . $item['main'] . "</div>";
        echo "</div>";
    }
    ?>
</div>


<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-muted"><i>Have any questions? Reach out to us at <a href="mailto:wreckparade@gmail.com">wreckparade@gmail.com</a> or <a href="mailto:rrchomecoming@gmail.com">rrchomecoming@gmail.com</a>.</i></p>
        </div>
    </div>
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>

<?php $pageTitle = "Wreck Parade"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>

<div class="container mb-3">
    <div class= 'blog-header'>
        <div class='col-12' style="text-align: center;">
            <h1>Ramblin Wreck Parade 2020</h1>
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
            <p class="mb-0" style="text-align:center"><i>Reck Club Homecoming Chair</i></p>
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
            "image" => '/homecoming/images/wp-004.jpg',
            "title" => 'COVID Update',
            "main" => '<p> In light of the COVID-19 situation, this year\'s Wreck Parade has undergone some new changes
                                    to keep participants and spectators safe and healthy. However, the spirit and 
                                    fun of one of Georgia Tech’s most beloved traditions will be upheld. 
                                    To keep the Ramblin\' Wreck Parade as safe as possible, this year the parade 
                                    will be a car parade, consisting of classic cars and decorated vehicles 
                                    (fixed bodies) that will travel a route around the entire campus.
                                    </p><p>This year we are encouraging spectators to watch from dorms/lawns along 
                                    the new route. For those who are not physically on campus, the parade will be 
                                    showcased the morning of Homecoming through a video produced at a later date.
                                    </p><p>We are excited to be able to adapt Wreck Parade to keep everyone involved 
                                    safe. For more information on Wreck Parade changes please refer to the 
                                    <a href="https://docs.google.com/document/d/1Vdwo-ry5RfMOV2bIns11-hk6edXz6lolbpRMjc6g06s/edit?usp=sharing">
                                    Wreck Parade 2021 Homecoming Rulebook.</a></p>'
        ],
        [
            "image" => '/homecoming/images/wp-002.jpg',
            "title" => 'Sign Ups',
            "main" => '<p>Sign ups are now in early September. If you are interested in participating in Wreck 
                                Parade this year please fill out this form:  <a href="https://forms.gle/7ZvBrVHfk6NFBn6P6">Wreck Parade Form</a> </p>'

        ],
        [
            "image" => '/homecoming/images/wp-003.jpg',
            "title" => 'Logistics',
            "main" => '<ul><li>Location: Begins at the McCamish Parking Lot and Fowler. Then make a lap around 
                                    campus and end at the McCamish Parking Lot and Fowler. </li><li>Date for 
                                    Participants: TBA</li><li>Date of Video: TBA</li></ul>'
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

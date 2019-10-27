<?php $pageTitle = "Wreck Parade"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>

<div class="container mb-3">
    <div class="row">
        <div class="col-12">
            <img class="img-fluid img-responsive" src="/homecoming/images/WreckParadeBanner.png">
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
            <p class="mb-0" style="text-align:center"><a href="mailto:bbbrennan3@gmail.com"><b>Brooke Brennan</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Wreck Parade Sub-Chair</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:jobrien49@gatech.edu"><b>Jen O’Brien</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Wreck Parade Sub-Chair</i></p>
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
            "main" => '<p>The Ramblin’ Wreck Parade was created in 1929 as the Old Ford Race, which occurred for two years as a race from Atlanta to Athens.  However, in 1932, the administration deemed the event to be unsafe, and thus led to the adjustment to the Ramblin\' Wreck Parade in order to preserve the tradition. </p><p>The Wreck Parade is held the Saturday morning of Homecoming and is the last event before the homecoming football game. The original Wreck Parade consisted of two vehicle categories: Fixed Bodies and Classic Cars. Since 1932, the Wreck Parade has been an annual tradition, with the exception of 1942 and 1943, due to the gas shortages during World War II. In 1944, the parade was reintroduced with a third category - contraptions - which are built and powered by students.</p><p> This year, the Wreck Parade is introducing a new aspect: performance groups.  Featuring groups ranging from Georgia Tech spirit to ethnic dance teams, the new Wreck Parade brings a revitalized atmosphere to Homecoming morning!  Be sure to be on Fowler St. on November 2nd to see these new additions!</p>'
        ],
        [
            "image" => '/homecoming/images/wp-002.jpg',
            "title" => 'Sign Ups',
            "main" => '<p>Student Entries: Contact <a href="mailto:jobrien49@gatech.edu"><b>Jen O’Brien</b></a> to enter a classic car, contraption, or fixed body entry.  Entry fees are $80 for classic car, $70 for fixed body, and $60 for contraption.</p><p>Alumni Entries: Alumni classic car entries must be submitted to this <a href="https://forms.gle/r4ucqRL469vANeus6">Link</a>. For more information, contact <a href="mailto:bbbrennan3@gmail.com"><b>Brooke Brennan</b></a></p><p> Dance Groups: Contact Brooke Brennan if your organization is interested in performing in the year’s Wreck Parade! </p><p>The Wreck Parade Chairs reserve the right to refuse participation to entries due to safety or time constraints as registration fills. </p><p>Contraptions and fixed body entries must be registered before the first round of inspections.  Classic cars must be registered by October 30th at 11:59 PM.</p>'

        ],
        [
            "image" => '/homecoming/images/wp-003.jpg',
            "title" => 'Logistics',
            "main" => '<ul><li>Location: Fowler St. from 8th St. to Ferst Dr. </li><li>Date: November 2nd, 2019</li><li>Time: 8:00 AM</li></ul>'
        ],
        [
            "image" => '/homecoming/images/wp-004.jpg',
            "title" => 'Categories',
            "main" => '<p>Wreck Parade features three categories for entries: classic car, fixed body and contraption. Classic Car: A restored car which is over 25 years old.  This category is specifically inspired by our very own 1930 Model A Ford!</p><p> Fixed Body: A vehicle which features a display designed and built by students and reflects the Homecoming theme, such as this year’s “Jousting Jackets!”  These vehicles are driven by machine power, and are most similar to parade floats.</p><p> Contraption: Similar to fixed body entries, these vehicles are designed and built by students and follow the Homecoming theme!  However, these entries are complete human-powered, so creativity and engineering skills can easily be showcased!</p>'
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
            <p class="text-muted"><i>Have any questions? Reach out to Isabel Wickliffe, Reck Club Homecoming Chair, at <a href="mailto:isabel.wickliffe@gatech.edu">isabel.wickliffe@gatech.edu</a>.</i></p>
        </div>
    </div>
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>

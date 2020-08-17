<?php $pageTitle = "Freshman Cake Race"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>

<div class="container mb-3">
    <div class= 'blog-header'>
        <div class='col-12' style="text-align: center;">
            <h1>Freshman Cake Race 2020</h1>
        </div>
    </div>
</div>

<div class="container mb-3">
    <div class="row">
        <div class="col-12">
            <img class="img-fluid img-responsive" src="/homecoming/images/CakeRaceBanner2020.PNG">
        </div>
    </div>
</div>
<div class="container mb-3">
    <div class="row">
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:rrchomecoming@gmail.com"><b>McKade Stewart</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Reck Club Homecoming Chair</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:gtfreshmancakerace@gmail.com"><b>Rachel Hurst</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Cake Race Sub-Chair</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:gtfreshmancakerace@gmail.com"><b>Paul Weiland</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Cake Race Sub-Chair</i></p>
        </div>
    </div>
    <hr class="mb-3">
</div>

<div class="container">
    <div class='row text-center'>
        <div class='col-sm-6 col-xs-12 mb-3 mb-sm-0'>
            <a class='btn btn-md btn-primary' href="#race-day-logistics">Race Day Logistics</a>
        </div>
<!--        sign up button-->
<!--        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-0'>-->
<!--            <a class='btn btn-md btn-secondary' href="https://gatech.campuslabs.com/engage/submitter/form/start/338342">Sign Ups</a>-->
<!--        </div>-->
        <div class='col-sm-6 col-xs-12 mb-sm-0'>
            <?php //If you change the name of the rules section further down, change the href here too. ?>
            <a class='btn btn-md btn-primary' href="#race-rules">Race Rules</a>
        </div>
    </div>
    <hr class="mb-3">
    <?php

    $info1 = array(
        [
            "image" => '/homecoming/images/fcr-001.jpg',
            "title" => 'The Tradition',
            "main" => 'The Freshman Cake Race is a half-mile race held before sunrise on the morning of the Homecoming game every year. This unique long-standing tradition is open to <strong>first year</strong> Georgia Tech students. Each first year receives a cupcake at the end of the race. The male and female winners of the race receive a cake and are brought to the field during halftime of the Homecoming game where they are bestowed a kiss from Mr. and Ms. Georgia Tech. This race dates back to 1911, when the first Cake Race was held as an open cross-country run at Georgia Tech. Two years later, some of the faculty member’s wives started baking cakes for the winners, thus the name Cake Race was created. While the race’s original purpose was to scout men for the track team, today\'s participants are encouraged to run, jog, or walk. First years, sign up today to take part in one of Georgia Tech’s greatest traditions!'
        ],
        [
            "image" => '/homecoming/images/fcr-003.jpg',
            "title" => 'COVID Update',
            "main" => 'Due to the current situation with COVID-19, Freshman Cake Race will look slightly different than previous years. But fear not! The spirit and fun of one of Georgia Tech’s oldest traditions will be kept intact. We have listed a few of the changes below that we have made to keep the event safe!  
                             <ul> <li>The race will be held on a day when there is no football game scheduled to accommodate a longer race time. The race will span 6 hours in order to run a larger amount of heats, with a maximum of 15 freshmen in each heat spaced 6 feet apart to begin the race</li>
                              <li>Each residence hall will be given a time block for its residents to come and race during any time within the block. Each freshman will undergo a temperature check upon arrival.</li><ul>'

        ],
        [
            "image" => '/homecoming/images/fcr-004.jpg',
            "title" => ' ',
            "main" => ' <ul> <li>All volunteers helping execute the event will be wearing proper PPE and will be screened before they begin working the event</li>
                              <li>Freshmen will be appropriately spaced 6 feet apart throughout the race staging and start</li>
                              <li>At the finish line, cupcakes and water bottles will be spaced multiple feet apart on tables. Volunteers wearing PPE will restock the cupcakes as they are taken by freshmen as they finish.</li>
                              <li>Freshmen will be encouraged to quickly take a photo with the Reck and then move through the finish area to discourage crowding.</li>
                              <li>The top three female and male racers will have a cake delivered to their residence hall!</li> </ul>
                              We are so excited to still get to put on this event and are taking every precaution we can to keep it safe and fun! If you have any questions or concerns please reach out to gtfreshmancakerace@gmail.com.
                              '

        ],
        [
            "image" => '/homecoming/images/fcr-002.jpg',
            "title" => 'Sign Ups',
            "main" => 'Please fill out the following interest form if you are interested in participating in the Freshman Cake Race. We will be sending each person who filled out the form the official sign-up once it is finalized. Interest Form: <a href="https://forms.gle/7XLJ7N6cFG7um1pV8">https://forms.gle/7XLJ7N6cFG7um1pV8</a>'

        ],
        [
            "image" => '/homecoming/images/fcr-005.jpg',
            "title" => 'Race Bib Pickup',
            "main" => 'The Freshman Cake Race Co-Chairs are still evaluating the best way to safely proceed with bib distribution. Each participant who signs up will be emailed with more exact information or one can check back here for updates.'
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

    <?php
    $info2 = array(
               [
            "image" => '/homecoming/images/fcr-004.jpg',
            "title" => 'Clothing Recommendations',
            "main" => 'Be sure to wear tennis shoes/sneakers and clothes that you would be comfortable running or walking in. Remember, you are encouraged to run or walk at your own pace. Depending on the temperature, make sure to dress in clothes that will keep you warm (sweatshirt/jacket, pants, hats, gloves, etc).'
        ],
        [
            "image" => '/homecoming/images/fcr-003.jpg',
            "title" => 'Race Rules',
            "main" => '<ul><li>Participants must start the race at the designated start line.</li>
<li>No pushing or shoving is allowed during the race.</li>
<li>Students must wear their race bib for the entirety of the race.</li> 
<li>Race bibs must be visible and worn outside of clothing and blankets.</li> 
<li>Any student that is intoxicated will <strong>not</strong> be allowed to race.</li> 
<li>Students are not allowed to litter the trash from cupcakes and cakes.</li> 
</ul><p><strong>Any violations of these rules will result in disqualification of the participant and that participant’s organization will not receive points towards Homecoming. The violator’s organization will not be allowed to participate in Homecoming the following year.</strong> Violators will be brought to the Office of Student Integrity.</p>
The full rule book can be found here: <a href="https://docs.google.com/document/d/1OVVEh-vWnf0hrs1GoqRK3VUM1JRjKcr0ErBGR7mBexg/edit?usp=sharing
">FCR 2020 Rule Book
</a> '
        ]
    );

    echo "<div class= 'blog-header'>";
    echo "<div class='col-12' style=\"text-align: center;\">";
    echo "<h1 id='race-day-logistics'>Race Day Logistics</h1></div></div><br>";


    foreach ($info2 as $item) {
        echo "<div class='row mb-3' id='" . str_ireplace(' ', '-', strtolower($item['title'])) ."'>";
        echo "<div class='col-md-5 col-sm-12'><img class= \"img-fluid mb-3 mb-md-0\" src=\"" . $item["image"] . "\"/></div>";
        echo "<div class='col-md-7 col-sm-12'>";
        echo "<h4>". $item["title"] . "</h4>";
        $lines = explode('\n', $item['main']);
        foreach ($lines as $line) {
            echo "<p> " . $line . "<p>";
        }
        echo "</div>";
        echo "</div>";
    }

    ?>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-muted"><i>Have any questions? Reach out to us at <a href="mailto:gtfreshmancakerace@gmail.com">gtfreshmancakerace@gmail.com</a> or <a href="mailto:rrchomecoming@gmail.com">rrchomecoming@gmail.com</a>.</i></p>
        </div>
    </div>
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>
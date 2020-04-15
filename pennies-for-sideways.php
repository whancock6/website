<?php $pageTitle = "Pennies For Sideways"; ?>
<?php require "utils/array_formatter.php"; ?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php" ?>

<body>
<?php require "partials/public-header.php" ?>

<div class="container mb-3">
    <div class="row">
        <div class="col-12">
            <img class="img-fluid img-responsive" src="/img/pennies/p-banner2.jpg">
        </div>
    </div>
</div>
<div class="container">
    <div class='row text-center'>
        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-0'>
            <a class='btn btn-md btn-secondary' href="https://venmo.com/Ramblin-Reck-Club">Venmo</a>
        </div>
        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-0'>
            <a class='btn btn-md btn-primary' href="https://cash.app/$RamblinReckClub" target="_blank">CashApp</a>
        </div>
        <div class='col-sm-4 col-xs-12'>
            <a class='btn btn-md btn-secondary' href="https://paypal.me/RamblinReckClub" target="_blank">PayPal</a>
        </div>
    </div>
    <hr class="mb-3">
</div>

<div class="container">
    <?php

    $info1 = array(
        [
            "image" => '/img/pennies/p-001small.jpg',
            "title" => 'Intro to Sideways the Dog',
            "main" => '<p>In March 1945, the Georgia Tech community was introduced to a girl that stole everyone’s hearts: an eight month old white terrier with a black patch on one of her eyes named Sideways. After being thrown from a car on North Avenue, Georgia Tech adopted Sideways, and she soon became a campus icon. Known for walking at a slight angle as a result of her injury—giving her the name Sideways—she would commonly be found walking in and out of lectures, marching with the drill team, and even leading the football team onto the field. After living on campus for a few years, Sideways mysteriously passed away on August 14th, 1947. Her life was forever memorialized on campus with a slightly slanted grave underneath Tech Tower where all students, past and present, could go to pay their respects to the beloved campus celebrity. Today, it is tradition for students to leave pennies on her grave to get some luck before their final exams.</p>'
        ],
        [
            "image" => '/img/pennies/p-002.png',
            "title" => 'Pennies for Sideways, Dollars for Students',
            "main" => '<p>Leaving a penny on the grave of Sideways the dog, located just outside Tech Tower, has been a way for Georgia Tech students to get a bit of extra luck heading into finals season for decades now. Though campus is currently empty, the Ramblin’ Reck Club has been working on a solution that will allow our entire community to participate this spring from the comfort of their homes -- all while raising money for a good cause!</p><p>From Monday, April 13th until Wednesday, April 22nd, we are inviting everyone to send in donations -- as little as one penny or as much as you can give! -- to benefit the Emergency Student Relief Fund established in response to COVID-19. In exchange, we will leave a penny on Sideways’ grave in your honor (or the honor of someone you know) before finals start!</p><p>Our goal is to promote wide participation in a unique Georgia Tech tradition while raising money to support our fellow students during a difficult time. No matter your relation to the Georgia Tech community, we invite you to show your love for your fellow Yellow Jackets and to take part in the first virtual enactment of a 72-year-old tradition!</p>'
        ],
        [
            "image" => '/img/pennies/p-003.jpg',
            "title" => 'How to Participate',
            "main" => '<p>To participate, you can send your donation or proof of donation via one of the options below. Make sure to send us your name or the name of your chosen honoree along with your submission if you would like to be listed as a participant on <a href="#thank-you-donors">this page</a>!</p><ul><li>Venmo: @Ramblin-Reck-Club</li><li>Cash App: $RamblinReckClub</li><li>Paypal: treasurer@reckclub.org</li><li>Directly to the Student Relief Fund: Follow the instructions detailed <a href="https://news.gatech.edu/2020/03/23/student-emergency-funding-now-available">here</a> and email a screenshot of your confirmation to <a href="mailto:help@reckclub.org">help@reckclub.org</a></li></ul><p>If you are donating on behalf of a student organization, write the organization’s name along with your contribution. <strong>The Ramblin’ Reck will make an appearance at a meeting to give members rides for the organization that raises the most money and the one that has the highest number of participants!</strong></p><p>Finally, please participate however you can! If you cannot afford to give the traditional penny or more right now, fill out <a href="https://docs.google.com/forms/d/e/1FAIpQLSfoRHly0488iTVOzzt-HJw8lnUgexxf6VL1Bv9vv-ohnbF-Sw/viewform">this form</a> and we will place one on the grave for you and list you on the website anyway. We believe that traditions should be accessible for everyone!</p><p>*100% of all funds submitted to Ramblin’ Reck Club accounts will be compiled and sent directly to the Student Relief Fund.</p>'
        ],
        [
            "image" => '/img/pennies/p-004.jpg',
            "title" => 'More About Student Relief Fund',
            "main" => '<p>In response to the COVID-19 pandemic, the Division of Student Life, the Alumni Association, and the Development Office have parterened to raise and distribute emergency funding to Georgia Tech students in need. With applications continuing to come in there is still a need for additional fundraising. We hope that we can bring together current students, alumni, faculty, and staff to help raise these critical funds to help our fellow students meet their needs. </p><p>For more information on the Student Relief Fund including how to apply yourself, visit <a href="https://news.gatech.edu/2020/03/23/student-emergency-funding-now-available">this link.</a></p>'
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
    <div class="row">
        <div class="col-12">
            <p class="text-muted"><i>Have any questions not covered here? Reach out to the organizers at <a href="mailto:help@reckclub.org">help@reckclub.org</a>.</i></p>
        </div>
    </div>
</div>


<div class="container">
    <hr class="mb-3">
    <div class="row">
        <div class="col-12" style="text-align: center;">
            <h2 id="thank-you-donors">Thank You Donors!</h2>
        </div>
    </div>
    <div class="row">
        <?php
        $donors = ['Akshay Easwaran','Ana Jafarinia','Annie Robinson','Arushi Gupta','Carter Kubes','Chelsea Yangnouvong','CJ Young','Daley Cass','Derek Prusener','Elizabeth Cowan','Emmett Halloran','Gigi P','Isabelle Liffiton','Jasper and Florence Jackson','Jen O\'Brien','Jill Riley','Marissa Klee','Matt O\'Brien','Matthew Askari','McKade Stewart','Megha Desai','Rachel Hurst','Robert Cottingham','Shivanee Persaud','Caroline Means','Emma Siegfried','Adam Lederer','Andy Begazo','Sean Walsh','Jo\'De Cummings','Hannah Schafer','J M Stewart','Maite Marin-Mera','Alec Liberman','Katie Earles','Caleb Torres','Grace Mallon','Sofia Eidizadeh','Nicholas Revelos','Taylor Gray','Jim Elliot','Samuel Stewart','Anonymous (in honor of Spring 2020 Graduates)', 'George P. Burdell'];
        sort($donors);
        chunkAndFormatArray($donors, 4, function ($chunk) {
            echo "<div class=\"col-md-3 text-center\">";
            foreach ($chunk as $item) {
                echo "<p class='text-center'>" . $item . "</p>";
            }
            echo "</div>";
        });
        ?>
    </div>
    <hr class="mb-3">
</div>

<?php require "partials/footer.php" ?>
<?php require "partials/scripts.php" ?>
</body>

</html>

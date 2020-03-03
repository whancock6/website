<?php $pageTitle = "Roster"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>
<div class="container">
    <h2 class="mb-3">2020 Roster</h2>
    <h4 class="mb-4">Executive Board</h4>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Faculty Advisor:</strong> <a href="mailto:estephens34@gatech.edu">Gerome Stephens</a></p>
            <p><strong>Reck Driver:</strong> <a href="mailto:driver@reckclub.org">Abi Ivemeyer</a></p>
            <p><strong>President:</strong> <a href="mailto:president@reckclub.org">Cade Lawson</a></p>
            <p><strong>Vice President:</strong> <a href="mailto:ethanrosman@gatech.edu">Ethan Rosman</a></p>
        </div>
        <div class="col-md-6">
            <p><strong>Treasurer:</strong> <a href="mailto:treasurer@reckclub.org">Derek Prusener</a></p>
            <p><strong>Secretary:</strong> <a href="mailto:secretary@reckclub.org">Jen O'Brien</a></p>
            <p><strong>Member-at-Large:</strong> <a href="mailto:wmiller48@gatech.edu">Whitney Miller</a></p>
            <p><strong>Member-at-Large:</strong> <a href="mailto:haleyrmcelroy@gmail.com">Haley McElroy</a></p>
        </div>
    </div>
    <hr class="mb-3">
    <h4 class="mb-3">Chairs</h4>

    <div class="row mb-3">
        <div class="col-md-6">
            <?php $chairs = array(
                    [
                "chair" => 'Alumni Relations',
                "name" => 'Sydney Weisenburger'
                ],
                [
                    "chair" => 'Baseball',
                    "name" => 'Brendan Mindiak'
                ],
                [
                    "chair" => 'Basketball',
                    "name" => 'Adam Lederer'
                ],
                [
                    "chair" => 'Big Buzz',
                    "name" => 'Laura Hancher'
                ],
                [
                    "chair" => 'Campus Outreach',
                    "name" => 'Diana Michael'
                ],
                [
                    "chair" => 'Football',
                    "name" => 'Adam Lederer'
                ],
                [
                    "chair" => 'Fundraising',
                    "name" => 'Brittany Ritter'
                ],
                [
                    "chair" => 'Homecoming',
                    "name" => 'McKade Stewart'
                ]);

            foreach ($chairs as $item) {
                echo "<p><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
            }
            
            ?>
        </div>
        <div class="col-md-6">
            <?php $chairs = array(
                [
                    "chair" => 'Non-Revenue Sports',
                    "name" => 'Ethan Kreager & Rachel Hurst'
                ],
                [
                    "chair" => 'Public Relations',
                    "name" => 'Ebie McDonnell'
                ],
                [
                    "chair" => 'Probatemaster',
                    "name" => 'Caroline Means'
                ],
                [
                    "chair" => 'RECKruitment',
                    "name" => 'Kassie Lee'
                ],
                [
                    "chair" => 'T-Book',
                    "name" => 'Katie Earles'
                ],
                [
                    "chair" => 'T-Night',
                    "name" => 'Jack Crawford'
                ],
                [
                    "chair" => 'Technology',
                    "name" => 'Kirby Criswell'
                ],
                [
                    "chair" => 'Traditions',
                    "name" => 'Ally Rosenthal'
                ]);

            foreach ($chairs as $item) {
                echo "<p><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
            }

            ?>
        </div>
    </div>
    <hr class="mb-3">
    <h4 class="mb-3">Members</h4>
    <div class="row">
        <div class="col-md-2">
            <?php $members = ['Abi Ivemeyer','Adam Lederer','Ally Rosenthal','Amanda Healy','Annie Robinson', 'Brandon Dobson','Brayton Miles','Brendan Mindiak', 'Brittany Powell']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-2">
            <?php $members = ['Brittany Ritter','Brooke Brennan', 'Cade Lawson','Caroline Means','Dean Plaskon', 'Derek Prusener','Diana Michael', 'Ebie McDonnell', 'Ethan Kreager']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-2">
            <?php $members = ['Ethan Rosman','Gracie Curran','Haley McElroy','Inika Jain','Isabelle Liffiton', 'Jack Crawford', 'Jake Grant', 'Jen O\'Brien', 'Jill Riley']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-2">
            <?php $members = ['Kassie Lee', 'Katie Coveny','Katie Earles', 'Kayleigh Nortje', 'Kirby Crisswell', 'Laura Hancher', 'Marissa Klee', 'Matt DeJonge', 'McKade Stewart']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-2">
            <?php $members = ['Noah Bryant', 'Rachel Hurst','Ronnie Ludwin','Samantha White','Sunny Thomson','Sydney Weisenburger','Whitney Miller','Zoe Sieling']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
    </div>
    <hr class="mb-3">
    <h4 class="mb-4">Probates</h4>
    <div class="row mb-3">
        <div class="col-md-3">
            <?php $members = ['Andy Begazo','Anilyn Benge','Austin Gies','Brendon Thaler', 'Briana Sims']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-3">
            <?php $members = ['Carter Kubes','Emma Wojack','Grace Mallon', 'Isheeta Mukherjee', 'Jacob Lewis']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-3">
            <?php $members = ['Keshav Ramanathan','Kevin Hopper','Nick Isaf', 'Paul Weiland', 'Ross LeRoy']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-3">
            <?php $members = ['Sofia Eidizadeh', 'Tae Kim', 'Taylor Gray', 'Zach Bellis']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
    </div>
    <hr class="mb-3">
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>

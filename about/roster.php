<?php $pageTitle = "Roster"; ?>
<?php require "../utils/array_formatter.php"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>
<div class="container">
    <h2 class="mb-3">2021 Roster</h2>
    <h4 class="mb-4">Executive Board</h4>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Faculty Advisor:</strong> <a href="mailto:estephens34@gatech.edu">Gerome Stephens</a></p>
            <p><strong>Reck Driver:</strong> <a href="mailto:driver@reckclub.org">Evalyn Edwards</a></p>
            <p><strong>President:</strong> <a href="mailto:president@reckclub.org">Grace Mallon</a></p>
            <p><strong>Vice President:</strong> <a href="mailto:imukherjee300@gatech.edu">Isheeta Mukherjee</a></p>
        </div>
        <div class="col-md-6">
            <p><strong>Treasurer:</strong> <a href="mailto:treasurer@reckclub.org">Josh Fernandes</a></p>
            <p><strong>Secretary:</strong> <a href="mailto:secretary@reckclub.org">Reid Spencer</a></p>
            <p><strong>Member-at-Large:</strong> <a href="mailto:jdadamio3@gatech.edu">Joey D'Adamio</a></p>
            <p><strong>Member-at-Large:</strong> <a href="mailto:chammer6@gatech.edu">Charlie Hammer</a></p>
        </div>
    </div>
    <hr class="mb-3">
    <h4 class="mb-3">Chairs</h4>

    <div class="row mb-3">
        <?php $chairs = array(
            [
                "chair" => 'Alumni Relations',
                "name" => 'Annie Robinson'
            ],
            [
                "chair" => 'Baseball',
                "name" => 'Kassie Lee'
            ],
            [
                "chair" => 'Basketball',
                "name" => 'Brendon Thaler'
            ],
            [
                "chair" => 'Fundraising and Big Buzz',
                "name" => 'Paul Weiland'
            ],
            [
                "chair" => 'Campus Outreach',
                "name" => 'Abi Ivemeyer'
            ],
            [
                "chair" => 'Football',
                "name" => 'Keshav Ramanathan'
            ],
            [
                "chair" => 'CSON',
                "name" => 'Adam Lederer'
            ],
            [
                "chair" => 'Homecoming',
                "name" => 'Anilyn Benge and Jack Crawford'
            ],
            [
                "chair" => 'Non-Revenue Sports',
                "name" => 'Charlie Hammer'
            ],
            [
                "chair" => 'Public Relations',
                "name" => 'Jordan Lawson'
            ],
            [
                "chair" => 'Probate Guides',
                "name" => 'Austin Gies and Carter Kubes'
            ],
            [
                "chair" => 'RECKruitment',
                "name" => 'Abi Ivemeyer and Derek Prusener'
            ],
            [
                "chair" => 'T-Book',
                "name" => 'Erin Prusener'
            ],
            [
                "chair" => 'T-Night',
                "name" => 'Bethany McMorris'
            ],
            [
                "chair" => 'Technology',
                "name" => 'Dean Plaskon'
            ],
            [
                "chair" => 'Traditions',
                "name" => 'Cade Lawson'
            ],
            [   "chair" => 'Diversity and Inclusion',
                "name" => 'Bethany McMorris and Matt Warrington'
             ]);
        uasort($chairs, function($a, $b) {
            if ($a["chair"] > $b["chair"]) {
                return 1;
            } elseif ($a["chair"] < $b["chair"]){
                return -1;
            } else {
                return 0;
            }
        });
        chunkAndFormatArray($chairs, 2, function ($chunk) {
            echo "<div class=\"col-md-6 text-center\">";
            foreach ($chunk as $item) {
                echo "<p class='text-left'><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
            }
            echo "</div>";
        });

        ?>
    </div>
    <hr class="mb-3">
    <h4 class="mb-3">Members</h4>
    <div class="row mb-3">
    <?php
  $members = ['Abi Ivemeyer', 'Adam Lederer', 'Andreea Juravschi', 'Andrew Norlin', 'Anilyn Benge', 'Austin Gies', 'Austin Reitano', 'Bethany McMorris', 'Brendan Mindiak', 'Brendon Thaler', 'Cade Lawson', 'Carter Kubes', 'Charlie Hammer', 'Dean Plaskon', 'Derek Prusener', 'Eleanor Froula', 'Emma Wojack', 'Erin Prusener', 'Evalyn Edwards', 'Grace Mallon', 'Isheeta Mukherjee', 'Jacob Lewis', 'Jen O\'Brien', 'Joey D\'Adamio', 'Jonathan Brooks', 'Jordan Lawson', 'Josh Fernandes', 'Josh Thrift', 'Kassie Lee', 'Katie Earles', 'Kayvon Dibai', 'Kelsey Watkins', 'Keshav Ramanathan', 'Madison Meyers', 'Matt Warrington', 'Melissa Braunstein', 'Reid Spencer', 'Ross LeRoy', 'Sam Derry', 'Sarah Wiedetz', 'Shawn McKelvey', 'Sofia Eidizadeh', 'Sumayyah Ahmed', 'Taylor Gray', 'Will Hancock', 'Zach Bellis'];
    sort($members);
    chunkAndFormatArray($members, 6, function ($chunk) {
        echo "<div class=\"col-md-2 text-center\">";
        foreach ($chunk as $item) {
            echo "<p class='text-left'>" . $item . "</p>";
        }
        echo "</div>";
    });
    ?>
    </div>
    <hr class="mb-3">
    <h4 class="mb-3">Probates</h4>
    <div class="row mb-3">
        <?php
        $probates = [""];
        sort($probates);
        chunkAndFormatArray($probates,6, function ($chunk) {
            echo "<div class=\"col-md-2 text-center\">";
            foreach ($chunk as $item) {
                echo "<p class='text-left'>" . $item . "</p>";
            }
            echo "</div>";
        });
        ?>
    </div>
    <hr class="mb-3">
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>

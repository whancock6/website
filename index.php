<?php $pageTitle = "Spreading Joy Since 1930"; ?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php" ?>

<body>
<?php require "partials/public-header.php" ?>
<div class="mb-3">
    <div id="img-carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#img-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#img-carousel" data-slide-to="1"></li>
            <li data-target="#img-carousel" data-slide-to="2"></li>
            <li data-target="#img-carousel" data-slide-to="3"></li>

        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <picture>
                    <source class="img-responsive d-block w-100" srcset="img/2021/club_before_game_v3.jpg" media="(min-width: 900px)" alt="Reck Club pic before Football game">
                    <img class="img-responsive d-block w-100" src="img/2021/club_before_game.jpg" alt="Reck Club pic before Football game">
                </picture>
                <div class="gradient">
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to the online home of the Ramblin' Reck Club!</h5>
                    <p>Since its founding in 1930, the Ramblin’ Reck Club has been an organization of students, committed to the education and promotion of Tech spirit, history and tradition. Learn more about us <a href="/about/index.php">here</a>!</p>
                </div>
            </div>
            <div class="carousel-item">
                <picture>
                    <source class="img-responsive d-block w-100" srcset="/img/2021/merc_ride_out_v2.jpg" media="(min-width: 900px)" alt="2021 Mercedes-Benz game ride-out">
                    <img class="img-responsive d-block w-100" src="/img/2021/merc_ride_out.jpg" alt="2021 Mercedes-Benz game ride-out">
                </picture>
                <div class="gradient">
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Interested in the Reck?</h5>
                    <p>While many people believe that there are multiple Recks serving as Georgia Tech’s mascot, in actuality there is only one official Ramblin’ Reck which has led the football team and served as a symbol of the institute since 1961. Learn more about the car <a href="/reckhistory">here</a>!</p>
                </div>
            </div>
            <div class="carousel-item">
                <picture>
                    <source class="img-responsive d-block w-100" srcset="/img/promo/ReckEcoCommons_v2.png" media="(min-width: 900px)" alt="2021 Reck at Eco Commons building for a Reck Event">
                    <img class="img-responsive d-block w-100" src="/img/promo/ReckEcoCommons.png" alt="2021 Reck at Eco Commons building for a Reck Event">
                </picture>
                <div class="gradient">
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Want the Reck at your event?</h5>
                    <p>When not on official duty, the Ramblin’ Reck may appear at various alumni functions. Proceeds are used to support the maintenance and upkeep of the car. Click <a href="/requests.php">here</a> to make your request!</p>
                </div>
            </div>
            <div class="carousel-item">
                <picture>
                    <source class="img-responsive d-block w-100" srcset="/img/2021/merc_alma_mater_v2.jpg" media="(min-width: 900px)" alt="2021 Alma mater on the Mercedes Benz field">
                    <img class="img-responsive d-block w-100" src="/img/2021/merc_alma_mater.jpg" alt="2021 Alma mater on the Mercedes Benz field">
                </picture>
                <div class="gradient">
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Want to join the team?</h5>
                    <p>Recruitment happens every Spring, find out more information about the process <a href="/reckruitment/index.php">here!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-primary">The Reck</strong>
                    <h3 class="mb-1 text-dark">Drivers</h3>
                    <p class="card-text mb-auto">Each year, one student is chosen from the ranks of the club to be the sole driver and primary caretaker of the Ramblin’ Reck.</p>
                    <a href="/reck/drivers.php">Read more</a>
                </div>
                <img class="card-img-right img-fluid flex-auto d-none d-md-block" data-src="/img/promo/EvalynDriver.png" style="width: 200px; height: 250px;" src="/img/promo/EvalynDriver.png" data-holder-rendered="true">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-secondary">Traditions</strong>
                    <h3 class="mb-1 text-dark">The T-Book</h3>
                    <p class="card-text mb-auto">The Georgia Tech T-book was originally published by the Georgia Tech YMCA with the intention of providing a guide to the new Tech students abo...</p>
                    <a href="/about/t-book.php">Continue reading</a>
                </div>
                <img class="card-img-right img-fluid flex-auto d-none d-md-block" src="/img/promo/mantle-tbook.jpg" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <img class="card-img-left img-fluid flex-auto d-none d-md-block" src="/img/promo/1961-reck-debut.jpg" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-secondary">History</strong>
                    <h3 class="mb-1 text-dark">The Reck</h3>
                    <p class="card-text mb-auto">The Reck was formally introduced as Georgia Tech's mascot when it led the football team out on to Grant Field for the 1961 homecoming game...</p>
                    <a href="/reckhistory">Continue reading</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <img class="card-img-left img-fluid flex-auto d-none d-md-block" src="/img/promo/ReckRunningBoard.png" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-primary">RECKruitment</strong>
                    <h3 class="mb-1 text-dark">Want to join the tradition?</h3>
                    <p class="card-text mb-auto">Learn more about what it is to be a part of Reck Club and kickstart your recruitment process!</p>
                    <a href="/reckruitment">Read more</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "partials/footer.php" ?>
<?php require "partials/scripts.php" ?>
</body>

</html>

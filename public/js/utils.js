if ($(window).width() >= 768) {
    // do something for huge screens
    $(".jumbotron-third-title").addClass('display-4');
    $(".jumbotron-third-detail").addClass('display-1');
} else if ($(window).width() < 700) {
    $("#loggedInName").remove();
    $("#userOptions").addClass("offset-0");
    $("#logo-container").addClass("col-3");
    $("#logo-container").addClass("offset-3");

    $(".rrc-social-icon").addClass("col-3 mr-0");
    $(".rrc-social-icon").removeClass("col-1 mr-0");
    $("#social-icon-holder").addClass("row");

    if ($(window).width() < 500) {
        $("#adminButton").addClass('text-center');
    }

    if ($(window).width() < 350) {
        $(".jumbotron-third-title").addClass('lead');
        $(".jumbotron-third-detail").addClass('');
    }
}
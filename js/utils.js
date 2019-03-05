if ($(window).width() >= 768) {
    $(".jumbotron-third-title").addClass('display-4');
    $(".jumbotron-third-detail").addClass('display-1');
} else if ($(window).width() < 700) {
    $(".rrc-social-icon").addClass("col-3 mr-0");
    $(".rrc-social-icon").removeClass("col-1 mr-0");
    $("#social-icon-holder").addClass("row");

    if ($(window).width() < 350) {
        $(".jumbotron-third-title").addClass('lead');
        $(".jumbotron-third-detail").addClass('');
    }
}

if ($(window).width() < 992) {
    $('div.gradient').remove();
}
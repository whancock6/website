<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="The online home of the Ramblin' Reck Club, a campus organization at the Georgia Institute of Technology dedicated to the promotion of Georgia Tech traditions and spirit and responsible for the Institute's mascot car - the Ramblin' Reck.">
    <meta name="author" content="Ramblin' Reck Club">

    <title>Request the Reck | Ramblin' Reck Club</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/form-validation.css" rel="stylesheet">
</head>

<body>
<?php
$tz = 'America/New_York';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
?>
<div class="container">
    <div class="py-3 text-center">
        <a href="../index.php"><img class="d-block mx-auto mb-4 mt-4" src="/img/brand/official-logo.png" alt="" width="150" height="150"></a>
        <h2>Request the Ramblin' Reck</h2>
        <p class="lead">When it is not being used for official Georgia Tech business and events, the Ramblin’ Reck is able to appear at events for Georgia Tech alumni and fans.  While many people believe that there are multiple Recks serving as Georgia Tech’s mascot, in actuality there is only one official Ramblin’ Reck which has led the football team and served as a symbol of the institute since 1961. Please make your request below; you will be contacted by the current Ramblin’ Reck driver shortly after.</p>
    </div>
    <div class="row">
        <div class="message-space col-6 offset-3">

        </div>
    </div>
    <div class="row">
        <div id="request-form" class="offset-xl-1 col-xl-10 offset-lg-2 col-lg-8 offset-md-3 col-md-6">
            <h4 class="mb-3">Request Details</h4>
            <form class="needs-validation" novalidate="">
                <div class="row">
                    <div class="col-4 mb-3">
                        <label for="event-name">Name</label>
                        <input type="text" class="form-control" id="renter-name" placeholder="George P. Burdell" value="" required="">
                        <div class="invalid-feedback">
                            Valid name is required.
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="event-name">Email</label>
                        <input type="email" class="form-control" id="renter-email" placeholder="gpb@gatech.edu" value="" required="">
                        <div class="invalid-feedback">
                            Valid email is required.
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="event-phone-number">Contact Phone Number</label>
                        <input type="tel" class="form-control" id="renter-phone-number" placeholder="(xxx) xxx-xxxx" value="" required="" pattern="^((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}$">
                        <div class="invalid-feedback">
                            Valid phone number is required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="event-name">Event name</label>
                        <input type="text" class="form-control" id="event-name" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            Valid event name is required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="event-name">Event address</label>
                        <input type="text" class="form-control" id="event-location" placeholder="Please include the city and state." value="" required="">
                        <div class="invalid-feedback">
                            Valid event location is required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="event-name">Distance from Campus</label>
                        <input type="text" class="form-control" id="event-distance-away" placeholder="In miles" value="" required="">
                        <div class="invalid-feedback">
                            Valid event distance is required.
                        </div>
                        <small class="form-text text-muted">Please <a href="http://maps.google.com/maps?f=d&source=s_d&saddr=10th+St+NW+%26+Fowler+St+NW,+Atlanta,+GA&daddr=&hl=en&geocode=&mra=ls&sll=33.777087,-84.408254&sspn=0.012485,0.027874&ie=UTF8&ll=33.779629,-84.393239&spn=0.012485,0.027874&z=16">click here</a> to calculate your event's distance from campus.</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="event-name">Event details</label>
                        <textarea class="form-control" id="event-details" placeholder="Please provide all important setup details and other pertinent information here." value=""></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="event-month">Event Month</label>
                        <select class="custom-select d-block w-100" id="event-month" required="">
                            <?php $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            foreach ($months as $month) {
                                if ($month == $dt->format('F')) {
                                    echo "<option value=\"" . $month . "\" selected=\"selected\">" . $month . "</option>";
                                } else {
                                    echo "<option value=\"" . $month . "\">" . $month . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid month.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="event-day">Event Day</label>
                        <select class="custom-select d-block w-100" id="event-day" required="">
                            <?php
                            for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, array_search($month, $months, TRUE) + 1, date("Y")); $day++) {
                                if ($day == $dt->format('d')) {
                                    echo "<option value=\"" . $day . "\" selected=\"selected\">" . $day . "</option>";
                                } else {
                                    echo "<option value=\"" . $day . "\">" . $day . "</option>";
                                }
                            }

                            ?>
                        </select>
                        <!--<input type="text" class="form-control" id="event-day" placeholder="" required="">-->
                        <div class="invalid-feedback">
                            Event day required.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="event-year">Event Year</label>
                        <input id="event-year" class="form-control" maxlength="4" type="text" placeholder="Year" value="<?php echo $dt->format('Y'); ?>" required>
                        <div class="invalid-feedback">
                            Event year required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h6 class="col-md-6">Event Start Time</h6>
                    <h6 class="col-md-6">Event End Time</h6>
                </div>
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <select class="custom-select d-block w-100" id="event-start-hour" required="">
                            <?php
                            for ($hour = 1; $hour <= 12; $hour++) {
                                if ($hour == $dt->format('h')) {
                                    echo "<option value=\"" . $hour . "\" selected=\"selected\">" . $hour . "</option>";
                                } else {
                                    echo "<option value=\"" . $hour . "\">" . $hour . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Event start hour required.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="custom-select d-block w-100" id="event-start-minute" required="">
                            <?php
                            for ($minute = 0; $minute <= 60; $minute++) {
                                if ($minute == 0) {
                                    if ($minute < 10) {
                                        echo "<option value=\"" . $minute . "\" selected=\"selected\">0" . $minute . "</option>";
                                    } else {
                                        echo "<option value=\"" . $minute . "\" selected=\"selected\">" . $minute . "</option>";
                                    }
                                } else {
                                    if ($minute < 10) {
                                        echo "<option value=\"" . $minute . "\">0" . $minute . "</option>";
                                    } else {
                                        echo "<option value=\"" . $minute . "\">" . $minute . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Event start minute required.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="custom-select d-block w-100" id="event-start-mode" required="">
                            <option value="AM" selected="selected">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="custom-select d-block w-100" id="event-end-hour" required="">
                            <?php
                            for ($hour = 1; $hour <= 12; $hour++) {
                                if ($hour == $dt->format('h')) {
                                    echo "<option value=\"" . $hour . "\" selected=\"selected\">" . $hour . "</option>";
                                } else {
                                    echo "<option value=\"" . $hour . "\">" . $hour . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Event end hour required.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="custom-select d-block w-100" id="event-end-minute" required="">
                            <?php
                            for ($minute = 0; $minute <= 60; $minute++) {
                                if ($minute == 0) {
                                    if ($minute < 10) {
                                        echo "<option value=\"" . $minute . "\" selected=\"selected\">0" . $minute . "</option>";
                                    } else {
                                        echo "<option value=\"" . $minute . "\" selected=\"selected\">" . $minute . "</option>";
                                    }
                                } else {
                                    if ($minute < 10) {
                                        echo "<option value=\"" . $minute . "\">0" . $minute . "</option>";
                                    } else {
                                        echo "<option value=\"" . $minute . "\">" . $minute . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Event end minute required.
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="custom-select d-block w-100" id="event-end-mode" required="">
                            <option value="AM" selected="selected">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
                <hr class="mb-4">
                <button id="submit-request-button" class="btn btn-primary btn-lg btn-block" type="submit">Submit request</button>
            </form>
        </div>
    </div>
</div>
<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
<script>
    function createEvent() {
        $('#submit-request-button').attr('disabled','disabled')
        $('#submit-request-button').html('Submitting request...');
        $.ajax({
            url: '/reck/request-handler.php',
            type: 'POST',
            data: {
                renterName: $('#renter-name').val(),
                renterEmail: $('#renter-email').val(),
                renterPhoneNumber: $('#renter-phone-number').val(),
                eventDetails: $('#event-details').val(),
                eventName: $('#event-name').val(),
                eventLocation: $('#event-location').val(),
                eventDate: $('#event-month').val() + ' ' + $('#event-day').val() + ', ' + $('#event-year').val(),
                eventStartTime: $('#event-start-hour').val() + ':' + (parseInt($('#event-start-minute').val()) < 10 ? '0'+$('#event-start-minute').val() : $('#event-start-minute').val()) + ' ' + $('#event-start-mode').val(),
                eventEndTime: $('#event-end-hour').val() + ':' + (parseInt($('#event-end-minute').val()) < 10 ? '0'+$('#event-end-minute').val() : $('#event-end-minute').val()) + ' ' + $('#event-end-mode').val(),
                eventDistanceAway: $('#event-distance-away').val()
            },
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            success: function(result) {
                console.log(result);
                if (result.status == 'ok') {
                    $('#request-form').html("<div class=\"alert alert-success\" role=\"alert\">Your request has been successfully submitted! Return to <a href=\"/\">the home page</a>.</div>");
                } else {
                    $('#request-form').remove();
                    $('.message-space').html("    <div class=\"alert alert-danger alert-dismissible show fade\" role=\"alert\">\n" +
                        "        <strong>Error!</strong> <span id=\"error-message\">" + result.message + "</span>\n" +
                        "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                        "            <span aria-hidden=\"true\">&times;</span>\n" +
                        "        </button>\n" +
                        "    </div>");
                }
            },
            error: function(error) {
                console.log(error);
                $('#request-form').remove();
                $('.message-space').html("    <div class=\"alert alert-danger alert-dismissible show fade\" role=\"alert\">\n" +
                    "        <strong>Error!</strong> <span id=\"error-message\">" + error.message + "</span>\n" +
                    "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                    "            <span aria-hidden=\"true\">&times;</span>\n" +
                    "        </button>\n" +
                    "    </div>");
            }
        })
    }

    function isDateSetValid() {
        var curDate = moment();
        var eventDate = moment($('#event-year').val() + '-' + $('#event-month').val() + '-' + $('#event-day').val(),'YYYY-MMM-D');
        return eventDate.isSameOrAfter(curDate, 'day');
    }

    (function() {
        'use strict';

        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    if (form.checkValidity() === false) {
                        event.stopPropagation();
                        if (!isDateSetValid()) {
                            event.stopPropagation();
                            $('.message-space').html("    <div class=\"alert alert-danger alert-dismissible show fade\" role=\"alert\">\n" +
                                "        <strong>Error!</strong> <span id=\"error-message\">Please provide a valid date.</span>\n" +
                                "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                                "            <span aria-hidden=\"true\">&times;</span>\n" +
                                "        </button>\n" +
                                "    </div>");
                            $('#event-day').css('border-color', '#D75452');
                            $('#event-month').css('border-color', '#D75452');
                            $('#event-year').css('border-color', '#D75452');
                        }
                    } else if (!isDateSetValid()) {
                        event.stopPropagation();
                        $('.message-space').html("    <div class=\"alert alert-danger alert-dismissible show fade\" role=\"alert\">\n" +
                            "        <strong>Error!</strong> <span id=\"error-message\">Please provide a valid date.</span>\n" +
                            "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                            "            <span aria-hidden=\"true\">&times;</span>\n" +
                            "        </button>\n" +
                            "    </div>");
                        $('#event-day').css('border-color', '#D75452');
                        $('#event-month').css('border-color', '#D75452');
                        $('#event-year').css('border-color', '#D75452');
                    } else {
                        $('.message-space').html("");
                        $('#event-day').css('border-color', '#5FB760');
                        $('#event-month').css('border-color', '#5FB760');
                        $('#event-year').css('border-color', '#5FB760');
                        createEvent();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>


</body></html>
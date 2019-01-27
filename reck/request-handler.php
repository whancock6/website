<?php

$renterName = $_POST["renterName"];
$renterEmail = $_POST["renterEmail"];
$eventDetails = $_POST["eventDetails"];
$eventName = $_POST["eventName"];
$eventLocation = $_POST["eventLocation"];
$eventDate = $_POST["eventDate"];
$eventStartTime = $_POST["eventStartTime"];
$eventEndTime = $_POST["eventEndTime"];
$eventDistanceAway = $_POST["eventDistanceAway"];

$url = "https://api.sendgrid.com/v3/mail/send";

$mailOptions = [
    "personalizations" => [
        [
            "to" => [
                [
                    "name" => "Ramblin\' Reck Driver",
                    "email" => getenv("RECK_REQUEST_RECIPIENT")
                ]
            ]
        ]
    ],
    "from" => [
        "name" => "Ramblin' Reck Club",
        "email" => "no-reply@reckclub.org"
    ],
    "subject" => "[Ramblin' Reck] New Appearance Request from " . $renterName,
    "content" => [
        [
            "type" => "text/html",
            "value" => nl2br("A new Ramblin' Reck appearance request has been submitted via https://reckclub.org/reck/request.php.\n\n" .
                "<b>Requestor:</b> " . $renterName . " <" . $renterEmail . ">\n" .
                "<b>Event Name:</b> " . $eventName . "\n" .
                "<b>Event Location:</b> " . $eventLocation . "\n" .
                "<b>Event Date:</b> " . $eventDate . "\n" .
                "<b>Event Start Time:</b> " . $eventStartTime . "\n" .
                "<b>Event End Time:</b> " . $eventEndTime . "\n" .
                "<b>Distance from GT:</b> " . $eventDistanceAway . (strpos($eventDistanceAway, 'miles') ? '' : ' miles') .
                "<b>Event Details:</b> " . ((strlen($eventDetails) > 0) ? $eventDetails : "No additional information provided.") . "\n" .
                "\n" .
                "Please email <a href='mailto:" . $renterEmail . "'>" . $renterName . "</a> at your earliest convenience to confirm or reject this request.\n\n--\nThis email was sent automatically from reckclub.org. Please do not reply to this email -- the sender is a not real inbox. If you received this email in error, please contact technology@reckclub.org.")
        ]
    ]
];

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
$authorization = "Authorization: Bearer " . getenv("SENDGRID_API_KEY");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", $authorization));
curl_setopt($ch,CURLOPT_POST, count($mailOptions));
curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($mailOptions));

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

$result_dict = json_decode($result);
if ($result && array_key_exists("errors", $result_dict)) {
    echo json_encode([
        "status" => "bad",
        "message" => "Something bad happened to this request. :("
    ]);
} else {
    echo json_encode([
        "status" => "ok",
        "message" => "Reck request email sent successfully!"
    ]);
}


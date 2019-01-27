<?php $pageTitle = "Error"; ?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php" ?>
<link rel="stylesheet" href="/css/nav-scroller.css">
<body>
<?php require "partials/public-header.php" ?>
<?php
$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
403 => array('403 Forbidden', 'The server has refused to fulfill your request.'),
404 => array('404 Not Found', 'The document/file requested was not found on this server.'),
405 => array('405 Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
502 => array('502 Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);

$title = $codes[$status][0];
$message = $codes[$status][1];
if ($title == false || strlen($status) != 3) {
    $title = 'Error unknown';
    $message = 'Please supply a valid status code.';
}

if ($status == 404) {
    echo "<div class=\"container text-center mb-4\">
        <h2>404: Page not found</h2>
        <h6>Right area code, wrong address. Try again later, or return to the <a href=\"/\">home page</a>.</h6>
    </div>";
} else {
    echo "<div class=\"container mb-4\">
        <h2>" . $title . "</h2>
        <p>" . $message . "</p>
        <p>If you're seeing this page, please email a screenshot to <a href=\"mailto:technology@reckclub.org\">technology@reckclub.org</a>. We'll get right on fixing it.</p>
    </div>";
}
?>

<?php require "partials/footer.php" ?>
<?php require "partials/scripts.php" ?>
</body>

</html>

<?php

session_start();
$_SESSION['test']="test";
header('Location: winning.php');
exit();
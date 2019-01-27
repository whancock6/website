<html>
<head>
<title>Ramblin' Reck Club</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name = "viewport" content = "width = device-width">
<link href="css/mobile_style.css" rel="stylesheet" type="text/css">
</head>
<body onload="setTimeout(function() { window.scrollTo(0, 1) }, 100);">

<div class="memberLogin">
	<img src="images/mobile_login.png" />
	<form name ="Login" action="mobile_checkLogin.php" method="POST">
		<input type="text" maxlength="32" name="username" class="loginInput" placeholder="Username"><br/>
		<input type="password" maxlength="32" name="password" class="loginInput" placeholder="Password"><br/>
		<input type="submit" value="Login" class="mobileSubmit">
	</form>
</div>

<?php include("footer.php") ?>
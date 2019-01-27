<?php
	// Screw licenses.  This is too trivial.  Use this code any way you want.
	if(strpos($_SERVER[HTTP_USER_AGENT], 'iPhone') !== FALSE || strpos($_SERVER[HTTP_USER_AGENT], 'iPod') !== FALSE) {
		//header('Location: http://www.google.com');
	}
	

?>
<!--DOCTYPE html-->
<html>
<head>
<title>Ramblin' Reck Club</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="css/reset.css" type="text/css">
<link rel="stylesheet" href="css/login.css" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Cabin|Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
<script>
		$(document).ready(function(){
			$(".register").hover(function(){
				$(this).text("Coming Soon!");
			});
			$('.register').mouseleave(function(){
				$(this).text("Register");
			});

		});
		</script>
<?php
	require "html_header_end.txt";
?>


<div id="login">
	<h1 class="line1">Ramblin'</h1>
	<h1 class="line2">Reck Club</h1>
	<h2 class="line3">Members & Alumni</h2>
	<form action="memberLogin.php" method="POST">
		<input type="text" maxlength="32" name="username" placeholder="username" onKeyPress="return letternumber(event)">
		<input type="password" maxlength="32" name="password" placeholder="password">
		<a class="register">Register</a>
		<input type="submit" value="Login">
	</form>
</div>

<?php require "html_footer.txt"; ?>
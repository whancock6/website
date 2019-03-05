<?php
	session_start();
	if (!isset($_SESSION[memberID])) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=memberLoginForm.php\">";
		die;
	} else {}
	
?>
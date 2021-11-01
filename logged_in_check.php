<?php
	session_start([
        'cookie_lifetime' => 259200,
    ]);
	if (!isset($_SESSION[memberID])) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=memberLoginForm.php\">";
		die;
	} else {}
	
?>
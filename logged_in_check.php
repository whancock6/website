<?php
	session_start([
        'cookie_lifetime' => 86400,
    ]);
	if (!isset($_SESSION[memberID])) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=memberLoginForm.php\">";
		die;
	} else {}
	
?>
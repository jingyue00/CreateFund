<?php
	session_start();
	session_destroy();
	unset($loginanme);
	header("Location:index.php");
    exit;
?>
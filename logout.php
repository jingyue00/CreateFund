<?php
	session_start();
	session_destroy();
	unset($loginanme);
	unset($_COOKIE["member_login"]);
	unset($_COOKIE["member_password"]);
	header("Location:index.php");
    exit;
?>
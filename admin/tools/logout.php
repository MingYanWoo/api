<?php
	session_start();
	session_destroy();
	unset($_SESSION);
	$url = '../login.php';
	header('Location:'.$url.'');
?>
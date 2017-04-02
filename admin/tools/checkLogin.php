<?php
	//验证登录状态
	session_start();
	if(empty($_SESSION['loginStatus']['status']) || !$_SESSION['loginStatus']['status']) {
		$url = "login.php"; 
		header('Location:'.$url.'');
	} else {
		//登录成功
	}
?>
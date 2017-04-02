<?php
/**
 * 添加管理员
 * 返回code:
 * 0:成功
 * 1:失败
 */
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$username = $_POST['username'];
$password = $_POST['password'];
$isAdmin = intval($_POST['isAdmin']);
$time = date('Y-m-d H:i:s', time());

if (empty($username) || empty($password)) {
    echo "<script>alert('用户名或密码为空')</script>";
}

$sql = "INSERT INTO `manager` (`username`, `password`, `is_admin`, `time`) VALUES ('".$username."', '".$password."', ".$isAdmin.", '".$time."');";
$result = DBConnector::getDB()->query($sql);
if ($result) {
	echo json_encode(['code' => 0]);
}else {
	echo json_encode(['code' => 1]);
}
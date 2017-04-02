<?php
/**
 * 检查用户名是否存在
 * 返回code：
 * 0:可以使用
 * 1:已存在
 * 2:参数为空
 */
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
//include "../tools/checkLogin.php";

$username = $_POST['username'];

if (empty($username)) {
	echo json_encode(['code' => 2]);
    exit();
}

$sql = "SELECT username FROM manager WHERE username='".$username."'";
$res = DBConnector::getDB()->fetchAll($sql);
if ($res) {
    echo json_encode(['code' => 1]);
    exit();
}else{
    echo json_encode(['code' => 0]);
    exit();
}
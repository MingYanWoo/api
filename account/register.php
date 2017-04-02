<?php

/**
 * 注册接口
 * 请求方式: POST
 * 请求参数
 * username: 用户名
 * password: 密码
 */

use MYDBConnect\DBConnector;

include "../tools/DBConnector.php";
include "../tools/JSONCommonFormat.php";

//检查请求方式
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(makeJSON(2, null, '请用POST请求'));
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

if (($_POST['username'] == null) || ($_POST['password'] == null)) {
    echo json_encode(makeJSON(1, null));
    exit();
}

//判断是否含有中文
if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $username)>0 || preg_match('/[\x{4e00}-\x{9fa5}]/u', $password)>0) {
    echo json_encode(makeJSON(1, null, '用户名或密码不能含有中文'));
    exit();
}

//判断字符串长度
if ((strlen($username) > 40) || (strlen($password) > 80)) {
    echo json_encode(makeJSON(1, null, '用户名或密码过长'));
    exit();
}

//检查用户名是否存在
if (!empty(DBConnector::getDB()->fetchAll("SELECT * FROM user WHERE username='".$username."'"))) {
    echo json_encode(makeJSON(3, null, '该用户名已存在'));
    exit();
}

$nickname = "热心网友".uniqid();
$createTime = date('Y-m-d H:i:s', time());
$token = md5($username.time());
//7天不登录token过期
$timeout = time()+604800;

$sql = "INSERT INTO `user` (`username`, `password`, `nickname`,`create_time`, `account_token`, `timeout`) 
VALUES ('".$username."', '".$password."', '".$nickname."', '".$createTime."', '".$token."', '".$timeout."')";

$result = DBConnector::getDB()->query($sql);
if ($result) {
    echo json_encode(makeJSON(0, null, '注册成功'));
    exit();
}else {
    echo json_encode(makeJSON(4, null, '注册失败'));
    exit();
}
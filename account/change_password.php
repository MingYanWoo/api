<?php

/**
 * 修改密码接口
 * 请求方式: POST
 * 请求参数
 * username: 用户名
 * old_password: 旧密码
 * new_password: 新密码
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
$oldPassword = $_POST['old_password'];
$newPassword = $_POST['new_password'];

if (($_POST['username'] == null) || ($_POST['old_password'] == null) || ($_POST['new_password'] == null)) {
    echo json_encode(makeJSON(1, null));
    exit();
}

//判断是否含有中文
if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $username)>0 || preg_match('/[\x{4e00}-\x{9fa5}]/u', $oldPassword)>0 || preg_match('/[\x{4e00}-\x{9fa5}]/u', $newPassword)>0) {
    echo json_encode(makeJSON(1, null, '用户名或密码不能含有中文'));
    exit();
}

//判断字符串长度
if ((strlen($username) > 40) || (strlen($newPassword) > 80)) {
    echo json_encode(makeJSON(1, null, '用户名或密码过长'));
    exit();
}

//检查用户名是否存在
if (empty(DBConnector::getDB()->fetchAll("SELECT * FROM user WHERE username='".$username."'"))) {
    echo json_encode(makeJSON(3, null, '该用户名不存在'));
    exit();
}

$sql = "SELECT * FROM user WHERE username='".$username."'";

$result = DBConnector::getDB()->fetchAll($sql);
if ($result[0]['password'] == $oldPassword) {
    //修改密码
    $updateSQL = "UPDATE `user` SET `password` = '".$newPassword."' WHERE `username` = '".$username."'";
    $update = DBConnector::getDB()->query($updateSQL);
    if (!$update) {
        echo json_encode(makeJSON(4, null));
        exit();
    }
    echo json_encode(makeJSON(0, null, '修改密码成功'));
    exit();
}else {
    echo json_encode(makeJSON(3, null, '旧密码错误'));
    exit();
}
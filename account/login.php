<?php

/**
 * 登录接口
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
if (empty(DBConnector::getDB()->fetchAll("SELECT * FROM user WHERE username='".$username."'"))) {
    echo json_encode(makeJSON(3, null, '该用户名不存在'));
    exit();
}

$sql = "SELECT * FROM user WHERE username='".$username."'";

$result = DBConnector::getDB()->fetchAll($sql);
if ($result[0]['password'] == $password) {

    //更新token和timeout
    $accountToken = md5($username.time());
    //timeout增加7天
    $timeout = time()+604800;

    $updateSQL = "UPDATE `user` SET `account_token` = '".$accountToken."', `timeout` = '".$timeout."' WHERE `username` = '".$username."'";
    $update = DBConnector::getDB()->query($updateSQL);
    if (!$update) {
        echo json_encode(makeJSON(4, null));
        exit();
    }

    $echoArray = [
        'user_id' => $result[0]['user_id'],
        'username' => $result[0]['username'],
        'nickname' => $result[0]['nickname'],
        'sex' => $result[0]['sex'],
        'birthday' => $result[0]['birthday'],
        'icon_url' => $result[0]['icon_url'],
        'account_token' => $accountToken,
    ];
    echo json_encode(makeJSON(0, $echoArray, '登录成功'));
    exit();
}else {
    echo json_encode(makeJSON(3, null, '密码错误'));
    exit();
}
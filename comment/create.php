<?php

/**
 * 发表评论接口
 * 请求方式: POST
 * 请求参数
 * user_id: 用户id
 * account_token: token
 * news_id: 新闻id
 * comment: 评论的内容
 */

use MYDBConnect\DBConnector;

include "../tools/DBConnector.php";
include "../tools/JSONCommonFormat.php";

//检查请求方式
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(makeJSON(2, null, '请用POST请求'));
    exit();
}

//检查参数
if ($_POST['user_id'] == null || $_POST['account_token'] == null || $_POST['news_id'] == null || $_POST['comment'] == null) {
    echo json_encode(makeJSON(1, null, '参数不全'));
    exit();
}

$userId = (int)$_POST['user_id'];
$account_token = $_POST['account_token'];
$newsId = (int)$_POST['news_id'];
$comment = $_POST['comment'];
$time = date('Y-m-d H:i:s', time());

//检查用户token
$result = DBConnector::getDB()->fetchAll("SELECT account_token FROM user WHERE user_id=".$userId);
if ($result[0]['account_token'] != $account_token) {
    echo json_encode(makeJSON(3, null, 'user_id或token错误'));
    exit();
}

//检查新闻id是否存在
if (!(DBConnector::getDB()->fetchAll("SELECT * FROM news WHERE news_id=".$newsId))) {
    echo json_encode(makeJSON(3, null, '该新闻不存在'));
    exit();
}

//添加评论
$sql = "INSERT INTO `comment` (`detail`, `comment_time`, `user_id`, `news_id`) VALUES ('".$comment."', '".$time."', '".$userId."', '".$newsId."')";
$insert = DBConnector::getDB()->query($sql);
if ($insert) {
    echo json_encode(makeJSON(0, null, '评论成功'));
    exit();
}else {
    echo json_encode(makeJSON(4, null));
    exit();
}
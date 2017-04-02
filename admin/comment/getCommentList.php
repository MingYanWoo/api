<?php
//查询评论列表
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$id = intval($_POST['id']);
$commentKeyword = $_POST['commentKeyword'];
$nicknameKeyword = $_POST['nicknameKeyword'];
$newsTitleKeyword = $_POST['newsTitleKeyword'];

//拼接SQL语句
$sql = "SELECT comment.*,user.nickname,news.title FROM comment,user,news WHERE comment.user_id=user.user_id AND comment.news_id=news.news_id";
if ($_POST['id'] != null) {
    $sql = $sql." and comment_id=".$id;
}
if (!empty($commentKeyword)) {
    $sql = $sql." and detail LIKE '%".$commentKeyword."%'";
}
if (!empty($nicknameKeyword)) {
    $sql = $sql." and user.nickname LIKE '%".$nicknameKeyword."%'";
}
if (!empty($newsTitleKeyword)) {
    $sql = $sql." and news.title LIKE '%".$newsTitleKeyword."%'";
}

$sql = $sql." order by time desc";

$resArr = DBConnector::getDB()->fetchAll($sql);

echo json_encode($resArr);
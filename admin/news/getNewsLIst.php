<?php
//查询新闻列表
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$id = intval($_POST['id']);
$titleKeyword = $_POST['titleKeyword'];
$srcKeyword = $_POST['srcKeyword'];
$newsType = intval($_POST['newsType']);

//拼接SQL语句
$sql = "SELECT * FROM news WHERE 1=1";
if (!empty($id)) {
    $sql = $sql." and news_id=".$id;
}
if (!empty($titleKeyword)) {
    $sql = $sql." and title LIKE '%".$titleKeyword."%'";
}
if (!empty($srcKeyword)) {
    $sql = $sql." and src LIKE '%".$srcKeyword."%'";
}
if ($newsType != -1 && ($_POST['newsType'] != null)) {
    $sql = $sql." and type=".$newsType;
}

$sql = $sql." order by time desc";

$resArr = DBConnector::getDB()->fetchAll($sql);

echo json_encode($resArr);
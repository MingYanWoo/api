<?php
//发布新闻
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$title = $_POST['title'];
$src = $_POST['src'];
$type = $_POST['type'];
$content = $_POST['content'];
$imgUrl = $_POST['photoUrl'];
$time = date('Y-m-d H:i:s', time());
$uniqID = uniqid();

$sql = "INSERT INTO `news` (`title`, `content`, `src`, `time`, `type`, `img_url`, `uniquekey`) 
VALUES ('".$title."', '".$content."', '".$src."', '".$time."', '".$type."', '".$imgUrl."', '".$uniqID."');";
$result = DBConnector::getDB()->query($sql);
if ($result) {
    $url = "../newNews.php"; 
	echo "<script>alert('发布成功');location.href='".$url."'</script>";
}else {
    $url = "../newNews.php"; 
	echo "<script>alert('发布失败');location.href='".$url."'</script>";
}
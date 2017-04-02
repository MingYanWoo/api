<?php
//查询用户列表
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$id = intval($_POST['id']);
$usernameKeyword = $_POST['usernameKeyword'];
$nicknameKeyword = $_POST['nicknameKeyword'];
$accountStatus = intval($_POST['accountStatus']);

//拼接SQL语句
$sql = "SELECT * FROM user WHERE 1=1";
if ($_POST['id'] != null) {
    $sql = $sql." and user_id=".$id;
}
if ($_POST['usernameKeyword'] != null) {
    $sql = $sql." and username LIKE '%".$usernameKeyword."%'";
}
if (!empty($nicknameKeyword)) {
    $sql = $sql." and nickname LIKE '%".$nicknameKeyword."%'";
}
if ($accountStatus != -1 && ($_POST['accountStatus'] != null)) {
    $sql = $sql." and account_status=".$accountStatus;
}

$sql = $sql." order by create_time desc";

$resArr = DBConnector::getDB()->fetchAll($sql);

echo json_encode($resArr);
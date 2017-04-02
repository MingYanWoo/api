<?php
//查询管理员列表
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$id = intval($_POST['id']);
$username = $_POST['username'];
$isAdmin = intval($_POST['isAdmin']);

//拼接SQL语句
$sql = "SELECT * FROM manager WHERE 1=1";
if (!empty($id)) {
    $sql = $sql." and manager_id=".$id;
}
if (!empty($username)) {
    $sql = $sql." and username LIKE '%".$username."%'";
}
if (($isAdmin != -1) && ($_POST['isAdmin'] != null)) {
    $sql = $sql." and is_admin=".$isAdmin;
}

$sql = $sql." order by time desc";

$resArr = DBConnector::getDB()->fetchAll($sql);

echo json_encode($resArr);
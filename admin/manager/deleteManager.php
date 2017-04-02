<?php
/**删除管理员
 * 返回code
 * 0:成功
 * 1:失败
 */
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$id = intval($_POST['id']);

if (empty($id)) {
	echo json_encode(['code' => 1, 'msg' => '参数错误']);;
	exit();
}
$isAdmin = DBConnector::getDB()->fetchAll("SELECT is_admin FROM manager WHERE manager_id=".$id);
if ($isAdmin[0]['is_admin'] == 1) {
    echo json_encode(['code' => 1, 'msg' => '不可删除超级管理员']);;
    exit();
}

$sql = "DELETE FROM manager WHERE manager_id=".$id;

$res = DBConnector::getDB()->query($sql);

if ($res) {
    echo json_encode(['code' => 0, 'msg' => '删除成功']);
    exit();
}else {
    echo json_encode(['code' => 1, 'msg' => '删除失败']);
    exit();
}
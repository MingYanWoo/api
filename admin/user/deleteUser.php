<?php
//删除用户
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$id = intval($_POST['id']);

if ($_POST['id'] == null) {
	echo "参数错误";
	exit();
}

$sql = "DELETE FROM user WHERE user_id=".$id;

$res = DBConnector::getDB()->query($sql);

if ($res) {
    $resArr = [
      'status' => '0',
    ];
    echo json_encode($resArr);
    exit();
}else {
    $resArr = [
        'status' => '1',
    ];
    echo json_encode($resArr);
    exit();
}
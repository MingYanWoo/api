<?php
//删除评论
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
include "../tools/checkLogin.php";

$id = intval($_POST['id']);

if (empty($id)) {
	echo "参数错误";
	exit();
}

$sql = "DELETE FROM comment WHERE comment_id=".$id;

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
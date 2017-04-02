<?php

/**
 * 获取新闻接口
 * 请求方式: GET/POST
 * 请求参数
 * type: 新闻类型。0（头条,默认），1（财经），2（科技），3（娱乐）
 * since_id: 若指定此参数，则返回ID比since_id大的新闻（即比since_id时间晚的新闻），默认为0
 * max_id: 若指定此参数，则返回ID小于max_id的新闻，默认为0
 * count: 返回的记录条数，最大不超过100，默认为20
 */

use MYDBConnect\DBConnector;

include "../tools/DBConnector.php";
include "../tools/JSONCommonFormat.php";

$type;
$sinceId;
$maxId;
$count;

//判断请求类型
if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_REQUEST['type'] ? $_REQUEST['type'] : 0;
    $sinceId = $_REQUEST['since_id'];
    $maxId = $_REQUEST['max_id'];
    $count = $_REQUEST['count'] ? $_REQUEST['count'] : 20;
    $count = $count > 100 ? 100 : $count;
}else {
    echo json_encode(makeJSON(2, null, '请使用GET或POST请求'));
}

if ($type>3 || $type<0) {
    echo json_encode(makeJSON(1, null));
    exit();
}

//maxId和sinceId同时指定，参数错误
if ($maxId && $sinceId) {
    echo json_encode(makeJSON(1, null));
    exit();
}

//返回比since_id大的数据
if ($sinceId) {
    $res = DBConnector::getDB()->fetchAll('SELECT * FROM news where news_id>'.$sinceId.' and type='.$type.' order by time desc limit '.$count);
    //返回的条数
    echo json_encode(makeJSON(0, getEchoArray($res)));
    exit();
}

//返回比max_id小的数据
if ($maxId) {
    $res = DBConnector::getDB()->fetchAll('SELECT * FROM news where news_id<'.$maxId.' and type='.$type.' order by time desc limit '.$count);
    echo json_encode(makeJSON(0, getEchoArray($res)));
    exit();
}

//default
$res = DBConnector::getDB()->fetchAll('SELECT * FROM news where type='.$type.' order by time desc limit '.$count);
echo json_encode(makeJSON(0, getEchoArray($res)));


//输出json数组的方法
function getEchoArray($result) {
    return $resArr = [
        'count' => count($result),
        'news' => $result,
    ];
}
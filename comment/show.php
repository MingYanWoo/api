<?php

/**
 * 获取评论接口
 * 请求方式: GET
 * 请求参数
 * news_id: 新闻id
 * since_id: 若指定此参数，则返回ID比since_id大的评论（即比since_id时间晚的评论），默认为0
 * max_id: 若指定此参数，则返回ID小于或等于max_id的评论，默认为0
 * count: 返回的记录条数，最大不超过100，默认为20
 */

use MYDBConnect\DBConnector;

include "../tools/DBConnector.php";
include "../tools/JSONCommonFormat.php";

//判断参数是否为空
if ($_REQUEST['news_id'] == null) {
    echo json_encode(makeJSON(1, null));
    exit();
}

$newsId = $_REQUEST['news_id'];
$sinceId = $_REQUEST['since_id'];
$maxId = $_REQUEST['max_id'];
$count = $_REQUEST['count'] ? $_REQUEST['count'] : 20;
$count = $count > 100 ? 100 : $count;

//maxId和sinceId同时指定，参数错误
if ($maxId && $sinceId) {
    echo json_encode(makeJSON(1, null));
    exit();
}

//返回比since_id大的数据
if ($sinceId) {
    $res = DBConnector::getDB()->fetchAll('SELECT comment.*,user.nickname,user.icon_url FROM comment,user WHERE comment_id>'.$sinceId.' AND news_id='.$newsId.' AND comment.user_id=user.user_id order by comment_time desc limit '.$count);
    //返回的条数
    echo json_encode(makeJSON(0, getEchoArray($res)));
    exit();
}

//返回比max_id小的数据
if ($maxId) {
    $res = DBConnector::getDB()->fetchAll('SELECT comment.*,user.nickname,user.icon_url FROM comment,user WHERE comment_id<'.$maxId.' AND news_id='.$newsId.' AND comment.user_id=user.user_id order by comment_time desc limit '.$count);
    echo json_encode(makeJSON(0, getEchoArray($res)));
    exit();
}

//default
$res = DBConnector::getDB()->fetchAll('SELECT comment.*,user.nickname,user.icon_url FROM comment,user WHERE news_id='.$newsId.' AND comment.user_id=user.user_id order by comment_time desc limit '.$count);
echo json_encode(makeJSON(0, getEchoArray($res)));


//输出json数组的方法
function getEchoArray($result) {
    return $resArr = [
        'count' => count($result),
        'comment' => $result,
    ];
}
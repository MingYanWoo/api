<?php
//简单路由转发

include "tools/JSONCommonFormat.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(makeJSON(2, null, '请使用POST请求'));
    exit();
}

if (getallheaders()['code'] == null) {
    echo json_encode(makeJSON(1, null, '请求码为空'));
    exit();
}
$code = getallheaders()['code'];
$url = $_SERVER['HTTP_HOST']."/api/";

switch ($code) {

/*---------------------------------------------------------------*/

    //新闻
    case 'NewsTimeline':
        $url = $url.'news/timeline.php';
        break;

/*---------------------------------------------------------------*/

    //账户
    case 'AccountLogin':
        $url = $url.'account/login.php';
        break;
    case 'AccountRegister':
        $url = $url.'account/register.php';
        break;
    case 'AccountChangePassword':
        $url = $url.'account/change_password.php';
        break;

/*---------------------------------------------------------------*/

    //评论
    case 'ShowComment':
        $url = $url.'comment/show.php';
        break;
    case 'CreateComment':
        $url = $url.'comment/create.php';
        break;

/*---------------------------------------------------------------*/

    //默认请求码错误
    default:
        echo json_encode(makeJSON(1, null, '请求码错误'));
        exit();
}


$post_data = $_REQUEST;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
curl_setopt($ch, CURLOPT_POST, 1);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close($ch);
//打印获得的数据
echo $output;

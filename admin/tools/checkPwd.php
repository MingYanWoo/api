<?php
use MYDBConnect\DBConnector;

include "../../tools/DBConnector.php";
$username=$_POST["username"];
$password=$_POST["password"];

if (($username == "") || ($password == "")) {
    $url = "../login.php";
    echo "<script>alert('用户名或密码不能为空！');location.href='".$url."'</script>";
    exit();
}

//查询验证密码
$sql = "select * from manager where username='".$username."';";
$resArr = DBConnector::getDB()->fetchAll($sql);

if($resArr[0]['password'] == $password && !empty($resArr[0]['password'])){
    session_start();
    $_SESSION['loginStatus'] = array(
        'username' => $username,
        'status' => true,
        'loginTime' => time(),
        'isAdmin' => $resArr[0]['is_admin'],
    );
    $url = "../index.php";
    header('Location:'.$url.'');
}else{
    $url = "../login.php";
    echo "<script>alert('用户名或密码错误');location.href='".$url."'</script>";
    exit();
}

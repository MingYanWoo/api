<?php

/**
 * 状态码说明：
 * 0：成功
 * 1：参数错误
 * 2：请求方式错误
 * 3：资源不存在
 * 4：服务器错误
 */

//返回JSON的通用格式
/**
 * @param $code 状态码
 * @param $data 数据主体
 * @param $msg  信息（不填即默认）
 * @return array
 */
function makeJSON($code, $data, $msg) {
    switch ($code){
        case 0:
            $result =  [
                "code" => $code,
                "data" => $data,
                "msg" => $msg ? $msg : "成功",
            ];
            return $result;
        case 1:
            $result =  [
                "code" => $code,
                "data" => $data,
                "msg" => $msg ? $msg : "参数错误",
            ];
            return $result;
        case 2:
            $result =  [
                "code" => $code,
                "data" => $data,
                "msg" => $msg ? $msg : "请求方式错误",
            ];
            return $result;
        case 3:
            $result =  [
                "code" => $code,
                "data" => $data,
                "msg" => $msg ? $msg : "资源不存在",
            ];
            return $result;
        case 4:
            $result =  [
                "code" => $code,
                "data" => $data,
                "msg" => $msg ? $msg : "服务器错误",
            ];
            return $result;
    }
}
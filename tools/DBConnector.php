<?php

namespace MYDBConnect;

/** MySQL主机 */
const DB_HOST = 'localhost';
/** MySQL数据库用户名 */
const DB_USER = 'root';
/** MySQL数据库密码 */
const DB_PASSWORD = '123456';
/** MySQL数据库名称 */
const DB_NAME = 'MyNewsDB';


class DBConnector
{
    private static $obj;
    private $db_host;
    private $db_username;
    private $db_password;
    private $db_name;
    private $con;

    /**
     * 查询结果集
     * @return 结果集数组
     */
    function fetchAll($sql) {
        $result = mysqli_query($this->con, $sql);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $resultArray;
    }

    /**
     * 用于执行除查询以外的操作
     * @return TRUE or FALSE
     */
    function query($sql) {
        return mysqli_query($this->con, $sql);
    }

/**--------------------------------------------------------------------------*/

    /**
     * DBConnector 构造函数.
     */
    private function __construct() {
        $this->db_host = DB_HOST;
        $this->db_username = DB_USER;
        $this->db_password = DB_PASSWORD;
        $this->db_name = DB_NAME;
        $this->con = $this->connect();
    }

    /**
     * 用于实例化,返回本类对象
     * @return DBConnector
     */
    static function getDB() {
        if (is_null(self::$obj)) {
            self::$obj = new self();
        }
        return self::$obj;
    }

    /**
     * 建立数据库连接
     * @return mysqli ,连接成功后的资源
     */
    private function connect() {
        $connect = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name);
        //设置编码
        mysqli_set_charset($connect, 'utf8');
        //保持数据库取出时的数据类型
        mysqli_options($connect,MYSQLI_OPT_INT_AND_FLOAT_NATIVE,true);
        return $connect;
    }

    /**
     * 关闭数据库连接
     */
    function __destruct() {
        mysqli_close($this->connect());
    }

}
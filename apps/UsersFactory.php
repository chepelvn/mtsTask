<?php

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 21.05.2020
 * Time: 22:04
 */
class UsersFactory
{
    const DB = 'users';

    /**
     * @var $_connect PDO
     */
    static $_connect;

    /**
     * @return PDO
     */
    static protected function DB(){
        if(!(self::$_connect instanceof PDO)){
            $userName = config('mysql.user');
            $password = config('mysql.pass');
            $host =     config('mysql.host');
            $dataBase = config('mysql.db');
            $dsn = "mysql:dbname=$dataBase;host=$host";
            self::$_connect = new \PDO($dsn, $userName, $password);
        }
        return self::$_connect;
    }
}
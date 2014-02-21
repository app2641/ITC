<?php


namespace ITC\App\Utility\Database;

use ITC\App\Utility\Registry;
use ITC\App\Utility\Database\Database;

class Helper
{


    /**
     * データベース接続を行う
     *
     * @param String $connection  database.iniの区画
     * @return Database
     **/
    public static function connection ($connection = 'default')
    {
        // Registryに登録され、コネクションも同じ場合
        if (Registry::getInstance()->ifKeyExists('db')) {
            $db = Registry::get('db');

        } else {
            $database_ini_path = ROOT_PATH.'/data/config/database.ini';
            $ini = parse_ini_file($database_ini_path, true);

            if (! isset($ini[$connection])) {
                throw new \Exception('Databaseの指定が間違っています！');
            }

            $params = $ini[$connection];
            $dsn    = sprintf('mysql:dbname=%s;host=%s', $params['database'], $params['host']);
            $db = new Database($dsn, $params['user'], $params['password'], $connection);
            $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}


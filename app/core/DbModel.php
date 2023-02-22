<?php 

namespace app\core;

use app\core\Database;

abstract class DbModel extends Model
{
    protected static $db;
    
    protected static function db() {
        if (self::$db === null) {
            self::$db = new Database(config('db'));
        }
        return self::$db;
    }

    public static function getOneById($table, $id) {
        return self::getOne($table, 'id', $id);
    }

    public static function getOne($table, $field, $value) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $field . " = :value";
        $params = [':value' => $value];
        $result = self::db()->query($sql, $params);
        return $result->fetch();
    }

    public static function getAll($table, $where = []) {
        if (count($where) > 0) {
            foreach ($where as $key => $value) {
                $whereSqlElements[] = $key . " = :" . $key;
                $params[":" . $key] = $value;
            }
            $whereSql = " WHERE " . implode(" AND ", $whereSqlElements);
        }
        $sql = "SELECT * FROM " . $table . ($whereSql ?? "");
        $result = self::db()->query($sql, $params ?? []);
        
        return $result->fetchAll();
    }

    public static function insert($table, $data) {
        $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($data)) . ") VALUES (:" . implode(", :", array_keys($data)) . ")";
        $params = [];
        foreach ($data as $key => $value) {
            $params[":" . $key] = $value;
        }
        self::db()->query($sql, $params);

        return self::db()->lastInsertId();
    }


    public static function insertMany($table, $data) {
        $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($data[0])) . ") VALUES (:" . implode(", :", array_keys($data[0])) . ")";
        $params = [];
        foreach ($data as $value) {
            foreach ($value as $key => $val) {
                $params[":" . $key] = $val;
            }
            self::db()->query($sql, $params);
        }

    }
    
}
<?php 

namespace app\models;

use app\core\DbModel;

class Ajax extends DbModel
{

    public static function stars($id,$rate) : string
    {
        $id = (int)$id;
        $rate = (int)$rate;

        if ($id < 1 || $rate < 1 || $rate > 5) {
            header("HTTP/1.1 400 Bad Request");
            exit;
        }

        $sql = 'UPDATE persons SET stars = :rate WHERE id = :id';
        $params = [
            ':id' => $id,
            ':rate' => $rate
        ];
        $result = self::db()->query($sql,$params);
        

        if ($result->rowCount() === 1) {
            $data['status'] = 'success';         
        } else {
            header("HTTP/1.1 400 Bad Request");
            exit;
        }
        
        return json_encode($data);
    }

}
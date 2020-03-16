<?php
namespace app\component;

use yii\db\Query;
use yii\web\UploadedFile;
use app\models\User;

class Helpers
{
    public static function getBase64Image($file)
    {
        if($file) {
            $data = file_get_contents($file->tempName);
            $result = 'data:image/'.$file->extension.';base64,'.base64_encode($data);
        } else {
            $result = null;
        }

        return $result;
    }

    public static function getIdChild($parent_id)
    {
//         "select distinct u4.id from user u1
//    left join (select id,username,parent_id from user) u2 on u2.parent_id=u1.id 
//    left join (select id,username,parent_id from user) u3 on u3.parent_id=u2.id
//    left join (select id,username,parent_id from user) u4 on u4.parent_id=u3.id or u4.id=u3.id or u4.id=u2.id or u4.id=u1.id
//    where u1.id=4"
        $connection = \Yii::$app->db;

        $script = "select distinct u4.id from user u1 
            left join (select id,username,parent_id from user) u2 on u2.parent_id=u1.id 
            left join (select id,username,parent_id from user) u3 on u3.parent_id=u2.id 
            left join (select id,username,parent_id from user) u4 on u4.parent_id=u3.id or u4.id=u3.id or u4.id=u2.id or u4.id=u1.id
            where u1.id=$parent_id
        ";

        $child = $connection->createCommand($script)->queryColumn();
        
        return $child;
        
    }
}
<?php

namespace app\modules\api\v1\models;

use Yii;
use \app\models\Tema;
use \app\models\Topik;

class Helpers extends \yii\db\ActiveRecord
{
    static function getOpsi()
    {
        $models = Tema::find()->select('id,nama_tema,flag')->where(['status' => 10])->groupBy(['flag'])->all();
        
        return $models;
    }

    static function getTema($flag)
    {
        $models = Tema::find()->select('id,nama_tema')->where(['status' => 10, 'flag' => $flag])->all();
        
        return $models;
    }

    static function getTopik()
    {
        $models = Topik::find()->select('id,nama_topik')->where(['status' => 10])->all();
        
        return $models;
    }

    static function getTopikByTema($tema_id)
    {
        $models = Topik::find()->select('id,nama_topik')->where(['status' => 10, 'tema_id' => $tema_id])->all();
        
        return $models;
    }

    static function getTemaTopik()
    {
        $opsi = static::getOpsi();
        // var_dump($opsi);die();

        if(count($opsi) != 0) {
            $opsi_info = static::getTema(1);
            $opsi_masalah = static::getTema(2);

            if(count($opsi_info) != 0) {
                foreach($opsi_info as $val_info) {
                    $result_info[] = [
                        'id_tema' => $val_info->id,
                        'nama_tema' => $val_info->nama_tema,
                        'topik' => static::getTopikByTema($val_info->id)
                    ];
                }
            }

            if(count($opsi_masalah) != 0) {
                foreach($opsi_masalah as $val_masalah) {
                    $result_masalah[] = [
                        'id_tema' => $val_masalah->id,
                        'nama_tema' => $val_masalah->nama_tema,
                        'topik' => static::getTopikByTema($val_masalah->id)
                    ];
                }
            }

            $result = [
                'penyebaran_info' => $result_info,
                'konsolidasi_masalah' => $result_masalah
            ];
        } else {
            $result = null;
        }

        // if(count(static::getTema()) != 0) {
        //     foreach(static::getTema() as $val) {
        //         $result[] = [
        //             'id_tema' => $val->id,
        //             'nama_tema' => $val->nama_tema,
        //             'topik' => static::getTopikByTema($val->id)
        //         ];
        //     }
        // } else {
        //     $result = null;
        // }

        return $result;
    }
}
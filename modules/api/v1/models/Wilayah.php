<?php

namespace app\modules\api\v1\models;

use Yii;
use \app\models\Provinsi;
use \app\models\Kabupatenkota;
use \app\models\Kecamatan;

class Wilayah extends \yii\db\ActiveRecord
{
    static function getProvinsi()
    {
        $models = Provinsi::find()->all();
        return $models;
    }

    static function getKabupatenkotaByProvinsi($provinsi_id)
    {
        $models = Kabupatenkota::find()->where(['provinsi_id' => $provinsi_id])->all();

        if(count($models) != 0) {
            foreach($models as $val) {
                $result[] = [
                    'id_kabkota' => $val->id,
                    'nama_kabkota' => $val->nama_kabkota,
                    'kecamatan' => static::getKecamatanByKabupatenkota($val->id)
                ];
            }
        } else {
            $result = null;
        }
        return $result;
    }

    static function getKecamatanByKabupatenkota($kabkota_id)
    {
        $models = Kecamatan::find()->where(['kabkota_id' => $kabkota_id])->all();
        if(count($models) != 0) {
            foreach($models as $val) {
                $result[] = [
                    'id_kecamatan' => $val->id,
                    'nama_kecamatan' => $val->nama_kecamatan
                ];
            }
        } else {
            $result = null;
        }
        return $result;
    }
    

    static function getLocationNested()
    {
        $prov = static::getProvinsi();

        if(count($prov) != 0) {
            foreach($prov as $val) {
                $result[] = [
                    'id_provinsi' => $val->id,
                    'nama_provinsi' => $val->nama_provinsi,
                    'kabupatenkota' => static::getKabupatenkotaByProvinsi($val->id)
                ];
            }
        } else {
            $result = null;
        }
        
        return $result;
    }
}
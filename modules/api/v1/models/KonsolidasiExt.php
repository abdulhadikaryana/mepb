<?php

namespace app\modules\api\v1\models;

use Yii;

class KonsolidasiExt extends \app\models\Konsolidasi
{
    static function getAllKonsolidasi()
    {
        $models = \app\models\Konsolidasi::find()->createByUser()->all();
        
        if(count($models) > 0) {
            foreach ($models as $model) {
                $prov = \app\models\Provinsi::findOne(['nama_provinsi' => $model->provinsi]);
                $kab = \app\models\Kabupatenkota::findOne(['nama_kabkota' => $model->kabupatenkota]);
                $kec = \app\models\Kecamatan::findOne(['nama_kecamatan' => $model->kecamatan]);

                $data[] = [
                    'id' => $model->id,
                    'uuid' => $model->uuid,
                    'tanggal_entri' => $model->tanggal_entri,
                    'lokasi' => $model->lokasi,
                    'desakel' => $model->desakel,
                    'provinsi' => $model->provinsi,
                    'provinsi_id' => $prov ? $prov->id : null,
                    'kabupatenkota' => $model->kabupatenkota,
                    'kabupatenkota_id' => $kab ? $kab->id : null,
                    'kecamatan' => $model->kecamatan,
                    'kecamatan_id' => $kec ? $kec->id : null,
                    'metode' => $model->metode,
                    'sub_metode' => $model->sub_metode,
                    'deskripsi' => $model->deskripsi,
                    'solusi' => $model->solusi,
                    'foto1' => $model->foto1,
                    'foto2' => $model->foto2,
                    'foto3' => $model->foto3,
                    'latitude' => $model->latitude,
                    'longitude' => $model->longitude
                ];
            }
        } else {
            $data = null;
        }
        
        return $data;
    }
}
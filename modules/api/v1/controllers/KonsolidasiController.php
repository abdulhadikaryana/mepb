<?php

namespace app\modules\api\v1\controllers;

use Yii;
use app\modules\api\v1\models\KonsolidasiExt;

class KonsolidasiController extends \yii\rest\Controller
{
    protected function verbs()
    {

        return [
            'create' => ['POST'],
            'index' => ['GET'],
        ];

    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \app\component\CustomAuth::className(),
            'tokenParam' => 'X-Auth-Token',
            'except' => ['options']
        ];
        
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'PATCH'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
            ]
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $data = KonsolidasiExt::getAllKonsolidasi();

        if(isset($data) > 0) {
            $response = [
                'status' => 'ok',
                'message' => 'data return',
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'no data return',
                'data' => ''
            ];
        }
        
        return $response;
    }

    public function actionCreate()
    {
        $model = new KonsolidasiExt;
        $request = Yii::$app->request;

        if (isset($request)) {
            $model->uuid = $request->post('uuid');
            $model->tanggal_entri = $request->post('tanggal_entri');
            $model->lokasi = $request->post('lokasi');
            $model->desakel = $request->post('desakel');
            $model->kecamatan = $request->post('kecamatan');
            $model->kabupatenkota = $request->post('kabupatenkota');
            $model->provinsi = $request->post('provinsi');
            $model->metode = $request->post('metode');
            $model->sub_metode = $request->post('sub_metode');
            $model->deskripsi = $request->post('deskripsi');
            $model->solusi = $request->post('solusi');
            $model->foto1 = $request->post('foto1');
            $model->foto2 = $request->post('foto2');
            $model->foto3 = $request->post('foto3');
            $model->latitude = $request->post('latitude');
            $model->longitude = $request->post('longitude');

            $modelCheck = KonsolidasiExt::find()->where(['uuid' => $model->uuid])->one();
            if($modelCheck == null) {
                if($model->save()){
                    $prov = \app\models\Provinsi::findOne(['nama_provinsi' => $model->provinsi]);
                    $kab = \app\models\Kabupatenkota::findOne(['nama_kabkota' => $model->kabupatenkota]);
                    $kec = \app\models\Kecamatan::findOne(['nama_kecamatan' => $model->kecamatan]);

                    $response = [
                        'status' => 'ok',
                        'message' => 'data berhasil disimpan',
                        'data' => [
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
                        ]
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'ada kesalahan ketika menyimpan data',
                        'data' => ''
                    ];
                }
            } else {
                if($modelCheck->save()){
                    $prov = \app\models\Provinsi::findOne(['nama_provinsi' => $model->provinsi]);
                    $kab = \app\models\Kabupatenkota::findOne(['nama_kabkota' => $model->kabupatenkota]);
                    $kec = \app\models\Kecamatan::findOne(['nama_kecamatan' => $model->kecamatan]);

                    $response = [
                        'status' => 'ok',
                        'message' => 'data berhasil diupdate',
                        'data' => [
                            'id' => $modelCheck->id,
                            'uuid' => $modelCheck->uuid,
                            'tanggal_entri' => $modelCheck->tanggal_entri,
                            'lokasi' => $modelCheck->lokasi,
                            'desakel' => $modelCheck->desakel,
                            'provinsi' => $modelCheck->provinsi,
                            'provinsi_id' => $prov ? $prov->id : null,
                            'kabupatenkota' => $modelCheck->kabupatenkota,
                            'kabupatenkota_id' => $kab ? $kab->id : null,
                            'kecamatan' => $modelCheck->kecamatan,
                            'kecamatan_id' => $kec ? $kec->id : null,
                            'metode' => $modelCheck->metode,
                            'sub_metode' => $modelCheck->sub_metode,
                            'deskripsi' => $modelCheck->deskripsi,
                            'solusi' => $modelCheck->solusi,
                            'foto1' => $modelCheck->foto1,
                            'foto2' => $modelCheck->foto2,
                            'foto3' => $modelCheck->foto3,
                            'latitude' => $modelCheck->latitude,
                            'longitude' => $modelCheck->longitude
                        ]
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'ada kesalahan ketika menyimpan data',
                        'data' => ''
                    ];
                }
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'form harus diisi',
                'data' => ''
            ];
        }

        return $response;
    }

}
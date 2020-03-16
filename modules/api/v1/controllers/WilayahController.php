<?php

namespace app\modules\api\v1\controllers;

use Yii;
use app\models\Provinsi;
use app\models\Kabupatenkota;
use app\models\Kecamatan;
use app\modules\api\v1\models\Wilayah;

class WilayahController extends \yii\rest\Controller
{
    protected function verbs()
    {

        return [
            'index' => ['GET'],
            'kecamatan' => ['GET'],
            'kabupatenkota' => ['GET'],
            'provinsi' => ['GET']
        ];

    }

    public function actionIndex()
    {
        $data = Wilayah::getLocationNested();

        if(count($data) > 0) {
            $response = [
                'status' => 'ok',
                'message' => 'data return',
                'data' => $data
            ];    
        } else {
            $response = [
                'status' => 'error',
                'message' => ' no data return',
                'data' => ''
            ];
        }
        
        return $response;
    }

    public function actionKecamatan()
    {
        $request = Yii::$app->request;
        $kabkota_id = $request->post('kabkota_id');
        $model = \app\models\Kecamatan::find()->where(['kabkota_id' => $kabkota_id])->all();

        if(count($model) != 0) {
            $response = [
                'status' => 'ok',
                'message' => 'data return',
                'data' => $model,
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

    public function actionKabupatenkota()
    {
        $request = Yii::$app->request;
        $provinsi_id = $request->get('provinsi_id');
        $model = \app\models\Kabupatenkota::find()->where(['provinsi_id' => $provinsi_id])->all();

        if(count($model) != 0) {
            $response = [
                'status' => 'ok',
                'message' => 'data return',
                'data' => $model,
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

    public function actionProvinsi()
    {
        $model = \app\models\Provinsi::find()->all();

        if(count($model) != 0) {
            $response = [
                'status' => 'ok',
                'message' => 'data return',
                'data' => $model,
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

}
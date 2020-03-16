<?php

namespace app\modules\api\v1\controllers;

use Yii;
use app\modules\api\v1\models\Helpers;

class StatistikController extends \yii\rest\Controller
{
    protected function verbs()
    {

        return [
            'index' => ['GET'],
            'penyebarluasan' => ['GET'],
            'konsolidasi' => ['GET'],
            'pendataan' => ['GET'],
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
                'Access-Control-Request-Method' => ['GET'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
            ]
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return;
    }

    public function actionPenyebarluasan()
    {
        $today = date('Y-m-d');
        
        $count_today = \app\models\Penyebarluasan::find()->createByUser()
                ->andWhere(['DATE(tanggal_entri)' => $today])
                ->count();

        $count_month = \app\models\Penyebarluasan::find()->createByUser()
                ->andWhere(['YEAR(tanggal_entri)' => date('Y')])
                ->andWhere(['MONTH(tanggal_entri)' => date('m')])
                ->count();

        $count_all = \app\models\Penyebarluasan::find()->createByUser()
                ->count();

        $response = [
            'status' => 'ok',
            'message' => 'data return',
            'data' => [
                'tanggal' => date('d-m-Y'),
                'today_count' => (int)$count_today,
                'month_count' => (int)$count_month,
                'total' => (int)$count_all
            ]
        ];
        
        return $response;
    }

    public function actionKonsolidasi()
    {
        $today = date('Y-m-d');
        
        $count_today = \app\models\Konsolidasi::find()->createByUser()
                ->andWhere(['DATE(tanggal_entri)' => $today])
                ->count();

        $count_month = \app\models\Konsolidasi::find()->createByUser()
                ->andWhere(['YEAR(tanggal_entri)' => date('Y')])
                ->andWhere(['MONTH(tanggal_entri)' => date('m')])
                ->count();

        $count_all = \app\models\Konsolidasi::find()->createByUser()
                ->count();

        $response = [
            'status' => 'ok',
            'message' => 'data return',
            'data' => [
                'tanggal' => date('d-m-Y'),
                'today_count' => (int)$count_today,
                'month_count' => (int)$count_month,
                'total' => (int)$count_all
            ]
        ];

        return $response;
    }

    public function actionPendataan()
    {
        $today = date('Y-m-d');
        
        $count_today = \app\models\Pendataan::find()->createByUser()
                ->andWhere(['DATE(tanggal_entri)' => $today])
                ->count();

        $count_month = \app\models\Pendataan::find()->createByUser()
                ->andWhere(['YEAR(tanggal_entri)' => date('Y')])
                ->andWhere(['MONTH(tanggal_entri)' => date('m')])
                ->count();

        $count_all = \app\models\Pendataan::find()->createByUser()
                ->count();

        $response = [
            'status' => 'ok',
            'message' => 'data return',
            'data' => [
                'tanggal' => date('d-m-Y'),
                'today_count' => (int)$count_today,
                'month_count' => (int)$count_month,
                'total' => (int)$count_all
            ]
        ];

        return $response;
    }
}
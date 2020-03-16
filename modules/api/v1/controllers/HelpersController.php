<?php

namespace app\modules\api\v1\controllers;

use Yii;
use app\modules\api\v1\models\Helpers;

class HelpersController extends \yii\rest\Controller
{
    protected function verbs()
    {

        return [
            'microtime' => ['GET'],
            'tema' => ['GET'],
            'topik' => ['GET'],
            'tema-topik' => ['GET'],
            'check-uuid-penyebarluasan' => ['GET'],
            'check-uuid-konsolidasi' => ['GET'],
        ];

    }

    public function actionMicrotime()
    {
        return microtime(true);
    }

    public function actionTema()
    {
        $data = Helpers::getTema();

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

    public function actionTopik()
    {
        $data = Helpers::getTopik();

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

    public function actionTemaTopik()
    {
        $data = Helpers::getTemaTopik();

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

    public function actionCheckUuidPenyebarluasan($uuid)
    {
        $model = \app\models\Penyebarluasan::findOne(['uuid' => $uuid]);

        if(!empty($model)) {
            return true;
        } else {
            return false;
        }
    }

    public function actionCheckUuidKonsolidasi($uuid)
    {
        $model = \app\models\Konsolidasi::findOne(['uuid' => $uuid]);

        if(!empty($model)) {
            return true;
        } else {
            return false;
        }
    }

}
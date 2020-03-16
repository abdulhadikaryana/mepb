<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;

class LocationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionKabupatenkota()
    {
        $out = [];
        if(isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if($parents != null) {
                $province_id = $parents[0];

                $data = self::getKotakab($province_id);
                echo Json::encode(['output'=>$data['out'], 'selected'=>'']);

                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionKecamatan()
    {
        $out = [];
        if(isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if($parents != null) {
                $kabkota_id = $parents[0];

                $data = self::getKecamatan($kabkota_id);
                echo Json::encode(['output'=>$data['out'], 'selected'=>'']);

                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function getKotakab($provinsi_id)
    {
      $data = \app\models\Kabupatenkota::find()->where(['provinsi_id' => $provinsi_id])->all();

      foreach($data as $key => $value) {
          $mapping['out'][] = ['id' => $value->id, 'name' => $value->nama_kabkota];
      }
      return $mapping;
    }

    public function getKecamatan($kabkota_id)
    {
      $data = \app\models\Kecamatan::find()->where(['kabkota_id' => $kabkota_id])->all();

      foreach($data as $key => $value) {
          $mapping['out'][] = ['id' => $value->id, 'name' => $value->nama_kecamatan];
      }
      return $mapping;
    }

    public function actionOpsi()
    {
        $out = [];
        if(isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if($parents != null) {
                $tema_id = $parents[0];

                $data = self::getOpsi($tema_id);
                echo Json::encode(['output'=>$data['out'], 'selected'=>'']);

                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function getOpsi($tema_id)
    {
      $data = \app\models\Topik::find()->where(['tema_id' => $tema_id])->all();

      foreach($data as $key => $value) {
          $mapping['out'][] = ['id' => $value->id, 'name' => $value->nama_topik];
      }
      return $mapping;
    }
}
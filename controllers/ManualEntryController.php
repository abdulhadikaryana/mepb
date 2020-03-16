<?php

namespace app\controllers;

use Yii;
use app\models\base\BasePenyebarluasan;
use app\models\base\BaseKonsolidasi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use yii\web\UploadedFile;

/**
 * PenyerbarluasanController implements the CRUD actions for Penyebarluasan model.
 */
class ManualEntryController extends Controller
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

    public function actionPenyebarluasan()
    {
        $model = new BasePenyebarluasan();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->tanggal_entri = date('Y-m-d H:m:s', strtotime($model->tanggal_entri));

            $provinsi = \app\models\Provinsi::findOne($model->provinsi);
            $kabupatenkota = \app\models\Kabupatenkota::findOne($model->kabupatenkota);
            $kecamatan = \app\models\Kecamatan::findOne($model->kecamatan);
            $tema = \app\models\Tema::findOne($model->tema);
            $topik = \app\models\Topik::findOne($model->topik);

            $model->provinsi = $provinsi->nama_provinsi;
            $model->kabupatenkota = $kabupatenkota->nama_kabkota;
            $model->kecamatan = $kecamatan->nama_kecamatan;
            $model->tema = $tema->nama_tema;
            $model->topik = $topik->nama_topik;
            $model->uuid = \Yii::$app->user->identity->username . '-' . time();

            $file1 = UploadedFile::getInstance($model, 'foto1');
            $file2 = UploadedFile::getInstance($model, 'foto2');
            $file3 = UploadedFile::getInstance($model, 'foto3');
        
            if(!empty($file1)) {
                $newWidth = 2000;
                $newHeight = 2000;
                $savePath = Yii::getAlias('@webroot/images/tempimages/'.Yii::$app->security->generateRandomString().'_'.$file1->name);
                Image::getImagine()->open($file1->tempName)->thumbnail(new Box($newWidth, $newHeight))->save($savePath , ['quality' => 90]);
                
                $data = file_get_contents($savePath);
                $model->foto1 = 'data:image/'.$file1->extension.';base64,'.base64_encode($data);
                unlink($savePath);
            }
            if(!empty($file2)) {
                $newWidth = 2000;
                $newHeight = 2000;
                $savePath = Yii::getAlias('@webroot/images/tempimages/'.Yii::$app->security->generateRandomString().'_'.$file2->name);
                Image::getImagine()->open($file2->tempName)->thumbnail(new Box($newWidth, $newHeight))->save($savePath , ['quality' => 90]);
                
                $data = file_get_contents($savePath);
                $model->foto2 = 'data:image/'.$file2->extension.';base64,'.base64_encode($data);
                unlink($savePath);
            }
            if(!empty($file3)) {
                $newWidth = 2000;
                $newHeight = 2000;
                $savePath = Yii::getAlias('@webroot/images/tempimages/'.Yii::$app->security->generateRandomString().'_'.$file3->name);
                Image::getImagine()->open($file3->tempName)->thumbnail(new Box($newWidth, $newHeight))->save($savePath , ['quality' => 90]);
                
                $data = file_get_contents($savePath);
                $model->foto3 = 'data:image/'.$file3->extension.';base64,'.base64_encode($data);
                unlink($savePath);
            }

            if($model->save(false)) {
                return $this->redirect(['/penyebarluasan/view', 'id' => $model->id]);
            }
        } else {
            return $this->render('penyebarluasan', [
                'model' => $model,
            ]);
        }
    }

    public function actionKonsolidasi()
    {
        $model = new BaseKonsolidasi();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->tanggal_entri = date('Y-m-d H:m:s', strtotime($model->tanggal_entri));
            
            $provinsi = \app\models\Provinsi::findOne($model->provinsi);
            $kabupatenkota = \app\models\Kabupatenkota::findOne($model->kabupatenkota);
            $kecamatan = \app\models\Kecamatan::findOne($model->kecamatan);
            $tema = \app\models\Tema::findOne($model->metode);
            $topik = \app\models\Topik::findOne($model->sub_metode);

            $model->provinsi = $provinsi->nama_provinsi;
            $model->kabupatenkota = $kabupatenkota->nama_kabkota;
            $model->kecamatan = $kecamatan->nama_kecamatan;
            $model->metode = $tema->nama_tema;
            $model->sub_metode = $topik ? $topik->nama_topik : null;
            $model->uuid = \Yii::$app->user->identity->username . '-' . time();

            $file1 = UploadedFile::getInstance($model, 'foto1');
            $file2 = UploadedFile::getInstance($model, 'foto2');
            $file3 = UploadedFile::getInstance($model, 'foto3');
        
            if(!empty($file1)) {
                $newWidth = 2000;
                $newHeight = 2000;
                $savePath = Yii::getAlias('@webroot/images/tempimages/'.Yii::$app->security->generateRandomString().'_'.$file1->name);
                Image::getImagine()->open($file1->tempName)->thumbnail(new Box($newWidth, $newHeight))->save($savePath , ['quality' => 90]);
                
                $data = file_get_contents($savePath);
                $model->foto1 = 'data:image/'.$file1->extension.';base64,'.base64_encode($data);
                unlink($savePath);
            }
            if(!empty($file2)) {
                $newWidth = 2000;
                $newHeight = 2000;
                $savePath = Yii::getAlias('@webroot/images/tempimages/'.Yii::$app->security->generateRandomString().'_'.$file2->name);
                Image::getImagine()->open($file2->tempName)->thumbnail(new Box($newWidth, $newHeight))->save($savePath , ['quality' => 90]);
                
                $data = file_get_contents($savePath);
                $model->foto2 = 'data:image/'.$file2->extension.';base64,'.base64_encode($data);
                unlink($savePath);
            }
            if(!empty($file3)) {
                $newWidth = 2000;
                $newHeight = 2000;
                $savePath = Yii::getAlias('@webroot/images/tempimages/'.Yii::$app->security->generateRandomString().'_'.$file3->name);
                Image::getImagine()->open($file3->tempName)->thumbnail(new Box($newWidth, $newHeight))->save($savePath , ['quality' => 90]);
                
                $data = file_get_contents($savePath);
                $model->foto3 = 'data:image/'.$file3->extension.';base64,'.base64_encode($data);
                unlink($savePath);
            }

            if($model->save()) {
                return $this->redirect(['/konsolidasi/view', 'id' => $model->id]);
            }
        } else {
            return $this->render('konsolidasi', [
                'model' => $model,
            ]);
        }

        
    }
}

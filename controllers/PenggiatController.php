<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Penyebarluasan;
use app\models\Konsolidasi;
use app\models\Pendataan;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use app\component\Helpers;
use yii\web\NotFoundHttpException;

class PenggiatController extends Controller
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
        $query = Penyebarluasan::find()->where(['created_by' => \Yii::$app->user->identity->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tanggal_entri' => SORT_DESC,
                ]
            ]
        ]);
        
        return $this->render('penyebarluasan', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewPenyebarluasan($id)
    {
        $model = $this->findModelPenyebarluasan($id);
        return $this->render('detail-penyebarluasan', [
            'model' => $model,
        ]);
    }

    public function actionEditPenyebarluasan($id)
    {
        $model = $this->findModelPenyebarluasan($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->save(false)) {
                return $this->redirect(['view-penyebarluasan', 'id' => $model->id]);
            }
        } else {
            $model_kec = \app\models\Kecamatan::find()->where(['nama_kecamatan' => $model->kecamatan])->one();
            $model_kabkota = \app\models\Kabupatenkota::find()->where(['nama_kabkota' => $model->kabupatenkota])->one();
            $model_prov = \app\models\Provinsi::find()->where(['nama_provinsi' => $model->provinsi])->one();
            
            $model_topik = \app\models\Topik::find()->where(['nama_topik' => $model->topik])->one();
            $model_tema = \app\models\Tema::find()->where(['nama_tema' => $model->tema])->one();

            // var_dump($model_kabkota);die();
            $model->provinsi_id = $model_prov ? $model_prov->id : null;
            $model->kabkota_id = $model_kabkota ? $model_kabkota->id : null;
            $model->tema_id = $model_tema ? $model_tema->id : null;

            $model->provinsi = $model_prov;
            $model->kabupatenkota = $model_kabkota;
            $model->kecamatan = $model_kec;
            $model->topik = $model_topik;
            $model->tema = $model_tema;
            
            return $this->render('edit-penyebarluasan', [
                'model' => $model,
            ]);
        }
    }

    public function actionKonsolidasi()
    {
        $query = Konsolidasi::find()->where(['created_by' => \Yii::$app->user->identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tanggal_entri' => SORT_DESC,
                ]
            ]
        ]);

        return $this->render('konsolidasi', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewKonsolidasi($id)
    {
        $model = $this->findModelKonsolidasi($id);
        return $this->render('detail-konsolidasi', [
            'model' => $model,
        ]);
    }

    public function actionEditKonsolidasi($id)
    {
        $model = $this->findModelKonsolidasi($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->save(false)) {
                return $this->redirect(['view-konsolidasi', 'id' => $model->id]);
            }
        } else {
            $model_kec = \app\models\Kecamatan::find()->where(['nama_kecamatan' => $model->kecamatan])->one();
            $model_kabkota = \app\models\Kabupatenkota::find()->where(['nama_kabkota' => $model->kabupatenkota])->one();
            $model_prov = \app\models\Provinsi::find()->where(['nama_provinsi' => $model->provinsi])->one();
            
            $model_topik = \app\models\Topik::find()->where(['nama_topik' => $model->sub_metode])->one();
            $model_tema = \app\models\Tema::find()->where(['nama_tema' => $model->metode])->one();

            // var_dump($model_kabkota);die();
            $model->provinsi_id = $model_prov ? $model_prov->id : null;
            $model->kabkota_id = $model_kabkota ? $model_kabkota->id : null;
            $model->tema_id = $model_tema ? $model_tema->id : null;

            $model->provinsi = $model_prov;
            $model->kabupatenkota = $model_kabkota;
            $model->kecamatan = $model_kec;
            $model->sub_metode = $model_topik;
            $model->metode = $model_tema;
            $model->tanggal_entri = date('d-m-Y');

            return $this->render('edit-konsolidasi', [
                'model' => $model,
            ]);
        }
    }

    public function actionPendataan()
    {
        $query = Pendataan::find()->where(['created_by' => \Yii::$app->user->identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tanggal_entri' => SORT_DESC,
                ]
            ]
        ]);

        return $this->render('pendataan', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewPendataan($id)
    {
        $model = $this->findModelPendataan($id);
        return $this->render('detail-pendataan', [
            'model' => $model,
        ]);
    }

    protected function findModelPenyebarluasan($id)
    {
        if (($model = Penyebarluasan::findOne(['id' => $id, 'created_by' => \Yii::$app->user->identity->id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelKonsolidasi($id)
    {
        if (($model = Konsolidasi::findOne(['id' => $id, 'created_by' => \Yii::$app->user->identity->id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPendataan($id)
    {
        if (($model = Pendataan::findOne(['id' => $id, 'created_by' => \Yii::$app->user->identity->id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
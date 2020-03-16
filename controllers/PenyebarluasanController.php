<?php

namespace app\controllers;

use Yii;
use app\models\Penyebarluasan;
use app\models\search\SearchPenyebarluasan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;

/**
 * PenyerbarluasanController implements the CRUD actions for Penyebarluasan model.
 */
class PenyebarluasanController extends Controller
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

    /**
     * Lists all Penyebarluasan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPenyebarluasan();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Penyebarluasan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Penyebarluasan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penyebarluasan();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->tanggal_entri = date('Y-m-d H:m:s', strtotime(time()));

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

            if($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Penyebarluasan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            // $model->tanggal_entri = date('Y-m-d H:m:s', strtotime(time()));
            
            // $provinsi = \app\models\Provinsi::findOne($model->provinsi);
            // $kabupatenkota = \app\models\Kabupatenkota::findOne($model->kabupatenkota);
            // $kecamatan = \app\models\Kecamatan::findOne($model->kecamatan);
            // $tema = \app\models\Tema::findOne($model->tema);
            // $topik = \app\models\Topik::findOne($model->topik);

            // $model->provinsi = $provinsi->nama_provinsi;
            // $model->kabupatenkota = $kabupatenkota->nama_kabkota;
            // $model->kecamatan = $kecamatan->nama_kecamatan;
            // $model->tema = $tema->nama_tema;
            // $model->topik = $topik->nama_topik;

            if($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
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

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Penyebarluasan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Penyebarluasan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penyebarluasan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penyebarluasan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findUserModel($id)
    {
        if (($model = Penyebarluasan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

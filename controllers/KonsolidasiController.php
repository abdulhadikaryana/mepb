<?php

namespace app\controllers;

use Yii;
use app\models\Konsolidasi;
use app\models\search\SearchKonsolidasi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use kartik\mpdf\Pdf;

/**
 * KonsolidasiController implements the CRUD actions for Konsolidasi model.
 */
class KonsolidasiController extends Controller
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
     * Lists all Konsolidasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchKonsolidasi();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Konsolidasi model.
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
     * Creates a new Konsolidasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Konsolidasi();

        if ($model->load(Yii::$app->request->post())) {
            $model->tanggal_entri = date('Y-m-d H:m:s', strtotime(time()));
            
            $provinsi = \app\models\Provinsi::findOne($model->provinsi);
            $kabupatenkota = \app\models\Kabupatenkota::findOne($model->kabupatenkota);
            $kecamatan = \app\models\Kecamatan::findOne($model->kecamatan);
            $tema = \app\models\Tema::findOne($model->metode);
            $topik = \app\models\Topik::findOne($model->sub_metode);

            $model->provinsi = $provinsi->nama_provinsi;
            $model->kabupatenkota = $kabupatenkota->nama_kabkota;
            $model->kecamatan = $kecamatan->nama_kecamatan;
            $model->metode = $tema->nama_tema;
            $model->sub_metode = $topik->nama_topik;

            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Konsolidasi model.
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
            // if($model->tanggal_entri) {
            //     $model->tanggal_entri = date('Y-m-d H:m:s', strtotime(time()));
            // }
            
            // $provinsi = \app\models\Provinsi::findOne($model->provinsi);
            // $kabupatenkota = \app\models\Kabupatenkota::findOne($model->kabupatenkota);
            // $kecamatan = \app\models\Kecamatan::findOne($model->kecamatan);
            // $tema = \app\models\Tema::findOne($model->metode);
            // $topik = \app\models\Topik::findOne($model->sub_metode);

            // if($provinsi){
            //     $model->provinsi = $provinsi->nama_provinsi;
            // }
            // if($kabupatenkota) {
            //     $model->kabupatenkota = $kabupatenkota->nama_kabkota;
            // }
            // if($kecamatan) {
            //     $model->kecamatan = $kecamatan->nama_kecamatan;
            // }
            // if($tema) {
            //     $model->metode = $tema->nama_tema;
            // }
            // if($topik) {
            //     $model->sub_metode = $topik->nama_topik;
            // }
            

            if($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
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

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Konsolidasi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPrintReportOneMonth()
    {
        // $content = $this->renderPartial('print-report-one-month');
        
        // $pdf = new Pdf([
        //     'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
        //     'content' => $content,
        //     'filename' => 'Laporan-konsolidasi-satu-bulan.pdf',
        //     'destination' => Pdf::DEST_DOWNLOAD,
        //     'options' => [
        //         'title' => 'Laporan Konsolidasi Masalah satu bulan',
        //         'subject' => 'Laporan Konsolidasi Masalah satu bulan'
        //     ],
        //     'methods' => [
        //         'SetHeader' => ['Dibuat oleh: penggiatbudaya.kemdikbud.go.id||Pada: ' . date("r")],
        //         'SetFooter' => ['|Hal {PAGENO}|'],
        //     ]
        // ]);

        // $response = Yii::$app->response;
        // $response->format = \yii\web\Response::FORMAT_RAW;
        
        // $headers = Yii::$app->response->headers;
        // $headers->add('Content-Type', 'application/pdf');
        
        // return $pdf->render();

        return $this->render('print-report-one-month', []);
    }

    public function actionPrintReportSixMonth()
    {
        $model = Konsolidasi::find()->all();

        return $this->render('print-report-six-month', [
            'model' => $model,
        ]);
    }

    public function actionPrintReportOneYear()
    {
        $model = Konsolidasi::find()->all();

        return $this->render('print-report-one-year', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Konsolidasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Konsolidasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Konsolidasi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findUserModel($id)
    {
        if (($model = Konsolidasi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

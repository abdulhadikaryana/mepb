<?php

namespace app\controllers;

use Yii;
use app\models\Kecamatan;
use app\models\search\SearchKecamatan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * KecamatanController implements the CRUD actions for Kecamatan model.
 */
class KecamatanController extends Controller
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
     * Lists all Kecamatan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchKecamatan();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpload()
    {
        $model = new Kecamatan;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file) {
                $handle = fopen($model->file->tempName, 'r');
                
                while( ($line = fgetcsv($handle, 1000, ",")) != FALSE) {
                    $datas_tmp = explode(';', $line[0]);
                    
                    $kabkota_id = self::getKabkotaId($datas_tmp[2]);
                    $datas[] = array(
                        'kode_kecamatan' => $datas_tmp[0],
                        'nama_kecamatan' => $datas_tmp[1],
                        'kabkota_id' => $kabkota_id,
                    );
                }
                fclose($handle);
                
                $tableName = 'kecamatan';
                $columnNameArray = ['kode_kecamatan','nama_kecamatan','kabkota_id'];

                Yii::$app->db->createCommand()->batchInsert($tableName, $columnNameArray, $datas)->execute();

                return $this->redirect(['index']);
            }
        } else {
            return $this->render('upload', [
                'model' => $model,
            ]);
        }
    }

    protected function getKabkotaId($kode_kabkota) 
    {
        $kabkota = \app\models\Kabupatenkota::findOne(['kode_kabkota' => $kode_kabkota]);
        if(!empty($kabkota)) {
            return $kabkota->id;
        } else {
            return null;
        }
    }

    /**
     * Displays a single Kecamatan model.
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
     * Creates a new Kecamatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kecamatan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Kecamatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model_kabkota = \app\models\Kabupatenkota::find()->where(['id' => $model->kabkota_id])->one();
            $model->provinsi_id = $model_kabkota ? \app\models\Provinsi::find()->where(['id' => $model_kabkota->provinsi_id])->one() : null;
            $model->kabkota_id = $model_kabkota;
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Kecamatan model.
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
     * Finds the Kecamatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kecamatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kecamatan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

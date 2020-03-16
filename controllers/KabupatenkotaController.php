<?php

namespace app\controllers;

use Yii;
use app\models\Kabupatenkota;
use app\models\search\SearchKabupatenkota;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * KabupatenkotaController implements the CRUD actions for Kabupatenkota model.
 */
class KabupatenkotaController extends Controller
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
     * Lists all Kabupatenkota models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchKabupatenkota();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpload()
    {
        $model = new Kabupatenkota;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file) {
                $handle = fopen($model->file->tempName, 'r');
                
                while( ($line = fgetcsv($handle, 1000, ",")) != FALSE) {
                    $datas_tmp = explode(';', $line[0]);
                    
                    $prov_id = self::getProvId($datas_tmp[2]);
                    $datas[] = array(
                        'kode_kabkota' => $datas_tmp[0],
                        'nama_kabkota' => $datas_tmp[1],
                        'provinsi_id' => $prov_id,
                        'tipe' => $datas_tmp[3]
                    );
                }
                fclose($handle);

                $tableName = 'kabupatenkota';
                $columnNameArray = ['kode_kabkota','nama_kabkota','provinsi_id','tipe'];

                Yii::$app->db->createCommand()->batchInsert($tableName, $columnNameArray, $datas)->execute();

                return $this->redirect(['index']);
            }
        } else {
            return $this->render('upload', [
                'model' => $model,
            ]);
        }
    }

    protected function getProvId($prov_id) 
    {
        $prov = \app\models\Provinsi::findOne(['kode_provinsi' => $prov_id]);
        if(!empty($prov)) {
            return $prov->id;
        } else {
            return null;
        }
    }

    /**
     * Displays a single Kabupatenkota model.
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
     * Creates a new Kabupatenkota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kabupatenkota();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->tipe = "Kabupaten";
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Kabupatenkota model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Kabupatenkota model.
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
     * Finds the Kabupatenkota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kabupatenkota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kabupatenkota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

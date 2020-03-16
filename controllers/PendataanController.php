<?php

namespace app\controllers;

use Yii;
use app\models\Pendataan;
use app\models\search\SearchPendataan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\base\Security;
use yii\httpclient\Client;
use yii\helpers\Json;
use yii\db\Query;

/**
 * PendataanController implements the CRUD actions for Pendataan model.
 */
class PendataanController extends Controller
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
     * Lists all Pendataan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPendataan();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pendataan model.
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
     * Creates a new Pendataan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pendataan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Pendataan model.
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
     * Deletes an existing Pendataan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSync()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $connection = \Yii::$app->db;

        $service_url = 'https://penggiat.dapobud.kemdikbud.go.id/web/mobile-api/api';
        $client = new Client(['baseUrl' => $service_url]);
        // $tanggal = '2017-06-05';
        
        // $tanggal = date('Y-m-d');
        $tanggal = date('Y-m-d', strtotime(Yii::$app->request->post('date_sync')));

        $response = $client->createRequest()
                    ->setMethod('get')
                    ->setUrl('data-by-date')
                    ->setData(['date' => $tanggal])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->send();

        if($response->isOk) {
            $datas = Json::decode($response->content);
            $i = 0;
            foreach($datas as $data) {
                $user = \app\models\User::findOne(['email' => $data['email']]);
                $time = strtotime($data['tanggal_entri']);
                
                $cekmodel = \app\models\Pendataan::findOne(['dataid' => $data['dataid'], 'obyek' => $data['jenis']]);
                
                if(empty($cekmodel)) {
                    $model = new \app\models\Pendataan;
                    $model->created_by = $user ? $user->id : 1;
                    $model->updated_by = $user ? $user->id : 1;
                    $model->created_at = $time;
                    $model->updated_at = $time;
                    $model->tanggal_entri = $data['tanggal_entri'];
                    $model->name = $data['nama'] ? $data['nama'] : '-';
                    $model->lokasi = $data['desakel'] ? $data['desakel'] : '-';
                    $model->desakel = $data['desakel'] ? $data['desakel'] : '-';
                    $model->kecamatan = $data['kecamatan'] ? $data['kecamatan'] : '-';
                    $model->kabupatenkota = $data['kabupatenkota'] ? $data['kabupatenkota'] : '-';
                    $model->provinsi = $data['provinsi'] ? $data['provinsi'] : '-';
                    $model->dataid = $data['dataid'];
                    $model->obyek = $data['jenis'] ? $data['jenis'] : '-';
                    $model->jumlah_data = 1;
                    $model->latitude = $data['latitude'];
                    $model->longitude = $data['longitude'];

                    $model->save(false);
                    $i++;
                }
            }

            $result = [
                'status' => $response->statusCode,
                'message' => "Insert data di tanggal " . $tanggal . " sebanyak " . $i . ' dari ' . count($datas) . " data selesai"
            ];
        } else {
            $result = [
                'status' => $response->statusCode,
                'message' => "Insert data di tanggal ". $tanggal . " Gagal. Response Server: " . $response->statusCode
            ];
        }

        return $result;
    }

    /**
     * Finds the Pendataan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pendataan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pendataan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findUserModel($id)
    {
        if (($model = Pendataan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

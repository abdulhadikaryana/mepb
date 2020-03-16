<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\search\SearchUserDinas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserDinasController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUserDinas();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpload()
    {
        $model = new User;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file) {
                $handle = fopen($model->file->tempName, 'r');
                
                while( ($line = fgetcsv($handle, 1000, ";")) != FALSE) {

                    $model = new User;

                    $model->username = $line[4];
                    $model->email = $line[4];
                    $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($line[5], 5);
                    $model->group = 30; // penggiat
                    $model->wilayah_kerja = self::getWilayahId($line[6]);

                    $transaction = \Yii::$app->db->beginTransaction();
                    try{
                        if($flag = $model->save(false)) {
                            $authAssignment = new AuthAssignment([
                                'user_id' => $model->id,
                            ]);
                            $authAssignment->item_name = 'Dinas';
                            $authAssignment->save();

                            $modelProfile = new \app\models\Profile;
                            $modelProfile->user_id = $model->id;
                            $modelProfile->kecamatan_id = self::getKecId($line[2]);
                            $modelProfile->kabkota_id = self::getKabkotaId($line[1]);
                            $modelProfile->provinsi_id = self::getProvId($line[0]);
                            $modelProfile->fullname = $line[3];
                            $modelProfile->phone = 123456;
                            $modelProfile->birthdate = '1990-01-01';

                            if(!$modelProfile->save(false)) {
                                $transaction->rollBack();
                            }
                        }

                        if($flag) {
                            $transaction->commit();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
                fclose($handle);

                return $this->redirect(['index']);
            }
        } else {
            return $this->render('upload', [
                'model' => $model,
            ]);
        }
    }

    protected function getWilayahId($kode_kec) 
    {
        $kec_kode = explode('-', $kode_kec);
        $kecs = \app\models\Kecamatan::find()->where(['in', 'kode_kecamatan', $kec_kode])->all();
        
        if(!empty($kecs)) {
            foreach($kecs as $key => $val) {
                $kec_id[] = $val->id;
            }
            return implode(',', $kec_id);
        } else {
            return null;
        }
    }

    protected function getKecId($kode_kec)
    {
        $kecamatan = \app\models\Kecamatan::findOne(['kode_kecamatan' => $kode_kec]);
        if(!empty($kecamatan)) {
            return $kecamatan->id;
        } else {
            return null;
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

    protected function getProvId($kode_prov)
    {
        $prov = \app\models\Provinsi::findOne(['kode_provinsi' => $kode_prov]);
        if(!empty($prov)) {
            return $prov->id;
        } else {
            return null;
        }
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
		$authAssignments = AuthAssignment::find()->where([
			'user_id' => $model->id,
		])->column();

		$authItems = ArrayHelper::map(
			AuthItem::find()->where([
				'type' => 1,
			])->asArray()->all(),
			'name', 'name');

		$authAssignment = new AuthAssignment([
			'user_id' => $model->id,
		]);

		if (Yii::$app->request->post()) {
			$authAssignment->load(Yii::$app->request->post());
			// delete all role
			AuthAssignment::deleteAll(['user_id' => $model->id]);
			if (is_array($authAssignment->item_name)) {
				foreach ($authAssignment->item_name as $item) {
					if (!in_array($item, $authAssignments)) {
						$authAssignment2 = new AuthAssignment([
							'user_id' => $model->id,
						]);
						$authAssignment2->item_name = $item;
						$authAssignment2->created_at = time();
						$authAssignment2->save();

						$authAssignments = AuthAssignment::find()->where([
							'user_id' => $model->id,
						])->column();
					}
				}
			}
			Yii::$app->session->setFlash('success', 'Data tersimpan');
		}
		$authAssignment->item_name = $authAssignments;
		return $this->render('view', [
			'model' => $model,
			'authAssignment' => $authAssignment,
			'authItems' => $authItems,
		]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => 'create']);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if (is_array($model->wilayah_kerja)) {
                $model->wilayah_kerja = implode(',', $model->wilayah_kerja);
            }
            
            $model->status = $model->status == 1 ? 10 : 0;
            $model->group = 30;
            $model->setPassword($model->password);
            $model->generateAuthKey();
            if($model->validate() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->password)) {
				$model->setPassword($model->password);
			}
            if (is_array($model->wilayah_kerja)) {
                $model->wilayah_kerja = implode(',', $model->wilayah_kerja);
            }
            $model->status = $model->status == 1 ? 10 : 0;
            if($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model->status = $model->status == 10 ? 1 : 0;
                $model->wilayah_kerja = explode(',', $model->wilayah_kerja);
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            $model->status = $model->status == 10 ? 1 : 0;
            $model->wilayah_kerja = explode(',', $model->wilayah_kerja);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

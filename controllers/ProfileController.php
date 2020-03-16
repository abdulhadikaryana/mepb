<?php

namespace app\controllers;

use Yii;
use app\models\Profile;
use app\models\search\SearchProfile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\component\RecordHelpers;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\widgets\ActiveForm;

use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

use app\models\Penyebarluasan;
use app\models\Konsolidasi;
use app\models\Pendataan;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        if($already_exists = RecordHelpers::userHas('profile')) {
            // return $this->render('view', [
            //     'model' => $this->findModel($already_exists),
            // ]);
            return $this->redirect(['view']);
        } else {
            return $this->redirect(['create']);
        }
    }

    public function actionList()
    {
        $searchModel = new SearchProfile();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionManualCreate()
    {
        $model = new Profile();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->birthdate = date('Y-m-d', strtotime($model->birthdate));
            if($already_exists = RecordHelpers::userHasProfile($model->user_id)) {
                return $this->render('manual-view', [
                    'model' => $this->findModel($already_exists),
                ]);
            } else {
                if($model->save()) {
                    return $this->redirect(['manual-view', 'id' => $model->id]);
                }
            }
        } else {
            return $this->render('manual-create', [
                'model' => $model,
            ]);
        }
    }

    public function actionManualView($id)
    {
        return $this->render('manual-view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionManualUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->birthdate = date('Y-m-d', strtotime($model->birthdate));
            if($model->save()) {
                return $this->redirect(['manual-view', 'id' => $model->id]);
            }
        } else {
            $model->birthdate = date('d-m-Y', strtotime($model->birthdate));
            return $this->render('manual-update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $categories = ['Penyebarluasan', 'Konsolidasi', 'Pendataaan'];
        
        if(Yii::$app->user->identity->group == 10) {
            $dataPenyebarluasan = Penyebarluasan::find()->count();
            $dataKonsolidasi = Konsolidasi::find()->count();
            $dataPendataan = Pendataan::find()->count();
        } else {
            $dataPenyebarluasan = Penyebarluasan::find()->allWithChild()->count();
            $dataKonsolidasi = Konsolidasi::find()->allWithChild()->count();
            $dataPendataan = Pendataan::find()->allWithChild()->count();
        }

        $data = [
            [
                'name' => 'Penyebarluasan',
                'y' => (int)$dataPenyebarluasan
            ],
            [
                'name' => 'Konsolidasi',
                'y' => (int)$dataKonsolidasi
            ],
            [
                'name' => 'Pendataan',
                'y' => (int)$dataPendataan
            ]
        ];

        if($already_exists = RecordHelpers::userHas('profile')) {
            return $this->render('view', [
                'model' => $this->findModel($already_exists),
                'categories' => $categories,
                'data' => $data
            ]);
        } else {
            return $this->redirect(['create']);
        }
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->user_id = \Yii::$app->user->identity->id;
        if($already_exists = RecordHelpers::userHas('profile')) {
            return $this->render('view', [
                'model' => $this->findModel($already_exists),
            ]);
        } elseif ($model->load(Yii::$app->request->post())) {
            $model->birthdate = date('Y-m-d', strtotime($model->birthdate));
            $file = UploadedFile::getInstance($model, 'photo');
        
            if(!empty($file)) {
                $newWidth = 400;
                $newHeight = 400;
                $savePath = Yii::getAlias('@webroot/images/profiles/'.Yii::$app->security->generateRandomString().'_'.$file->name);
                Image::getImagine()->open($file->tempName)->thumbnail(new Box($newWidth, $newHeight))->save($savePath , ['quality' => 90]);
                
                $data = file_get_contents($savePath);
                $model->photo = 'data:image/'.$file->extension.';base64,'.base64_encode($data);
                unlink($savePath);
            }
            
            if($model->save()) {
                return $this->redirect(['view']);
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = Profile::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $currentPhoto = $model->photo;
        if($model) {
            if($model->load(Yii::$app->request->post())) {
                $model->birthdate = date('Y-m-d', strtotime($model->birthdate));

                $file = UploadedFile::getInstance($model, 'photo');
        
                if(!empty($file)) {
                    $newWidth = 400;
                    $newHeight = 400;
                    $savePath = Yii::getAlias('@webroot/images/profiles/'.Yii::$app->security->generateRandomString().'_'.$file->name);
                    Image::getImagine()->open($file->tempName)->thumbnail(new Box($newWidth, $newHeight))->save($savePath , ['quality' => 90]);
                    
                    $data = file_get_contents($savePath);
                    $model->photo = 'data:image/'.$file->extension.';base64,'.base64_encode($data);
                    unlink($savePath);
                } else {
                    $model->photo = $currentPhoto;
                }

                if($model->save(false)) {
                    return $this->redirect(['view']);
                }
            } else {
                $model->birthdate = date('d-m-Y', strtotime($model->birthdate));
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('No Such Profile.');
        }
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $model = Profile::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        $this->findModel($model->id)->delete();

        return $this->redirect(['site/index']);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findUserModel()
    {
        $created_by = Yii::$app->user->identity->id;
        if (($model = Profile::findOne($created_by)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

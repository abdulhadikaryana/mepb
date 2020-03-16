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

class DinasController extends Controller
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

    public function actionIndex()
    {
        $parent_id = \Yii::$app->user->identity->id;
        $childs = Helpers::getIdChild($parent_id);
        $model = \app\models\User::findOne($parent_id);
        $query = \app\models\User::find()
            ->joinWith('penyebarluasan')
            ->joinWith('konsolidasi')
            ->joinWith('pendataan')
            ->where(['konsolidasi.created_by' => $childs])
            ->groupBy('user.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPenyebarluasan()
    {
        if(\Yii::$app->user->identity->group == 10) {
            $query = Penyebarluasan::find();
        } else {
            $query = Penyebarluasan::find()->allWithChild();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);
        
        return $this->render('penyebarluasan', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailPenyebarluasan($id)
    {
        $model = $this->findModelPenyebarluasan($id);
        return $this->render('detail-penyebarluasan', [
            'model' => $model,
        ]);
    }

    public function actionCommentPenyebarluasan($id)
    {
        $model = $this->findModelPenyebarluasan($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->rev_oleh = Yii::$app->user->identity->id;
            $model->rev_tanggal = date('U');
            $model->is_rev = 1;
            if($model->save(false)) {
                return $this->redirect(['penyebarluasan']);
            }
        } else {
            return $this->renderAjax('comment-penyebarluasan', [
                'model' => $model,
            ]);
        }
    }

    public function actionApprovePenyebarluasan($id)
    {
        $model = $this->findModelPenyebarluasan($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->setuju_tanggal = date('U');
            $model->setuju_oleh = Yii::$app->user->identity->id;
            if($model->save()) {
                return $this->redirect(['penyebarluasan']);
            }
        } else {
            return $this->renderAjax('approve-penyebarluasan', [
                'model' => $model,
            ]);
        }
    }

    //
    public function actionKonsolidasi()
    {
        if(\Yii::$app->user->identity->group == 10) {
            $query = Konsolidasi::find();
        } else {
            $query = Konsolidasi::find()->allWithChild();
        }
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        return $this->render('konsolidasi', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailKonsolidasi($id)
    {
        $model = $this->findModelKonsolidasi($id);
        return $this->render('detail-konsolidasi', [
            'model' => $model,
        ]);
    }

    public function actionCommentKonsolidasi($id)
    {
        $model = $this->findModelKonsolidasi($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->rev_oleh = Yii::$app->user->identity->id;
            $model->rev_tanggal = date('U');
            $model->is_rev = 1;
            if($model->save(false)) {
                return $this->redirect(['konsolidasi']);
            }
        } else {
            return $this->renderAjax('comment-konsolidasi', [
                'model' => $model,
            ]);
        }
    }

    public function actionApproveKonsolidasi($id)
    {
        $model = $this->findModelKonsolidasi($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->setuju_tanggal = date('U');
            $model->setuju_oleh = Yii::$app->user->identity->id;
            if($model->save()) {
                return $this->redirect(['konsolidasi']);
            }
        } else {
            return $this->renderAjax('approve-konsolidasi', [
                'model' => $model,
            ]);
        }
    }

    public function actionPendataan()
    {
        if(\Yii::$app->user->identity->group == 10) {
            $query = Pendataan::find();
        } else {
            $query = Pendataan::find()->allWithChild();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        return $this->render('pendataan', [
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModelPenyebarluasan($id)
    {
        if (($model = Penyebarluasan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelKonsolidasi($id)
    {
        if (($model = Konsolidasi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPendataan($id)
    {
        if (($model = Pendataan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
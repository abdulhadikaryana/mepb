<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class FormController extends Controller
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
        return $this->render('index');
    }

    public function actionAdvanced()
    {
        return $this->render('advanced');
    }

    public function actionButton()
    {
        return $this->render('button');
    }

    public function actionUpload()
    {
        return $this->render('upload');
    }

    public function actionValidation()
    {
        return $this->render('validation');
    }

    public function actionWizard()
    {
        return $this->render('wizard');
    }
}
<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ExtrasController extends Controller
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

    public function actionError403()
    {
        return $this->render('403');
    }

    public function actionError404()
    {
        return $this->render('404');
    }

    public function actionError500()
    {
        return $this->render('500');
    }

    public function actionLoginPage()
    {
        return $this->render('login-page');
    }

    public function actionPlainPage()
    {
        return $this->render('plain-page');
    }

    public function actionPricingTables()
    {
        return $this->render('pricing-tables');
    }
}
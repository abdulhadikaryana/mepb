<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ChartController extends Controller
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

    public function actionEcharts()
    {
        return $this->render('echarts');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionJs2()
    {
        return $this->render('js2');
    }

    public function actionMoris()
    {
        return $this->render('moris');
    }

    public function actionOther()
    {
        return $this->render('other');
    }
}
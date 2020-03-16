<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ElementsController extends Controller
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

    public function actionCalendar()
    {
        return $this->render('calendar');
    }

    public function actionGlyphicons()
    {
        return $this->render('glyphicons');
    }

    public function actionIcons()
    {
        return $this->render('icons');
    }

    public function actionInbox()
    {
        return $this->render('inbox');
    }

    public function actionInvoice()
    {
        return $this->render('invoice');
    }

    public function actionMediaGallery()
    {
        return $this->render('media-gallery');
    }

    public function actionTypography()
    {
        return $this->render('typography');
    }

    public function actionWidgets()
    {
        return $this->render('widgets');
    }
}
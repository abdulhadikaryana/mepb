<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AdditionalController extends Controller
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

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionEcommerce()
    {
        return $this->render('ecommerce');
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }

    public function actionProjectDetail()
    {
        return $this->render('project-detail');
    }

    public function actionProjects()
    {
        return $this->render('projects');
    }
}
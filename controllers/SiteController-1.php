<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
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
                        'actions' => ['index', 'about', 'login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = '//homepage';

        $model = new LoginForm();
        // if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //     return $this->goBack();
        // }

        if ($model->load(Yii::$app->request->post())) {
            $client = Yii::$app->authClientCollection->getClient('dapobud');
            // var_dump($client);die();
            try {
                $accessToken = $client->authenticateUser($model->email, $model->password);
                $attr = $client->api('user', 'GET');
                // print_r($attr);exit();
                $userByEmail = \app\models\User::findByEmail($attr['email']);
                if(!empty($userByEmail)) {
                    Yii::$app->user->login($userByEmail);
                } else {
                    $usermodel = new \app\models\User;
                    $usermodel->email = $attr['email'];
                    $usermodel->username = $attr['email'];
                    $usermodel->setPassword($attr['nutb']);
                    $usermodel->generateAuthKey();

                    if($usermodel->save()) {
                        $auth = \Yii::$app->authManager;
                        $userRole = $auth->getRole('Penggiat');
                        $auth->assign($userRole, $usermodel->getId());

                        return $this->redirect(['/profile']);
                    }
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionDashboard1()
    {
        return $this->render('dashboard1');
    }

    public function actionDashboard2()
    {
        return $this->render('dashboard2');
    }

    public function actionDashboard3()
    {
        return $this->render('dashboard3');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = '//main-login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        
        // if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //     return $this->goBack();
        // }

        if ($model->load(Yii::$app->request->post())) {
            $client = Yii::$app->authClientCollection->getClient('dapobud');
            // var_dump($client);die();
            try {
                $accessToken = $client->authenticateUser($model->email, $model->password);
                $attr = $client->api('user', 'GET');
                print_r($attr);exit();
                $userByEmail = \app\models\User::findByEmail($attr['email']);
                if(!empty($userByEmail)) {
                    Yii::$app->user->login($userByEmail);
                } else {
                    $usermodel = new \app\models\User;
                    $usermodel->email = $attr['email'];
                    $usermodel->username = $attr['nutb'];
                    $usermodel->setPassword($attr['nutb']);
                    $usermodel->generateAuthKey();

                    if($usermodel->save(false)) {
                        $auth = \Yii::$app->authManager;
                        $userRole = $auth->getRole('Penggiat');
                        $auth->assign($userRole, $usermodel->getId());

                        return $this->redirect(['/profile']);
                    }
                    return null;
                }

            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $this->layout = '//homepage';

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $this->layout = '//homepage';
        return $this->render('about');
    }
}

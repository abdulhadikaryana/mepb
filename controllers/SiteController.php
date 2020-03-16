<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use app\models\search\SearchKegiatan;

use app\models\Penyebarluasan;
use app\models\Konsolidasi;
use app\models\Pendataan;

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

        // $model = new LoginForm();
        $model = \Yii::createObject(LoginForm::className());
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionDashboard1()
    {
        // $connection = \Yii::$app->db;

        // $model = \app\models\ViewKegiatan::find()->select([
        //     'tanggal_entri',
        //     'SUM(CASE WHEN kegiatan=\'penyebarluasan\' AND tanggal_entri IS NOT NULL THEN 1 ELSE 0 END) AS penyebarluasan',
        //     'SUM(CASE WHEN kegiatan=\'konsolidasi\' AND tanggal_entri IS NOT NULL THEN 1 ELSE 0 END) AS konsolidasi',
        //     'SUM(CASE WHEN kegiatan=\'pendataan\' AND tanggal_entri IS NOT NULL THEN 1 ELSE 0 END) AS pendataan'
        // ])->where('IS NOT', 'tanggal_entri', NULL)->all();
        
        // // $model->where('IS NOT', 'tanggal_entri', NULL);
        // $model->groupBy('tanggal_entri');
        
        // var_dump($model->all());

        // SELECT tanggal_entri, 
        // SUM(CASE WHEN kegiatan='penyebarluasan' AND tanggal_entri IS NOT NULL THEN 1 ELSE 0 END) AS penyebarluasan, 
        // SUM(CASE WHEN kegiatan='konsolidasi' AND tanggal_entri IS NOT NULL THEN 1 ELSE 0 END) AS konsolidasi, 
        // SUM(CASE WHEN kegiatan='pendataan' AND tanggal_entri IS NOT NULL THEN 1 ELSE 0 END) AS pendataan 
        // FROM view_kegiatan WHERE tanggal_entri IS NOT NULL AND tanggal_entri BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() 
        // GROUP BY tanggal_entri
        // $searchModel = new SearchKegiatan();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $query = \app\models\ViewKegiatan::find();
        // $query->select([
        //     'tanggal_entri',
        //     'userid',
        //     'SUM(CASE WHEN kegiatan=\'penyebarluasan informasi\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS penyebarluasan',
        //     'SUM(CASE WHEN kegiatan=\'konsolidasi masalah\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS konsolidasi',
        //     'SUM(CASE WHEN kegiatan=\'pendataan\' AND created_by IS NOT NULL THEN 1 ELSE 0 END) AS pendataan'
        // ]);
        // $query->where(['NOT', ['tanggal_entri' => null]]);
        // $query->limit(30);
        // $query->groupBy('tanggal_entri');
        // $query->orderBy('tanggal_entri DESC');

        // $datas = $query->all();

        $connection = \Yii::$app->db;
        $query = "select * from (select tanggal_entri,userid,SUM(case when kegiatan='penyebarluasan informasi' and created_by is not null then 1 else 0 end) as penyebarluasan, sum(case when kegiatan='konsolidasi masalah' and created_by is not null then 1 else 0 end) as konsolidasi, sum(case when kegiatan='pendataan' and created_by is not null then 1 end) as pendataan from view_kegiatan where tanggal_entri is not null group by tanggal_entri order by tanggal_entri desc limit 30) tmp order by tmp.tanggal_entri asc";
        $datas = $connection->createCommand($query)->queryAll();

        // var_dump($datas);die();

        // print_r($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        foreach($datas as $data) {
            $categories[] = date('d-m-Y', strtotime($data['tanggal_entri']));
            $penyebarluasan[] = (int)$data['penyebarluasan'];
            $konsolidasi[] = (int)$data['konsolidasi'];
            $pendataan[] = (int)$data['pendataan'];
        }

        // $categories = [
        //     "01 Jun 2017", "02 Jun 2017", "03 Jun 2017", "04 Jun 2017", "05 Jun 2017", "06 Jun 2017", "07 Jun 2017", "08 Jun 2017", "09 Jun 2017", "10 Jun 2017", 
        //     "11 Jun 2017", "12 Jun 2017", "13 Jun 2017", "14 Jun 2017", "15 Jun 2017", "16 Jun 2017", "17 Jun 2017", "18 Jun 2017", "19 Jun 2017", "20 Jun 2017",
        //     "21 Jun 2017", "22 Jun 2017", "23 Jun 2017", "24 Jun 2017", "25 Jun 2017", "26 Jun 2017", "27 Jun 2017", "28 Jun 2017", "29 Jun 2017", "30 Jun 2017"
        // ];

        // foreach($datas as $x) {
        //     $penyebarluasan[] = $x->penyebarluasan;
        // }

        $series = [
            [
                "name" => "Penyebarluasan Informasi",
                "data" => $penyebarluasan
            ],
            [
                "name" => "Konsolidasi Masalah",
                "data" => $konsolidasi
            ],
            [
                "name" => "Pendataan",
                "data" => $pendataan
            ]
        ];

        $seriesDonut = [
            [
                "name" => "Jumlah",
                "colorByPoint" => true,
                "data" => [
                    [
                        "name" => "Penyebarluasan Informasi",
                        "y" => 25,
                    ],
                    [
                        "name" => "Konsolidasi Masalah",
                        "y" => 25,
                    ],
                    [
                        "name" => "Pendataan",
                        "y" => 50,
                    ],
                ]
            ]
        ];
        
        return $this->render('dashboard1', [
            'categories' => $categories,
            'series' => $series,
            'seriesDonut' => $seriesDonut,
        ]);
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

        // $model = new LoginForm();
        $model = \Yii::createObject(LoginForm::className());
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
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

    public function actionReport()
    {
        return $this->render('report');
    }

    public function actionMaps()
    {
        $dataPenyebarluasan = Penyebarluasan::find()->all();
        $dataKonsolidasi = Konsolidasi::find()->all();
        $dataPendataan = Pendataan::find()->all();

        return $this->render('maps', [
            'dataPenyebarluasan' => $dataPenyebarluasan,
            'dataKonsolidasi' => $dataKonsolidasi,
            'dataPendataan' => $dataPendataan
        ]);
    }
}

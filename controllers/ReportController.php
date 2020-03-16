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
use app\models\search\SearchReport;
use app\models\search\SearchKegiatan;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use app\component\Helpers;
use kartik\mpdf\Pdf;
use mpdf\mPDF;

class ReportController extends Controller
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
        $searchModel = new SearchKegiatan();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $session = Yii::$app->session;
        // check if a session is already open
        if (!$session->isActive){
            $session->open();// open a session
        } 
        // save query here
        $session['filterquery'] = Yii::$app->request->queryParams;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportPdf()
    {
        $searchModel = new SearchKegiatan();
        $dataProvider = $searchModel->search(Yii::$app->session->get('filterquery'));
        $dataProvider->pagination = false;
        $html = $this->renderPartial('_pdf', [
            'dataProvider' => $dataProvider,
        ]);
        $mpdf = new \mPDF('c', 'A4', '', '', 5, 5, 20, 10, 10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHeader('Dibuat oleh: penggiatbudaya.kemdikbud.go.id||Pada: ' . date("d M Y H:m:s"));
        $mpdf->SetFooter('Dicetak oleh: '. Yii::$app->user->identity->fullname . '|Hal {PAGENO}|');
        $mpdf->defaultheaderfontsize=10;
        $mpdf->defaultheaderfontstyle='B';
        $mpdf->defaultheaderline=0;
        $mpdf->defaultfooterfontsize=10;
        $mpdf->defaultfooterfontstyle='BI';
        $mpdf->defaultfooterline=0;
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;
    }

    public function actionReportOneMonth()
    {
        $searchModel = new SearchKegiatan();
        
        $dataProvider = $searchModel->searchByPenggiat(Yii::$app->request->queryParams);

        $session = Yii::$app->session;
        // check if a session is already open
        if (!$session->isActive){
            $session->open();// open a session
        } 
        // save query here
        $session['filter-report-query'] = Yii::$app->request->queryParams;
        
        return $this->render('report-one-month', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrintReportOneMonth($id)
    {
        $period = Yii::$app->session->get('filter-report-query');
        if(empty($period)) {
            $period['SearchKegiatan'] = array('month' => date('m'), 'year' => date('Y'));
        }
        $searchModel = new SearchKegiatan();
        $dataProvider = $searchModel->searchReportByPenggiatOneMonth($period);
        $dataProvider->pagination = false;
        $dataPenggiat = \app\models\User::findOne($id);
        $html = $this->renderPartial('_print-one-month-penggiat-pdf', [
            'dataPenggiat' => $dataPenggiat,
            'dataProvider' => $dataProvider,
            'period' => $period['SearchKegiatan'],
        ]);
        $namafile = $dataPenggiat->fullname . '-' . $period['SearchKegiatan']['month'] . '.pdf';
        $mpdf = new \mPDF('c', 'A4', '', '', 5, 5, 20, 10, 10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHeader('Dibuat oleh: penggiatbudaya.kemdikbud.go.id||Pada: ' . date("d M Y H:m:s"));
        $mpdf->SetFooter('Dicetak oleh: '. Yii::$app->user->identity->fullname . '|Hal {PAGENO}|');
        $mpdf->defaultheaderfontsize=10;
        $mpdf->defaultheaderfontstyle='B';
        $mpdf->defaultheaderline=0;
        $mpdf->defaultfooterfontsize=10;
        $mpdf->defaultfooterfontstyle='BI';
        $mpdf->defaultfooterline=0;
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->Output($namafile, 'D');
        exit;

        // return $html;
    }

    public function actionReportPenggiat()
    {
        $searchModel = new SearchKegiatan();
        
        $dataProvider = $searchModel->searchReportByPenggiat(Yii::$app->request->queryParams);

        $session = Yii::$app->session;
        // check if a session is already open
        if (!$session->isActive){
            $session->open();// open a session
        } 
        // save query here
        $session['filterreport'] = Yii::$app->request->queryParams;

        return $this->render('report-penggiat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrintReportPenggiat()
    {
        $period = Yii::$app->session->get('filterreport');
        if(empty($period)) {
            $period['SearchKegiatan'] = array('month' => date('m'), 'year' => date('Y'));
        }

        $searchModel = new SearchKegiatan();
        
        $dataProvider = $searchModel->searchReportByPenggiat($period);
        $dataProvider->pagination = false;
        $html = $this->renderPartial('_penggiat-pdf', [
            'dataProvider' => $dataProvider,
            'period' => $period['SearchKegiatan'],
        ]);
        $namafile = Yii::$app->user->identity->fullname . '-' . $period['SearchKegiatan']['month'] . '.pdf';
        $mpdf = new \mPDF('c', 'A4', '', '', 5, 5, 20, 10, 10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHeader('Dibuat oleh: penggiatbudaya.kemdikbud.go.id||Pada: ' . date("d M Y H:m:s"));
        $mpdf->SetFooter('Dicetak oleh: '. Yii::$app->user->identity->fullname . '|Hal {PAGENO}|');
        $mpdf->defaultheaderfontsize=10;
        $mpdf->defaultheaderfontstyle='B';
        $mpdf->defaultheaderline=0;
        $mpdf->defaultfooterfontsize=10;
        $mpdf->defaultfooterfontstyle='BI';
        $mpdf->defaultfooterline=0;
        $mpdf->list_indent_first_level = 0;
        $mpdf->WriteHTML($html);
        $mpdf->Output($namafile, 'D');
        exit;

        // return $html;
    }

    public function actionTest()
    {
        $searchModel = new SearchKegiatan();
        
        $dataProvider = $searchModel->searchTest(Yii::$app->request->queryParams);

        // var_dump($dataProvider->getModels());die();

        $session = Yii::$app->session;
        // check if a session is already open
        if (!$session->isActive){
            $session->open();// open a session
        } 
        // save query here
        $session['filterreport'] = Yii::$app->request->queryParams;

        return $this->render('test', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}

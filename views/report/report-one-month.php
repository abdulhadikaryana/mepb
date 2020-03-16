<?php
use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use app\extensions\export\ExportMenu;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use app\component\RecordHelpers;


$this->title = "Contoh Report";
?>
<div class="site-rpeort">
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->render('_search_one_month', ['model' => $searchModel]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?php
                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],
                        'fullname',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{print-report-one-month}',
                            'buttons' => [
                                'print-report-one-month' => function($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-print"></span>', $url, ['data-pjax' => '0']);
                                }
                            ]
                        ]
                    ];
                ?>
                <?= GridView::widget([
                    // 'dataProvider' => $dataProviderPenggiat,
                    'dataProvider' => $dataProvider,
                    'pjax'=>true,
                    'pjaxSettings'=>[
                        'options' => ['id' => 'kv-pjax-container'],
                        'neverTimeout'=>true,
                    ],
                    'columns' => $gridColumns,
                ]); ?>
            </div>
        </div>
    </div>
</div>
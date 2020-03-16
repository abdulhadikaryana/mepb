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
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?php
                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'username',
                            'value' => function($d) {
                                return $d['fullname'] ? $d['fullname'] : $d['username'];
                            }
                        ],
                        [
                            'attribute' => 'penyebarluasan',
                            'value' => 'penyebarluasan'
                        ],
                        [
                            'attribute' => 'konsolidasi',
                            'value' => 'konsolidasi'
                        ],
                        [
                            'attribute' => 'pendataan',
                            'value' => 'pendataan'
                        ],
                        // [
                        //     // 'attribute' => 'fullname',
                        //     'attribute' => 'created_by',
                        //     'label' => 'Penggiat',
                        //     // 'value' => function($d) {
                        //     //     return $d->created_by == null ? $d->username : $d->fullname;
                        //     // }
                        //     'value' => function($d) {
                        //         return $d->fullname;
                        //     }
                        // ],
                        // [
                        //     'label' => 'Penyebarluasan',
                        //     'value' => 'penyebarluasanCount'
                        // ],
                        // [
                        //     'label' => 'Konsolidasi',
                        //     'value' => 'konsolidasiCount'
                        // ],
                        // [
                        //     'label' => 'Penyebarluasan',
                        //     'value' => 'pendataanCount'
                        // ]
                        // [
                        //     'label' => 'Penyebarluasan',
                        //     'value' => function($d) {
                        //         return $d->penyebarluasanCount;
                        //     }
                        // ],
                        // [
                        //     'label' => 'Konsolidasi',
                        //     'value' => function($d) {
                        //         return $d->konsolidasiCount;
                        //     }
                        // ],
                        // [
                        //     'label' => 'Pendataan',
                        //     'value' => function($d) {
                        //         return $d->pendataanCount;
                        //     }
                        // ],
                        // [
                        //     'attribute' => 'konsolidasi',
                        // ],
                        // [
                        //     'attribute' => 'pendataan',
                        // ],
                    ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax'=>true,
                    'pjaxSettings'=>[
                        'options' => ['id' => 'kv-pjax-container'],
                        'neverTimeout'=>true,
                    ],
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Laporan Penggiat Budaya</h3>',
                        'before'=> Html::a('<i class="glyphicon glyphicon-print"></i> Export PDF', ['export-pdf'], ['class' => 'btn btn-info', 'data-pjax' => '0'])
                    ],
                    'exportConfig' => [
                        GridView::PDF => [
                            'filename' => 'exported-data_page_' . date('Y-m-d_H-i-s'),
                        ],
                        // GridView::EXCEL => [
                        //     'filename' => 'exported-data_page_' . date('Y-m-d_H-i-s'),
                        // ],
                    ],
                    'export' => [
                        'label' => 'Page',
                        'fontAwesome' => true,
                    ],
                    'toolbar' => [
                        '{export}'
                    ],
                    'columns' => $gridColumns,
                ]); ?>
            </div>
        </div>
    </div>
</div>
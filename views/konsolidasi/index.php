<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchKonsolidasi */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Konsolidasi Permasalahan';
$this->params['breadcrumbs'][] = $this->title;
$searchModel->start_date = date('d-m-Y');
$searchModel->end_date = date('d-m-Y');
?>
<div class="konsolidasi-index">

    <p>
        <?php if(Helper::checkRoute('create')){ ?>
        <?= Html::a('<i class="fa fa-plus"></i> Konsolidasi Permasalahan', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
        <?php if(Helper::checkRoute('/manual-entry/konsolidasi')){ ?>
        <?= Html::a('<i class="fa fa-plus"></i> Konsolidasi Permasalahan', ['/manual-entry/konsolidasi'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'rowOptions' => function($model, $key, $index, $grid) {
                            if($model->is_rev === 1) {
                                return ['class' => 'danger', 'data-hover' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Silahkan Revisi'];
                            } else {
                                return [];
                            }
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'id',
                            // 'updated_by',
                            // 'created_at',
                            // 'updated_at',
                            [
                                'attribute' => 'tanggal_entri',
                                'value' => function($d) {
                                    return Yii::$app->formatter->format($d->tanggal_entri, 'date');
                                },
                                // 'headerOptions' => [ 'class' => 'col-md-2' ],
                                // 'filter' => DateRangePicker::widget([ 
                                //     'model' => $searchModel, 
                                //     'attribute' => 'date_range',
                                //     'convertFormat' => true,
                                //     'startAttribute' => 'start_date',
                                //     'endAttribute' => 'end_date',
                                //     'pluginOptions' => [
                                //         'locale' => [
                                //             'format' => 'd-m-Y'
                                //         ]
                                //     ]
                                // ])
                            ],
                            [
                                'attribute' => 'created_by',
                                'label' => 'Penggiat',
                                'value' => function($d) {
                                    return $d->createdBy->fullname;
                                }
                            ],
                            'lokasi',
                            'desakel',
                            // 'kecamatan',
                            // 'kabupatenkota',
                            // 'provinsi',
                            'metode',
                            'sub_metode',
                            // 'deskripsi:ntext',
                            // 'solusi',
                            // 'foto1:ntext',
                            // 'foto2:ntext',
                            // 'foto3:ntext',
                            [
                                'attribute' => 'setuju_status',
                                'label' => 'Dinas',
                                'format' => 'raw',
                                'filter' => Html::activeDropDownList($searchModel, 'setuju_status', array(null => 'Pending', 1 => 'Diterima', 0 => 'Ditolak'),['class'=>'form-control','prompt' => 'Dinas']),
                                'value' => 'statusDinasIcon'
                            ],
                            [
                                'attribute' => 'setuju_status_upt',
                                'label' => 'UPT',
                                'format' => 'raw',
                                'filter' => Html::activeDropDownList($searchModel, 'setuju_status_upt', array(null => 'Pending', 1 => 'Diterima', 0 => 'Ditolak'),['class'=>'form-control','prompt' => 'UPT']),
                                'value' => 'statusUptIcon'
                            ],
                            // 'setuju_tanggal',
                            // 'setuju_oleh',
                            // 'version',
                            // 'is_rev',
                            // 'rev_tanggal',
                            // 'rev_komentar:ntext',
                            // 'rev_oleh',
                            // 'rev_no',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                // 'template' => Helper::filterActionColumn('{view}{delete}{update}'),
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function($url, $model) {
                                        if(\Yii::$app->user->can('konsolidasiOwnView', ['model' => $model]) OR \Yii::$app->user->can('SuperAdmin', ['model' => $model])) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                                        }
                                    },
                                    'update' => function($url, $model) {
                                        if(\Yii::$app->user->can('konsolidasiOwnUpdate', ['model' => $model]) OR \Yii::$app->user->can('SuperAdmin', ['model' => $model])) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                                        }
                                    },
                                    'delete' => function($url, $model) {
                                        if(\Yii::$app->user->can('canDelete', ['model' => $model]) OR \Yii::$app->user->can('SuperAdmin', ['model' => $model])) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['data-method'=>'post', 'data-confirm'=>"Are you sure you want to Are you sure you want to delete this item?"]);
                                        }
                                    }
                                ]
                            ]
                        ],
                    ]); ?>
                
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
<?php
$this->registerJs("
$(function () {
  $('[data-hover=\"tooltip\"]').tooltip();
})
");
?>
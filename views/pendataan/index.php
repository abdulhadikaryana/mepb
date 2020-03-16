<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;
use mdm\admin\components\Helper;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchPendataan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pendataan';
$this->params['breadcrumbs'][] = $this->title;
$searchModel->start_date = date('d-m-Y');
$searchModel->end_date = date('d-m-Y');
?>
<div class="pendataan-index">
    <p>
        <?php if(Helper::checkRoute('create')){ ?>
        <?= Html::a('<i class="fa fa-plus"></i> Pendataan', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <?php if(Helper::checkRoute('sync')){ ?>
    <div class="row">
        <div class="col-md-offset-6 col-md-6">
            <div id="sync-form" class="pull-right">
            <?php $form = ActiveForm::begin([
                'id' => 'form-sync',
                'action' => ['sync'],
                'layout' => 'inline'
            ]); ?>
                <?= yii\jui\DatePicker::widget([
                    'dateFormat' => 'dd-MM-yyyy',
                    'name' => 'date_sync',
                    'value' => date('d-m-Y'),
                    'options' => [
                        'class' => 'form-control'
                    ],
                    'clientOptions' => [
                        'changeYear' => true,
                        'changeMonth' => true,
                        'yearRange' => '1945:2099',
                    ]
                    ]);?>
                <?= Html::submitButton('<i class="fa fa-refresh"></i> Sync', ['class' => 'btn btn-warning', 'id' => 'sync-btn']) ?>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php Pjax::begin(['id' => 'data-grid']); ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

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
                            // 'dataid',
                            'obyek',
                            'jumlah_data',
                            // 'foto1:ntext',
                            // 'foto2:ntext',
                            // 'foto3:ntext',
                            // 'setuju_status',
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
                                        if(\Yii::$app->user->can('pendataanOwnView', ['model' => $model]) OR \Yii::$app->user->can('SuperAdmin', ['model' => $model])) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                                        }
                                    },
                                    'update' => function($url, $model) {
                                        if(\Yii::$app->user->can('pendataanOwnUpdate', ['model' => $model]) OR \Yii::$app->user->can('SuperAdmin', ['model' => $model])) {
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
$script = <<< JS
    $('form#form-sync').on('beforeSubmit', function(event, jqXHR, settings) {
        var form = $(this);
        form.find($(".fa")).addClass('fa-spin');
        $('#overlay').removeClass('hidden');
        $('#sync-btn').addClass('disabled');

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function(response) {
                if (response.status == 200) {
                    form.find($(".fa")).removeClass('fa-spin');
                    $('#sync-btn').removeClass('disabled');
                    $('#overlay').addClass('hidden');
                    $.pjax.reload({container:'#data-grid'});
                    alert(response.message);
                } else {
                    form.find($(".fa")).removeClass('fa-spin');
                    $('#sync-btn').removeClass('disabled');
                    $('#overlay').addClass('hidden');
                    $.pjax.reload({container:'#data-grid'});
                    alert(response.message);
                }
            },
            error: function() {
                console.log('Internal server error');
            }
        });

        return false;
    });

    var docHeight = $(document).height();
    var loadingSpin = "<div class='hidden' id='overlay'><i class='fa fa-spinner fa-spin' style='font-size:48px;'></i></div>"; 

    $("body").append(loadingSpin);

    $("#overlay").height(docHeight);

JS;
$this->registerJs($script);

$styleCss = <<<CSS
    #overlay {
        opacity : 0.4;
        position: absolute;
        top: 0;
        left: 0;
        background-color: black;
        width: 100%;
        z-index: 5000;
        padding-left: 50%;
        padding-top: 20%;
    }
CSS;
$this->registerCss($styleCss);
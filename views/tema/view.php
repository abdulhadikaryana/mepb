<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\Tema */

$this->title = $model->nama_tema;
$this->params['breadcrumbs'][] = ['label' => 'Tema', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tema-view">

    <p>
        <?php if(Helper::checkRoute('update')){ ?>
        <?= Html::a('<i class="fa fa-edit"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if(Helper::checkRoute('delete')){ ?>
        <?= Html::a('<i class="fa fa-remove"></i> Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php } ?>
    </p>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'nama_tema',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => $model->statusIcon
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Topik <small>Turunan dari Tema</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <?php if(Helper::checkRoute('/topik/create')){ ?>
                        <li><?= Html::a('<i class="fa fa-plus "></i>', ['/topik/create'], ['class' => 'showModalButton']) ?></li>
                        <?php } ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php Pjax::begin(['id' => 'jenis-grid']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderTopik,
                        'tableOptions' =>['class' => 'table table-striped table-bordered'],
                        'summary' => '',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'nama_topik',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function ($d) {
                                    return $d->statusIcon;
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'options' => ['width' => 50],
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['/topik/update', 'id' => $model->id]));
                                    },
                                    'delete' => function($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['/topik/delete', 'id' => $model->id]), ['data-pjax' => 0, 'data-confirm' => 'Are you sure you want to delete this item?', 'data-method' => 'post']);
                                    }
                                ]
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'header' => '<h4>Topik</h4>',
        'id' => 'modal',
        'size' => 'modal-md',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]);
    echo '<div id="modalContent"></div>';
    Modal::end();

$script = <<< JS
    $('.showModalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('href'));
            return false;
    });
JS;
$this->registerJs($script);
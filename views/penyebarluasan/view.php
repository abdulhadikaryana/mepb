<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\Penyebarluasan */

$this->title = $model->lokasi;
$this->params['breadcrumbs'][] = ['label' => 'Penyebarluasan Informasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penyebarluasan-view">
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
        <div class="col-md-8 col-sm-8 col-xs-8">
            <div class="x_panel">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'tanggal_entri',
                            'value' => Yii::$app->formatter->format($model->tanggal_entri, 'date')
                        ],
                        [
                            'attribute' => 'Penggiat',
                            'value' => $model->createdBy->fullname
                        ],
                        'lokasi',
                        'desakel',
                        'kecamatan',
                        'kabupatenkota',
                        'provinsi',
                        'metode',
                        'tema',
                        'topik',
                        'audiens',
                        'deskripsi:ntext',
                        [
                            'attribute' => 'setuju_status',
                            'format' => 'raw',
                            'value' => $model->statusDinasIcon
                        ] 
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php if($model->is_rev == 1) {?>
            <div class="x_panel panel-danger">
                <div class="x_title">
                    <h2>Revisi</h2>
                    <div class="pull-right"><i class="fa fa-comments-o"></i></div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=$model->rev_komentar?>
                </div>
                <div class="pull-right">
                    Oleh: <?=$model->fullnameDinas?>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="row">
        <?php if(!empty($model->foto1)) {?>
        <div class="col-md-4">
            <img src="<?=$model->foto1 ?>" class="img-responsive" alt="Responsive image">
        </div>
        <?php } ?>
        <?php if(!empty($model->foto2)) {?>
        <div class="col-md-4">
            <img src="<?=$model->foto2 ?>" class="img-responsive" alt="Responsive image">
        </div>
        <?php } ?>
        <?php if(!empty($model->foto3)) {?>
        <div class="col-md-4">
            <img src="<?=$model->foto3 ?>" class="img-responsive" alt="Responsive image">
        </div>
        <?php } ?>
    </div>
</div>
<?php
$script = <<< JS
$(function () {
  $('[data-hover=\"tooltip\"]').tooltip();
})
JS;

$this->registerJs($script);
?>
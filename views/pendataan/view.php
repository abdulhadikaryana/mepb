<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\Pendataan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pendataan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pendataan-view">
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
                        [
                            'attribute' => 'tanggal_entri',
                            'value' => Yii::$app->formatter->format($model->tanggal_entri, 'date')
                        ],
                        [
                            'attribute' => 'Penggiat',
                            'value' => $model->createdBy->fullname
                        ],
                        'name',
                        'lokasi',
                        'desakel',
                        'kecamatan',
                        'kabupatenkota',
                        'provinsi',
                        'dataid',
                        'obyek',
                        'jumlah_data',
                    ],
                ]) ?>
            </div>
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

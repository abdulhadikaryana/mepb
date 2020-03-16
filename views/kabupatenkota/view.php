<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\Kabupatenkota */

$this->title = $model->nama_kabkota;
$this->params['breadcrumbs'][] = ['label' => 'Kabupaten/Kota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kabupatenkota-view">

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
                        'nama_kabkota',
                        'provinsi.nama_provinsi',
                        'tipe',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

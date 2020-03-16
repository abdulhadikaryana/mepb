<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kabupatenkota */

$this->title = 'Ubah Kabupaten/Kota: ' . $model->nama_kabkota;
$this->params['breadcrumbs'][] = ['label' => 'Kabupaten/Kota', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_kabkota, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="kabupatenkota-update">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>

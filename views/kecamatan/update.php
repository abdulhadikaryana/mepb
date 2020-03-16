<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kecamatan */

$this->title = 'Ubah Kecamatan: ' . $model->nama_kecamatan;
$this->params['breadcrumbs'][] = ['label' => 'Kecamatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_kecamatan, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="kecamatan-update">
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

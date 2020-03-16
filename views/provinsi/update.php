<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Provinsi */

$this->title = 'Ubah Provinsi: ' . $model->nama_provinsi;
$this->params['breadcrumbs'][] = ['label' => 'Provinsis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_provinsi, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="provinsi-update">
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

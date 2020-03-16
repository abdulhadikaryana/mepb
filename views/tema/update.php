<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tema */

$this->title = 'Ubah Tema: ' . $model->nama_tema;
$this->params['breadcrumbs'][] = ['label' => 'Tema', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="tema-update">
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

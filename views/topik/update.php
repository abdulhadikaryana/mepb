<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Topic */

$this->title = 'Ubah Topik: ' . $model->nama_topik;
$this->params['breadcrumbs'][] = ['label' => 'Topik', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_topik, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="topic-update">
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

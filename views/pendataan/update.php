<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pendataan */

$this->title = 'Update Pendataan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pendataans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pendataan-update">
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

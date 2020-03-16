<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pendataan */

$this->title = 'Tambah Pendataan';
$this->params['breadcrumbs'][] = ['label' => 'Pendataan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pendataan-create">
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

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Kabupatenkota */

$this->title = 'Tambah Kabupaten/Kota';
$this->params['breadcrumbs'][] = ['label' => 'Kabupaten/Kota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kabupatenkota-create">
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

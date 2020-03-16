<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Penyebarluasan */

$this->title = 'Tambah Penyebarluasan Informasi';
$this->params['breadcrumbs'][] = ['label' => 'Penyebarluasan Informasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penyebarluasan-create">
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

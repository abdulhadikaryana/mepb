<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

$this->title = 'Ubah Profile: ' . $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['manual-view']];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="profile-update">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?= $this->render('_manual-form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>

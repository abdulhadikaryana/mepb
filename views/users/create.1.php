<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Tambah Pengguna Admin';
$this->params['breadcrumbs'][] = ['label' => 'Pengguna Admin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-admin-create">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?= $this->render('_form', [
                    'userForm' => $userForm,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Ubah Pengguna Admin: ' . $modelUser->username;
$this->params['breadcrumbs'][] = ['label' => 'Pengguna', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelUser->username, 'url' => ['view', 'id' => $modelUser->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="user-update">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?= $this->render('_form', [
                    // 'userForm' => $userForm,
                    'modelUser' => $modelUser,
                    'modelProfile' => $modelProfile
                ]) ?>
            </div>
        </div>
    </div>
</div>

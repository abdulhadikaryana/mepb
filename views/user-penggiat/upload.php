<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Kabupatenkota */
/* @var $form yii\widgets\ActiveForm */
$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Pengguna Penggiat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-penggiat-upload">

    <?php $form = ActiveForm::begin([
        'options' => array('enctype' => 'multipart/form-data')
    ]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                'options' => [
                    'multiple' => true,
                    'accept' => '.csv*'
                ],
                'pluginOptions' => [
                    'showUpload' => false,
                    'showRemove' => false,
                ]
            ]);?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-cloud"></i> Unggah' , ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

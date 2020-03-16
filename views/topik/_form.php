<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topik-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'tema_id')->widget(Select2::classname(), [
                'data' => $model->listTema,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Pilih tema ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nama_topik')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=$form->field($model, 'status')->widget(SwitchInput::classname(),[
                'pluginOptions' => [
                    'size' => 'mini',
                ]
            ]);?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-edit"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

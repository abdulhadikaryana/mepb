<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Thema */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tema-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nama_tema')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'flag')->radioList(array('1'=>'Penyebarluasan Informasi',2=>'Penyelesaian Masalah')); ?>
        </div>
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

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pendataan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pendataan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'tanggal_entri')->textInput() ?>

    <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desakel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kecamatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kabupatenkota')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provinsi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'obyek')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah_data')->textInput() ?>

    <?= $form->field($model, 'foto1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'foto2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'foto3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'setuju_status')->textInput() ?>

    <?= $form->field($model, 'setuju_tanggal')->textInput() ?>

    <?= $form->field($model, 'setuju_oleh')->textInput() ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'is_rev')->textInput() ?>

    <?= $form->field($model, 'rev_tanggal')->textInput() ?>

    <?= $form->field($model, 'rev_komentar')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rev_oleh')->textInput() ?>

    <?= $form->field($model, 'rev_no')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

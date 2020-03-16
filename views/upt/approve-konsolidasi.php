<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Konsolidasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="approve-konsolidasi-form">
    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
    ]); ?>
    <div class="row">
        <div class="col-md-12">
            <p>Dengan menekan tombol <strong>Simpan</strong>, maka Anda sudah memeriksa dengan seksama kebenaran data ini.</p>
            <p>Apakah Anda Yakin ingin menyetujui laporan ini?</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'setuju_status_upt')->radioList(array(1=>'Setuju', 0=>'Tolak'))->label('Setuju/Tolak'); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-thumbs-up"></i> Simpan', ['class' => 'btn btn-primary']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-thumbs-down"></i> Kembali</button>
    </div>

    <?php ActiveForm::end(); ?>
</div>
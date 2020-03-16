<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Kecamatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kecamatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'provinsi_id')->widget(Select2::classname(), [
                'data' => $model->listProvinsi,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Pilih provinsi ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
        <div class="col-md-6">
            <?=$form->field($model, 'kabkota_id')->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'data'=>$model->allKabupatenKota,
                    'options' => ['placeholder'=>'Pilih Kabupaten/Kota ...'],
                    'select2Options'=>[
                        'pluginOptions'=>[
                            'allowClear'=>true,
                        ],
                    ],
                    'pluginOptions'=>[
                        'depends'=>['kecamatan-provinsi_id'],
                        'url'=>Url::to(['/location/kabupatenkota'])
                    ]
                ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'kode_kecamatan')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'nama_kecamatan')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-edit"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

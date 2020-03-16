<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'enableAjaxValidation' => true,
        'options' => array('enctype' => 'multipart/form-data')
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
        </div>
        <?php if(\Yii::$app->user->identity->group === 20 || \Yii::$app->user->identity->group === 30) {?>
        <div class="col-md-4">
            <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>
        </div>
        <?php } ?>
        <div class="col-md-4">
            <?= $form->field($model,'birthdate')->widget(yii\jui\DatePicker::className(),[
                'dateFormat' => 'dd-MM-yyyy',
                'options' => [
                    'class' => 'form-control',
                ],
                'clientOptions' => [
                    'changeYear' => true,
                    'changeMonth' => true,
                    'yearRange' => '1945:2099',
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'phone')->widget(MaskedInput::classname(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 12, 'greedy' => false]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'provinsi_id')->widget(Select2::classname(), [
                'data' => $model->listProvinsi,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Pilih provinsi ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
        <div class="col-md-4">
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
                        'depends'=>['profile-provinsi_id'],
                        'url'=>Url::to(['/location/kabupatenkota'])
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-4">
            <?=$form->field($model, 'kecamatan_id')->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'data'=>$model->allKecamatan,
                    'options' => ['placeholder'=>'Pilih Kecamatan ...'],
                    'select2Options'=>[
                        'pluginOptions'=>[
                            'allowClear'=>true,
                        ],
                    ],
                    'pluginOptions'=>[
                        'depends'=>['profile-kabkota_id'],
                        'url'=>Url::to(['/location/kecamatan'])
                    ]
                ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=$form->field($model, 'gender')->radioList([
                "M" => 'Pria', 
                "F" => 'Wanita'
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'twitter')->widget(MaskedInput::classname(), [
                'mask' => '@*{1,50}'
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'photo')->widget(FileInput::classname(), [
                'options' => ['multiple' => false, 'accept' => 'image/*'],
                'pluginOptions' => [
                    'showUpload' => false,
                    'showRemove' => false,
                    'maxImageWidth' => 400,
                    'maxImageHeight' => 400,
                    'resizePreference' => 'height',
                    'maxFileCount' => 1,
                    'resizeImage' => true,
                    'previewFileType' => 'image',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'allowedFileExtensions' => ['jpg', 'jpeg', 'gif', 'png']
                ]
            ]);?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-edit"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

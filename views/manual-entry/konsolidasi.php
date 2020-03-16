<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Konsolidasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="konsolidasi-form">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'enableAjaxValidation' => true,
        'options' => array('enctype' => 'multipart/form-data')
    ]); ?>
    <div class="x_panel">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'created_by')->widget(Select2::classname(), [
                    'data' => $model->listPenggiat,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Pilih penggiat ...'],
                    'disabled' => !$model->isNewRecord,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model,'tanggal_entri')->widget(yii\jui\DatePicker::className(),[
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
                <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true, 'disabled' => $model->isNewRecord ? false : true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'desakel')->textInput(['maxlength' => true, 'disabled' => $model->isNewRecord ? false : true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'provinsi')->widget(Select2::classname(), [
                    'data' => $model->listProvinsi,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Pilih provinsi ...'],
                    'disabled' => !$model->isNewRecord,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
            </div>
            <div class="col-md-4">
                <?=$form->field($model, 'kabupatenkota')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$model->allKabupatenKota,
                        'options' => ['placeholder'=>'Pilih Kabupaten/Kota ...'],
                        'disabled' => !$model->isNewRecord,
                        'select2Options'=>[
                            'pluginOptions'=>[
                                'allowClear'=>true,
                            ],
                        ],
                        'pluginOptions'=>[
                            'depends'=>['basekonsolidasi-provinsi'],
                            'url'=>Url::to(['/location/kabupatenkota'])
                        ]
                    ]);
                ?>
            </div>
            <div class="col-md-4">
                <?=$form->field($model, 'kecamatan')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$model->allKecamatan,
                        'options' => ['placeholder'=>'Pilih Kecamatan ...'],
                        'disabled' => !$model->isNewRecord,
                        'select2Options'=>[
                            'pluginOptions'=>[
                                'allowClear'=>true,
                            ],
                        ],
                        'pluginOptions'=>[
                            'depends'=>['basekonsolidasi-kabupatenkota'],
                            'url'=>Url::to(['/location/kecamatan'])
                        ]
                    ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'metode')->widget(Select2::classname(), [
                    'data' => $model->listTema,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Pilih Metode ...'],
                    'disabled' => !$model->isNewRecord,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
            </div>
            <div class="col-md-6">
                <?=$form->field($model, 'sub_metode')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$model->listTopik,
                        'options' => ['placeholder'=>'Pilih Topik ...'],
                        'disabled' => !$model->isNewRecord,
                        'select2Options'=>[
                            'pluginOptions'=>[
                                'allowClear'=>true,
                            ],
                        ],
                        'pluginOptions'=>[
                            'depends'=>['basekonsolidasi-metode'],
                            'url'=>Url::to(['/location/opsi'])
                        ]
                    ]);
                ?>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-6">
                <?= $form->field($model, 'deskripsi')->textarea(['rows' => 6]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'solusi')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'foto1')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*'
                    ],
                    'disabled' => !$model->isNewRecord,
                    'pluginOptions' => [
                        'showUpload' => false,
                        'showRemove' => false,
                        'previewFileType' => 'image',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'gif', 'png'],
                        'resizeImage'=>true,
                        'maxImageWidth' => 2000,
                        'maxImageHeight' => 2000,
                        'resizePreference' => 'width',
                    ]
                ]);?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'foto2')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*'
                    ],
                    'disabled' => !$model->isNewRecord,
                    'pluginOptions' => [
                        'showUpload' => false,
                        'showRemove' => false,
                        'previewFileType' => 'image',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'gif', 'png'],
                        'resizeImage'=>true,
                        'maxImageWidth' => 2000,
                        'maxImageHeight' => 2000,
                        'resizePreference' => 'width',
                    ]
                ]);?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'foto3')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*'
                    ],
                    'disabled' => !$model->isNewRecord,
                    'pluginOptions' => [
                        'showUpload' => false,
                        'showRemove' => false,
                        'previewFileType' => 'image',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'gif', 'png'],
                        'resizeImage'=>true,
                        'maxImageWidth' => 2000,
                        'maxImageHeight' => 2000,
                        'resizePreference' => 'width',
                    ]
                ]);?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-edit"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
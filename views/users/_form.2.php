<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\widgets;
use kartik\widgets\DepDrop;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id' => $userForm->user->formName(),
        'enableAjaxValidation' => true,
    ]); ?>
    <?= $userForm->errorSummary($form); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($userForm->user, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6"
            <?= $form->field($userForm->user, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?php //if($userForm->user->isNewRecord){ ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($userForm->user, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($userForm->user, 'newPasswordConfirm')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?php //} else {?>
    <!-- <div class="row">
        <div class="col-md-6">
            <?php // $form->field($userForm->user, 'editPassword')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php// $form->field($userForm->user, 'editPasswordConfirm')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div> -->
    <?php //} ?>
    <div class="row">
        <div class="col-md-4">
            <?php //echo $form->field($model, 'status')->widget(SwitchInput::classname(),[
            //     'pluginOptions' => [
            //         'size' => 'mini',
            //     ]
            // ]);?>
            <?=$form->field($userForm->user, 'status')->checkbox(); ?>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Profile</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($userForm->profile, 'fullname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($userForm->profile,'birthdate')->widget(yii\jui\DatePicker::className(),[
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
                    <?= $form->field($userForm->profile, 'address')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($userForm->profile, 'phone')->widget(MaskedInput::classname(), [
                        'mask' => '9',
                        'clientOptions' => ['repeat' => 12, 'greedy' => false]
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($userForm->profile, 'provinsi_id')->widget(Select2::classname(), [
                        'data' => $userForm->profile->listProvinsi,
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => ['placeholder' => 'Pilih provinsi ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                </div>
                <div class="col-md-4">
                    <?=$form->field($userForm->profile, 'kabkota_id')->widget(DepDrop::classname(), [
                            'type'=>DepDrop::TYPE_SELECT2,
                            'data'=>$userForm->profile->allKabupatenKota,
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
                    <?=$form->field($userForm->profile, 'kecamatan_id')->widget(DepDrop::classname(), [
                            'type'=>DepDrop::TYPE_SELECT2,
                            'data'=>$userForm->profile->allKecamatan,
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
                    <?=$form->field($userForm->profile, 'gender')->radioList([
                        "M" => 'Pria', 
                        "F" => 'Wanita'
                    ]);?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($userForm->profile, 'twitter')->widget(MaskedInput::classname(), [
                        'mask' => '@*{1,50}'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($userForm->user->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-edit"></i> Ubah', ['class' => $userForm->user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

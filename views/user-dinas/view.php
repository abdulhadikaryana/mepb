<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Pengguna Dinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-dinas-view">

    <p>
        <?= Html::a('<i class="fa fa-edit"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-remove"></i> Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Diri</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'username',
                            'email:email',
                            [
                                'attribute' => 'created_at',
                                'value' => Yii::$app->formatter->format($model->created_at, 'datetime'),
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => Yii::$app->formatter->format($model->updated_at, 'datetime'),
                            ],
                            [
                                'attribute' => 'wilayah_kerja',
                                'value' => $model->wilayahKerjaDinas
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => $model->statusIcon
                            ],
                        ],
                    ]) ?>

                    <?php $form = ActiveForm::begin([]); ?>
                    <?php
                    echo $form->field($authAssignment, 'item_name')->widget(Select2::classname(), [
                        'data' => $authItems,
                        'options' => [
                            'placeholder' => 'Select role ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ])->label('Role'); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Assign', [
                            'class' => $authAssignment->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                            //'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
                        ]) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'label' => 'Nama Lengkap',
                                'value' => $model->profiles ? $model->profiles->fullname : null,
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'Tanggal Lahir',
                                'value' => $model->profiles ? $model->profiles->birthdate : null,
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'Alamat',
                                'value' => $model->profiles ? $model->profiles->address : null,
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'No. Telp.',
                                'value' => $model->profiles ? $model->profiles->phone : null,
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'Kecamatan',
                                'value' => $model->profiles ? $model->profiles->kecamatan->nama_kecamatan : null,
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'Kabupaten/Kota',
                                'value' => $model->profiles ? $model->profiles->kabkota->nama_kabkota : null,
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'Provinsi',
                                'value' => $model->profiles ? $model->profiles->provinsi->nama_provinsi : null,
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'Jenis Kelamin',
                                'value' => $model->profiles ? $model->profiles->gender : null,
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'Twitter',
                                'value' => $model->profiles ? $model->profiles->twitter : null,
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Pengguna Admin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

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
                        // [
                        //     'attribute' => 'wilayah_kerja',
                        //     'value' => $model->wilayahKerja
                        // ],
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
        </div>
    </div>
</div>

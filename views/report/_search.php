<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model app\models\search\ProvinsiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php
        $model->start_date = date('d-m-Y');
        $model->end_date = date('d-m-Y');

        echo $form->field($model, 'date_range', [
            'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
            'options'=>['class'=>'drp-container form-group'],
        ])->widget(DateRangePicker::classname(), [
            'useWithAddon'=>true,
            'convertFormat'=>true,
            'startAttribute' => 'start_date',
            'endAttribute' => 'end_date',
            'pluginOptions' => [
                'locale' => [
                    'format' => 'd-m-Y',
                    'separator' => ' TO '
                ]
            ]
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
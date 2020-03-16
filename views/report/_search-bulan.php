<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\search\ProvinsiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['report-penggiat'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'month')->widget(Select2::classname(), [
                'data' => array(
                    '01' => 'Januari', 
                    '02' => 'Februari', 
                    '03' => 'Maret', 
                    '04' => 'April', 
                    '05' => 'Mei', 
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember'
                ),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Pilih Bulan ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ])->label('Bulan');?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'year')->widget(Select2::classname(), [
                'data' => array(
                    '2017' => '2017', 
                    '2018' => '2018', 
                    '2019' => '2019', 
                    '2020' => '2020', 
                    '2021' => '2021', 
                    '2022' => '2022',
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                    '2026' => '2026',
                    '2027' => '2027',
                    '2028' => '2028',
                    '2029' => '2029',
                    '2030' => '2030'
                ),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Pilih Tahun ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Tahun');?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-print"></i> Cetak', ['print-report-penggiat'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
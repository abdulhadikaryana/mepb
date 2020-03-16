<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchKabupatenkota */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kabupaten/Kota';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kabupatenkota-index">

    <p>
        <?php if(Helper::checkRoute('create')){ ?>
        <?= Html::a('<i class="fa fa-plus"></i> Kabupaten/Kota', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
        <?php if(Helper::checkRoute('upload')){ ?>
        <?= Html::a('<i class="fa fa-cloud"></i> Unggah Massal', ['upload'], ['class' => 'btn btn-warning']) ?>
        <?php } ?>
    </p>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'kode_kabkota',
                            'nama_kabkota',
                            [
                                'attribute' => 'provinsi_id',
                                'value' => 'provinsi.nama_provinsi'
                            ],
                            'tipe',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

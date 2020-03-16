<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchProvinsi */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Provinsi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provinsi-index">

    <p>
        <?php if(Helper::checkRoute('create')){ ?>
        <?= Html::a('<i class="fa fa-plus"></i> Provinsi', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'kode_provinsi',
                        'nama_provinsi',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

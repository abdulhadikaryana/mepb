<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchTopic */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topik';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topik-index">

    <p>
        <?php if(Helper::checkRoute('create')){ ?>
        <?= Html::a('<i class="fa fa-plus"></i> Topik', ['create'], ['class' => 'btn btn-success']) ?>
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

                        [
                            'attribute' => 'nama_topik',
                            'headerOptions' => ['width' => '45%'],
                        ],
                        [
                            'attribute' => 'tema_id',
                            'value' => 'tema.nama_tema',
                            'headerOptions' => ['width' => '35%'],
                        ],
                        [
                            'attribute' => 'status',
                            'headerOptions' => ['width' => '12%'],
                            'format' => 'raw',
                            'filter' => Html::activeDropDownList($searchModel, 'status', array(10 => 'Aktif', 0 => 'Non Aktif'),['class'=>'form-control','prompt' => '-- Status --']),
                            'value' => function ($d) {
                                return $d->statusIcon;
                            }
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '8%'],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

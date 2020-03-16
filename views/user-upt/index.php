<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengguna Upt';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-upt-index">

   <p>
        <?= Html::a('<i class="fa fa-plus"></i> Pengguna', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-cloud"></i> Unggah Massal', ['upload'], ['class' => 'btn btn-warning']) ?>
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

                            'username',
                            'email:email',
                            [
                                'attribute' => 'status',
                                'headerOptions' => ['width' => '12%'],
                                'format' => 'raw',
                                'filter' => Html::activeDropDownList($searchModel, 'status', array(10 => 'Aktif', 0 => 'Non Aktif'),['class'=>'form-control','prompt' => '-- Status --']),
                                'value' => function ($d) {
                                    return $d->statusIcon;
                                }
                            ],

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

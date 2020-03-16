<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchPendataan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pendataan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pendataan-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'tanggal_entri',
                                'value' => function($d) {
                                    return Yii::$app->formatter->format($d->tanggal_entri, 'date');
                                }
                            ],
                            'lokasi',
                            'desakel',
                            // 'kecamatan',
                            // 'kabupatenkota',
                            // 'provinsi',
                            // 'dataid',
                            'obyek',
                            'jumlah_data',
                            // 'foto1:ntext',
                            // 'foto2:ntext',
                            // 'foto3:ntext',
                            // 'setuju_status',
                            // 'setuju_tanggal',
                            // 'setuju_oleh',
                            // 'version',
                            // 'is_rev',
                            // 'rev_tanggal',
                            // 'rev_komentar:ntext',
                            // 'rev_oleh',
                            // 'rev_no',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                // 'template' => Helper::filterActionColumn('{view}{delete}{update}'),
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function($url, $model) {
                                        if(\Yii::$app->user->can('pendataanOwnView', ['model' => $model]) OR \Yii::$app->user->can('SuperAdmin', ['model' => $model])) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                                        }
                                    },
                                    'update' => function($url, $model) {
                                        if(\Yii::$app->user->can('pendataanOwnUpdate', ['model' => $model]) OR \Yii::$app->user->can('SuperAdmin', ['model' => $model])) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                                        }
                                    },
                                    'delete' => function($url, $model) {
                                        if(\Yii::$app->user->can('canDelete', ['model' => $model]) OR \Yii::$app->user->can('SuperAdmin', ['model' => $model])) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['data-method'=>'post', 'data-confirm'=>"Are you sure you want to Are you sure you want to delete this item?"]);
                                        }
                                    }
                                ]
                            ]
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
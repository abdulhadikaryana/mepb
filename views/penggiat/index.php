<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use app\component\RecordHelpers;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchPenyebarluasan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Halaman Mengetahui Upt';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upt-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?php Pjax::begin(); ?>
                <div class="x_title">
                    <?php if(RecordHelpers::userHasProfile($model->id)) { ?>
                    <h2>Laporan Penggiat Wilayah Kerja: <?=$model->profiles->fullname?></h2>
                    <?php } else { ?>
                    <h2>Laporan Penggiat Wilayah Kerja: <?=$model->username?></h2>
                    <?php } ?>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                            <a href="#" role="button" aria-expanded="false"><i class="fa fa-print"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'fullname',
                            'label' => 'Penggiat'
                        ],
                        [
                            'attribute' => 'penyebarluasan',
                            'value' => function($d) {
                                return count($d->penyebarluasan);
                            }
                        ],
                        [
                            'attribute' => 'konsolidasi',
                            'value' => function($d) {
                                return count($d->konsolidasi);
                            }
                        ],
                        [
                            'attribute' => 'pendataan',
                            'value' => function($d) {
                                return count($d->pendataan);
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
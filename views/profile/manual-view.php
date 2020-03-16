<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\Provinsi */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provinsi-view">
    <p>
        <?= Html::a('<i class="fa fa-edit"></i> Ubah', ['manual-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'fullname',
                        'jabatan',
                        [
                            'attribute' => 'birthdate',
                            'value' => Yii::$app->formatter->format($model->birthdate, 'date')
                        ],
                        'address',
                        'phone',
                        'kecamatan.nama_kecamatan',
                        'kabkota.nama_kabkota',
                        'provinsi.nama_provinsi',
                        'twitter',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\Topik */

$this->title = $model->nama_topik;
$this->params['breadcrumbs'][] = ['label' => 'Topik', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topik-view">

    <p>
        <?php if(Helper::checkRoute('update')){ ?>
        <?= Html::a('<i class="fa fa-edit"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?php if(Helper::checkRoute('delete')){ ?>
        <?= Html::a('<i class="fa fa-remove"></i> Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php } ?>
    </p>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'tema.nama_tema',
                        'nama_topik',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => $model->statusIcon
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

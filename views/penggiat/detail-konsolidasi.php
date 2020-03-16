<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Konsolidasi */

$this->title = $model->lokasi;
$this->params['breadcrumbs'][] = ['label' => 'Konsolidasi', 'url' => ['/penggiat/konsolidasi']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konsolidasi-view">
    <p>
        <?= Html::a('<i class="fa fa-edit"></i> Ubah', ['/penggiat/edit-konsolidasi', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Detail: <small><?=$model->lokasi?></small></h2>
                    <div class="clearfix"></div>
                </div>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'tanggal_entri',
                            'value' => Yii::$app->formatter->format($model->tanggal_entri, 'date')
                        ],
                        [
                            'attribute' => 'created_by',
                            'value' => $model->fullname
                        ],
                        'desakel',
                        'kecamatan',
                        'kabupatenkota',
                        'provinsi',
                        'metode',
                        'sub_metode',
                        'deskripsi:ntext',
                        'solusi',
                        [
                            'attribute' => 'setuju_status',
                            'format' => 'raw',
                            'value' => $model->statusUptIcon
                        ]
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php if($model->is_rev == 1) {?>
            <div class="x_panel panel-danger">
                <div class="x_title">
                    <h2>Revisi</h2>
                    <div class="pull-right"><i class="fa fa-comments-o"></i></div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=$model->rev_komentar?>
                </div>
                <div class="pull-right">
                    Oleh: <?=$model->fullnameDinas?>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="row">
        <?php if(!empty($model->foto1)) {?>
        <div class="col-md-4">
            <img src="<?=$model->foto1 ?>" class="img-responsive" alt="Responsive image">
        </div>
        <?php } ?>
        <?php if(!empty($model->foto2)) {?>
        <div class="col-md-4">
            <img src="<?=$model->foto2 ?>" class="img-responsive" alt="Responsive image">
        </div>
        <?php } ?>
        <?php if(!empty($model->foto3)) {?>
        <div class="col-md-4">
            <img src="<?=$model->foto3 ?>" class="img-responsive" alt="Responsive image">
        </div>
        <?php } ?>
    </div>
</div>
<?php

Modal::begin([
    'id' => 'commentModal',
    'header' => '<h4 class="modal-title">...</h4>',
    // 'footer' => '<span class="label label-default">P</span> Pending <span class="label label-success">V</span> Setuju <span class="label label-danger">X</span> Ditolak',
    'size' => 'modal-md'
]);

echo '...';

Modal::end();

Modal::begin([
    'id' => 'approveModal',
    'header' => '<h4 class="modal-title">...</h4>',
    // 'footer' => '<span class="label label-default">P</span> Pending <span class="label label-success">V</span> Setuju <span class="label label-danger">X</span> Ditolak',
    'size' => 'modal-md'
]);

echo '...';

Modal::end();

$script = <<< JS
$(function () {
  $('[data-hover=\"tooltip\"]').tooltip();
})

$('#approveModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget)
    var modal = $(this)
    var title = button.data('title')
    var href = button.attr('href')
    modal.find('.modal-title').html(title)
    modal.find('.modal-body').html('<i class="fa fa-spiner fa-spin"></i>')
    $.post(href).done(function(data){
        modal.find('.modal-body').html(data)
    });
});

$('#commentModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget)
    var modal = $(this)
    var title = button.data('title')
    var href = button.attr('href')
    modal.find('.modal-title').html(title)
    modal.find('.modal-body').html('<i class="fa fa-spiner fa-spin"></i>')
    $.post(href).done(function(data){
        modal.find('.modal-body').html(data)
    });
});
JS;

$this->registerJs($script);
?>
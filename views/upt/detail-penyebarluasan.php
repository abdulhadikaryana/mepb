<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Konsolidasi */

$this->title = $model->lokasi;
$this->params['breadcrumbs'][] = ['label' => 'Konsolidasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konsolidasi-view">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Detail: <small><?=$model->lokasi?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li >
                            <?=Html::a('<i class="fa fa-thumbs-up"></i>', ['approve-penyebarluasan', 'id' => $model->id], ['class' => 'btn btn-xs','data-toggle' => 'modal', 'data-target' => '#approveModal', 'data-title' => 'Pernyataan'])?>
                        </li>
                        <li >
                            <?=Html::a('<i class="fa fa-comment"></i>', ['comment-penyebarluasan', 'id' => $model->id], ['class' => 'btn btn-xs','data-toggle' => 'modal', 'data-target' => '#commentModal', 'data-title' => 'Masukan/Revisi'])?>
                        </li>
                    </ul>
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
                        'tema',
                        'topik',
                        'deskripsi:ntext',
                        [
                            'attribute' => 'setuju_status_upt',
                            'format' => 'raw',
                            'value' => $model->statusUptIcon
                        ]
                    ],
                ]) ?>
            </div>
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
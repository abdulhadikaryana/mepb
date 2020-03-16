<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchPenyebarluasan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penyebarluasan Informasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dinas-penyebarluasan-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?php Pjax::begin(); ?>    
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'rowOptions' => function($model, $key, $index, $grid) {
                            if($model->is_rev == 0) {
                                return ['class' => 'success'];
                            } else {
                                return [];
                            }
                        },
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
                            // 'metode',
                            // 'tema',
                            'topik',
                            'audiens',
                            // 'deskripsi:ntext',
                            // 'foto1:ntext',
                            // 'foto2:ntext',
                            // 'foto3:ntext',
                            [
                                'attribute' => 'setuju_status',
                                'label' => 'Dinas',
                                'format' => 'raw',
                                'value' => 'statusDinasIcon'
                            ],
                            [
                                'attribute' => 'setuju_status_upt',
                                'label' => 'UPT',
                                'format' => 'raw',
                                'value' => 'statusUptIcon'
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                // 'template' => Helper::filterActionColumn('{view}{delete}{update}'),
                                'template' => '{view-penyebarluasan} {edit-penyebarluasan}',
                                'buttons' => [
                                    'view-penyebarluasan' => function($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                                    },
                                    'edit-penyebarluasan' => function($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
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
<?php

Modal::begin([
    'id' => 'approveModal',
    'header' => '<h4 class="modal-title">...</h4>',
    // 'footer' => '<span class="label label-default">P</span> Pending <span class="label label-success">V</span> Setuju <span class="label label-danger">X</span> Ditolak',
    'size' => 'modal-md'
]);

echo '...';

Modal::end();

$this->registerJs("
$(function () {
  $('[data-hover=\"tooltip\"]').tooltip();
})
");

$script = <<< JS
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
JS;

$this->registerJs($script);
?>
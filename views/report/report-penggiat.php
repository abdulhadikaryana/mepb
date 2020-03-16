<?php
use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
// use app\extensions\export\ExportMenu;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use app\component\RecordHelpers;


$this->title = "Contoh Report";
?>
<div class="site-rpeort">
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->render('_search-bulan', ['model' => $searchModel]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?php
                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'tanggal_entri',
                            'value' => function($d) {
                                return Yii::$app->formatter->format($d['tanggal_entri'], 'date');
                            }
                        ],
                        [
                            'attribute' => 'kegiatan',
                            'value' => function($d) {
                                return ucwords($d['kegiatan']); 
                            }
                        ],
                        [
                            'attribute' => 'obyek',
                            'label' => 'Tema/Obyek/Metode'
                        ],
                        [
                            'attribute' => 'topik',
                            'label' => 'Topik/Nama/Sub Metode'
                        ],
                        [
                            'attribute' => 'kecamatan',
                            'label' => 'Lokasi'
                        ],
                    ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                ]); ?>
            </div>
        </div>
    </div>
</div>
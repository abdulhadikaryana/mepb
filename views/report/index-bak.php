<?php
use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use app\extensions\export\ExportMenu;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use app\component\RecordHelpers;


$this->title = "Contoh Report";
?>
<div class="site-rpeort">
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <?php
                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'fullname',
                            'label' => 'Penggiat',
                            'value' => function($d) {
                                return $d->fullname == null ? $d->username : $d->fullname;
                            }
                        ],
                        [
                            'attribute' => 'penyebarluasan',
                        ],
                        [
                            'attribute' => 'konsolidasi',
                        ],
                        [
                            'attribute' => 'pendataan',
                        ],
                    ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax'=>true,
                    'pjaxSettings'=>[
                        'options' => ['id' => 'kv-pjax-container'],
                        'neverTimeout'=>true,
                    ],
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Laporan Penggiat Budaya</h3>',
                        'before'=> Html::a('<i class="glyphicon glyphicon-print"></i> Export PDF', ['export-pdf'], ['class' => 'btn btn-info', 'data-pjax' => '0'])
                    ],
                    'exportConfig' => [
                        GridView::PDF => [
                            'filename' => 'exported-data_page_' . date('Y-m-d_H-i-s'),
                        ],
                        // GridView::EXCEL => [
                        //     'filename' => 'exported-data_page_' . date('Y-m-d_H-i-s'),
                        // ],
                    ],
                    'export' => [
                        'label' => 'Page',
                        'fontAwesome' => true,
                    ],
                    'toolbar' => [
                        '{export}'
                    ],
                    'columns' => $gridColumns,
                ]); ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Laporan Absen: <small>Penggiat 1</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                            <a href="#" role="button" aria-expanded="false"><i class="fa fa-print"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Desa/Kelurahan</th>
                            <th>Kecamatan</th>
                            <th>Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>01-05-2017</td>
                            <td>Sanggar A</td>
                            <td>Citayam</td>
                            <td>Citayam</td>
                            <td>Penyebarluasan Informasi, Konsolidasi Masalah</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>02-05-2017</td>
                            <td>Sanggar B</td>
                            <td>Citayam</td>
                            <td>Depok</td>
                            <td>Konsolidasi Masalah, Pendataan</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>03-05-2017</td>
                            <td>Sanggar C</td>
                            <td>Citayam</td>
                            <td>Margonda</td>
                            <td>Penyebarluasan Informasi, Konsolidasi Masalah, Pendataan</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="x_panel">
                <div class="x_title">
                    <h2>Laporan Aktifitas: <small>Penggiat 1</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                            <a href="#" role="button" aria-expanded="false"><i class="fa fa-print"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Desa/Kelurahan</th>
                            <th>Kecamatan</th>
                            <th>Kegiatan</th>
                            <th>Materi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>01-05-2017</td>
                            <td>Sanggar A</td>
                            <td>Citayam</td>
                            <td>Citayam</td>
                            <td>Penyebarluasan Informasi</td>
                            <td>Website</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>01-05-2017</td>
                            <td>Sanggar A</td>
                            <td>Citayam</td>
                            <td>Citayam</td>
                            <td>Konsolidasi Masalah</td>
                            <td>Website</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>01-05-2017</td>
                            <td>Sanggar A</td>
                            <td>Citayam</td>
                            <td>Citayam</td>
                            <td>Pendataan</td>
                            <td>Website</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="x_panel">
                <div class="x_title">
                    <h2>Laporan Penggiat Wilayah Kerja Jakarta Utara</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown">
                            <a href="#" role="button" aria-expanded="false"><i class="fa fa-print"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Penggiat</th>
                            <th>Penyebarluasan</th>
                            <th>Konsolidasi</th>
                            <th>Pendataan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Penggiat 1</td>
                            <td>10</td>
                            <td>5</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Penggiat 2</td>
                            <td>10</td>
                            <td>5</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Penggiat 3</td>
                            <td>10</td>
                            <td>5</td>
                            <td>12</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
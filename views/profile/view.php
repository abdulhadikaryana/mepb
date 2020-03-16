<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use mdm\admin\components\Helper;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
app\assets\GentelellaAdditionalProfilePluginAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower/gentelella/production');

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['photo'] = $model->photo;
?>
<div class="profile-view">

    <p>
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

    <div class="page-title">
		<div class="title_left">
			<h3>User Profile</h3>
		</div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>User Report <small>Activity report</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a></li>
                                <li><a href="#">Settings 2</a></li>
                            </ul>
                        </li>-->
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar -->
                                <img class="img-responsive avatar-view" src="<?=$model->photo ? $model->photo : Url::base().'/images/default-avatar.png';?>" alt="Avatar" title="Change the avatar">
                            </div>
                        </div>
                        <h3><?=$model->fullname?></h3>
                        <ul class="list-unstyled user_data">
                            <li><i class="fa fa-map-marker user-profile-icon"></i> <?=$model->kecamatan_id ? $model->kecamatan->nama_kecamatan : null?>, <?= $model->kabkota_id ? $model->kabkota->nama_kabkota : null?>, <?=$model->provinsi_id ? $model->provinsi->nama_provinsi : null?></li>
                            <li><i class="fa fa-users user-profile-icon"></i> Group: <?=$model->user->groupName?></li>
                            <?php if($model->user->group === 20 || $model->user->group === 30) {?>
                            <li><i class="fa fa-user-secret user-profile-icon"></i> Jabatan: <?=$model->jabatan?></li>
                            <?php } ?>
                            <?php if($model->user->group == 40) {?>
                            <li><i class="fa fa-shield user-profile-icon"></i> Dinas: <?=$model->user->dinas ? $model->user->dinas->fullname : '-' ?></li>
                            <li><i class="fa fa-shield user-profile-icon"></i> UPT: <?=$model->user->upt ? $model->user->upt->fullname : '-' ?></li>
                            <?php } ?>
                            <li class="m-top-xs">
                                <i class="fa fa-twitter user-profile-icon"></i>
                                <a href="https://www.twitter.com/<?=substr($model->twitter, 1);?>" target="_blank"><?=$model->twitter?></a>
                            </li>
                        </ul>
                        <?php if(Helper::checkRoute('update')){ ?>
                        <?= Html::a('<i class="fa fa-edit m-right-xs"></i> Ubah Profile', ['update'], ['class' => 'btn btn-success']) ?>
                        <?php } ?>
                        <br />
                        <!-- start skills -->
                        <!--<h4>Skills</h4>
                        <ul class="list-unstyled user_data">
                            <li>
                                <p>Web Applications</p>
                                <div class="progress progress_sm">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                                </div>
                            </li>
                            <li>
                                <p>Website Design</p>
                                <div class="progress progress_sm">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                                </div>
                            </li>
                            <li>
                                <p>Automation & Testing</p>
                                <div class="progress progress_sm">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                                </div>
                            </li>
                            <li>
                                <p>UI / UX</p>
                                <div class="progress progress_sm">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                                </div>
                            </li>
                        </ul>-->
                        <!-- end of skills -->
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="profile_title">
                            <div class="col-md-6">
                                <h2>Aktifitas</h2>
                            </div>
                            <!--<div class="col-md-6">
                                <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                </div>
                            </div>-->
                        </div>
                        <!-- start of user-activity-graph -->
                        <!--<div id="graph_bar" style="width:100%; height:280px;"></div>-->
                        <!-- end of user-activity-graph -->
                        <div class="graph-activity">
                            <?php
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        // 'themes/grid'
                                    ],
                                    'options'=>[
                                        "chart" => ["type" => "column"],
                                        "title" => ["text" => "Total Data"],
                                        "xAxis" => [
                                            "categories" => ['Penyebarluasan', 'Konsolidasi', 'Pendataan'],
                                            "crosshair" => true
                                        ],
                                        "yAxis" => [
                                            "min" => 0,
                                            "title" => ["text" => "Jumlah"]
                                        ],
                                        "tooltip" => [
                                            "shared" => true,
                                            "useHTML" => true
                                        ],
                                        "plotOptions" => [
                                            "column" => [
                                                "pointPadding" => 0.2,
                                                "borderWidth" => 0
                                            ]
                                        ],
                                        "series" => [
                                            [
                                                'name' => 'Kegiatan',
                                                'colorByPoint' => true,
                                                'data' => $data
                                            ],
                                        ]
                                    ]
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

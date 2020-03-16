<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'site_title']) ?>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?=$directoryAsset;?>/images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Kegiatan</h3>
                <ul class="nav side-menu">
                    <li><?=Html::a('<i class="fa fa-edit"></i> Penyebarluasan Informasi', Url::to('#'));?></li>
                    <li><?=Html::a('<i class="fa fa-desktop"></i> Konsolidasi Permasalahan', Url::to('#'));?></li>
                    <li><?=Html::a('<i class="fa fa-table"></i> Pendataaan', Url::to('#'));?></li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>Master Data</h3>
                <ul class="nav side-menu">
                    <li><?=Html::a('<i class="fa fa-desktop"></i> Daftar Tema', Url::to('/tema/index'));?></li>
                    <li><?=Html::a('<i class="fa fa-table"></i> Daftar Topik', Url::to('/topik/index'));?></li>
                    <li><a><i class="fa fa-map-marker"></i> Lokasi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('Provinsi', Url::to('/provinsi/index'));?></li>
                      <li><?=Html::a('Kabupaten/Kota', Url::to('/kabupatenkota/index'));?></li>
                      <li><?=Html::a('Kecamatan', Url::to('/kecamatan/index'));?></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('Dashboard', Url::to('/site/index'));?></li>
                      <li><?=Html::a('Dashboard2', Url::to('/site/dashboard2'));?></li>
                      <li><?=Html::a('Dashboard3', Url::to('/site/dashboard3'));?></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('General Form', Url::to('/form/index'));?></li>
                      <li><?=Html::a('Advanced Components', Url::to('/form/advanced'));?></li>
                      <li><?=Html::a('Form Validation', Url::to('/form/validation'));?></li>
                      <li><?=Html::a('Form Wizard', Url::to('/form/wizard'));?></li>
                      <li><?=Html::a('Form Upload', Url::to('/form/upload'));?></li>
                      <li><?=Html::a('Form Button', Url::to('/form/button'));?></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('General Elements', Url::to('/elements/index'));?></li>
                      <li><?=Html::a('Media Gallery', Url::to('/elements/media-gallery'));?></li>
                      <li><?=Html::a('Typography', Url::to('/elements/typography'));?></li>
                      <li><?=Html::a('Icons', Url::to('/elements/icons'));?></li>
                      <li><?=Html::a('Glyphicons', Url::to('/elements/glyphicons'));?></li>
                      <li><?=Html::a('Widgets', Url::to('/elements/widgets'));?></li>
                      <li><?=Html::a('Invoice', Url::to('/elements/invoice'));?></li>
                      <li><?=Html::a('Inbox', Url::to('/elements/inbox'));?></li>
                      <li><?=Html::a('Calendar', Url::to('/elements/calendar'));?></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('Tables', Url::to('/tables/index'));?></li>
                      <li><?=Html::a('Table Dynamic', Url::to('/tables/dynamic'));?></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('Chart JS', Url::to('/chart/index'));?></li>
                      <li><?=Html::a('Chart JS2', Url::to('/chart/js2'));?></li>
                      <li><?=Html::a('Moris JS', Url::to('/chart/moris'));?></li>
                      <li><?=Html::a('Echarts', Url::to('/chart/echarts'));?></li>
                      <li><?=Html::a('Other Chart', Url::to('/chart/other'));?></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('Fixed Sidebar', Url::to('/formats/fixed-sidebar'));?></li>
                      <li><?=Html::a('Fixed Footer', Url::to('/formats/fixed-footer'));?></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('E-commerce', Url::to('/additional/ecommerce'));?></li>
                      <li><?=Html::a('Projects', Url::to('/additional/projects'));?></li>
                      <li><?=Html::a('Project Detail', Url::to('/additional/project-detail'));?></li>
                      <li><?=Html::a('Contacts', Url::to('/additional/contacts'));?></li>
                      <li><?=Html::a('Profile', Url::to('/additional/profile'));?></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><?=Html::a('403 Error', Url::to('/extras/error403'));?></li>
                      <li><?=Html::a('404 Error', Url::to('/extras/error404'));?></li>
                      <li><?=Html::a('500 Error', Url::to('/extras/error500'));?></li>
                      <li><?=Html::a('Plain Page', Url::to('/extras/plain-page'));?></li>
                      <li><?=Html::a('Login Page', Url::to('/extras/login-page'));?></li>
                      <li><?=Html::a('Pricing Tables', Url::to('/extras/pricing-tables'));?></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><?=Html::a('Level One', Url::to('#level1_1'));?>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><?=Html::a('Level Two', Url::to('#level2_1'));?>
                            </li>
                            <li><?=Html::a('Level Two', Url::to('#level2_1'));?></li>
                            <li><?=Html::a('Level Two', Url::to('#level2_2'));?></li>
                          </ul>
                        </li>
                        <li><?=Html::a('Level One', Url::to('#level1_2'));?></li>
                    </ul>
                  </li>                  
                  <li><?=Html::a('<i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span>', Url::to('javascript:void(0)'));?></li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
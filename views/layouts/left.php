<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\component\RecordHelpers;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Nav;
use yii\widgets\Menu;

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
                <?php if($already_exists = RecordHelpers::userHas('profile')) { ?>
                <img src="<?= Yii::$app->user->identity->profiles->photo ? Yii::$app->user->identity->profiles->photo : Url::base().'/images/default-avatar.png';?>" alt="..." class="img-circle profile_img">
                <?php } else { ?>
                <img src="<?=Url::base().'/images/default-avatar.png';?>" alt="..." class="img-circle profile_img">
                <?php } ?>
              </div>
              <div class="profile_info">
                <span>Selamat Datang,</span>
                <?php if($already_exists = RecordHelpers::userHas('profile')) { ?>
                <h2><?=Yii::$app->user->identity->profiles->fullname;?></h2>
                <?php } else { ?>
                <h2><?=Yii::$app->user->identity->username;?></h2>
                <?php } ?>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <?php if(Yii::$app->user->can('Penggiat') || Yii::$app->user->can('Operator') || Yii::$app->user->can('SuperAdmin')) { ?>
              <div class="menu_section">
                <h3>Kegiatan</h3>
                <?php
                    $menu1 = Yii::$app->db->createCommand('SELECT * FROM menu WHERE name ="MENU-KEGIATAN"')->queryOne();
                    echo Menu::widget([
                        'options' => ['class' => 'nav side-menu'],
                        'encodeLabels' => false,
                        'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, $menu1['id'])
                    ]); 
                ?>
              </div>
              <?php } ?>
              <?php if(Yii::$app->user->can('Dinas')) { ?>
              <div class="menu_section">
                <h3>Dinas</h3>
                <?php 
                    $menu2 = Yii::$app->db->createCommand('SELECT * FROM menu WHERE name ="MENU-DINAS"')->queryOne();
                    echo Menu::widget([
                        'options' => ['class' => 'nav side-menu'],
                        'encodeLabels' => false,
                        'submenuTemplate' => "\n<ul class='nav child_menu'>\n{items}\n</ul>\n",
                        'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, $menu2['id'])
                    ]); 
                ?>
              </div>
              <?php } ?>
              <?php if(Yii::$app->user->can('UPT')) { ?>
              <div class="menu_section">
                <h3>UPT</h3>
                <?php 
                    $menu3 = Yii::$app->db->createCommand('SELECT * FROM menu WHERE name ="MENU-UPT"')->queryOne();
                    echo Menu::widget([
                        'options' => ['class' => 'nav side-menu'],
                        'encodeLabels' => false,
                        'submenuTemplate' => "\n<ul class='nav child_menu'>\n{items}\n</ul>\n",
                        'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, $menu3['id'])
                    ]); 
                ?>
              </div>
              <?php } ?>
              <?php if(Yii::$app->user->can('SuperAdmin') || Yii::$app->user->can('Operator') || Yii::$app->user->can('Penggiat')) { ?>
              <div class="menu_section">
                <h3>Report</h3>
                <?php 
                    $menu4 = Yii::$app->db->createCommand('SELECT * FROM menu WHERE name ="MENU-REPORT"')->queryOne();
                    echo Menu::widget([
                        'options' => ['class' => 'nav side-menu'],
                        'encodeLabels' => false,
                        'submenuTemplate' => "\n<ul class='nav child_menu'>\n{items}\n</ul>\n",
                        'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, $menu4['id'])
                    ]);
                ?>
              </div>  
              <?php } ?>
              <?php if(Yii::$app->user->can('SuperAdmin') || Yii::$app->user->can('Operator')) { ?>
              <div class="menu_section">
                <h3>Master Data</h3>
                <?php 
                    $menu4 = Yii::$app->db->createCommand('SELECT * FROM menu WHERE name ="MENU-MASTER-DATA"')->queryOne();
                    echo Menu::widget([
                        'options' => ['class' => 'nav side-menu'],
                        'encodeLabels' => false,
                        'submenuTemplate' => "\n<ul class='nav child_menu'>\n{items}\n</ul>\n",
                        'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, $menu4['id'])
                    ]); 
                ?>
              </div>
              <?php } ?>
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
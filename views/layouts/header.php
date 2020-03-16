<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\component\RecordHelpers;

?>
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <?php if($already_exists = RecordHelpers::userHas('profile')) { ?>
            <img src="<?= Yii::$app->user->identity->profiles->photo ? Yii::$app->user->identity->profiles->photo : Url::base().'/images/default-avatar.png';?>" alt=""><?=Yii::$app->user->identity->profiles->fullname;?>
            <?php } else { ?>
            <img src="<?=Url::base().'/images/default-avatar.png';?>" alt=""><?=Yii::$app->user->identity->username;?>
            <?php } ?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><?=Html::a('Profile', Url::to('/profile/index'));?></li>
            <?php if(Yii::$app->user->isGuest) {?>
            <li><?=Html::a('<i class="fa fa-sign-in pull-right"></i> Log In</a>', Url::to('/site/login'))?></li>
            <?php } else { ?>
            <li><?=Html::a('<i class="fa fa-sign-out pull-right"></i> Log Out</a>', Url::to(['/site/logout']), ['data-method' => 'post'])?></li>
            <?php } ?>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->
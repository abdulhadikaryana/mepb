<?php
use app\assets\GentelellaAsset;
use app\assets\HomepageAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use app\component\RecordHelpers;

/* @var $this \yii\web\View */
/* @var $content string */

HomepageAsset::register($this);
GentelellaAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="login">
<?php $this->beginBody() ?>
<div class="container body">
    <div class="top_nav">
        <div class="nav_menu">
            <nav>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(Yii::$app->user->isGuest) {?>
                    <li><?=Html::a('<i class="fa fa-sign-in pull-right"></i> Log In</a>', Url::to('/site/login'))?></li>
                    <?php } else { ?>
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
                            <li>
                                <a href="javascript:;">
                                <span class="badge bg-red pull-right">50%</span>
                                <span>Settings</span>
                                </a>
                            </li>
                            <li><a href="javascript:;">Help</a></li>
                            <li><?=Html::a('<i class="fa fa-sign-out pull-right"></i> Log Out</a>', Url::to(['/site/logout']), ['data-method' => 'post'])?></li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li><?=Html::a('Tentang Kami', Url::to('/site/about'))?></li>
                    <li><?=Html::a('Profile', Url::to('/profile/index'))?></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="wrap">
        <?=$content; ?>
    </div>
    <div class="footer">
        <div class="pull-right">
            Copyright <?=date('Y');?> <a href="#">Company</a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
    
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
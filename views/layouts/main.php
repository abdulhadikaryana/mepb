<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\GentelellaAsset;

AppAsset::register($this);
GentelellaAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower/gentelella/production');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="nav-md">
<div style="display: none;">
    <?php echo \kartik\switchinput\SwitchInput::widget(['name'=>1]); ?>
</div>
<?php $this->beginBody() ?>
    <div class="container body">
        <div class="main_container">
            <!-- Left -->
            <?= $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset]
            ) ?>

            <!-- Header -->
            <?= $this->render(
                'header.php',
                ['directoryAsset' => $directoryAsset]
            )
            ?>

            <!-- Content -->
            <?= $this->render(
                'content.php',
                ['content' => $content, 'directoryAsset' => $directoryAsset]
            ) ?>

            <!-- Footer -->
            <?= $this->render(
                'footer.php',
                ['directoryAsset' => $directoryAsset]
            )
            ?>
        </div>
    </div>

    <?php $this->endBody() ?>    
</body>
</html>
<?php $this->endPage() ?>

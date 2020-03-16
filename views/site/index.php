<?php
use yii\bootstrap\Carousel;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\social\TwitterPlugin;

$this->title = 'Silahkan Login';
?>
<div class="site-index container">
    <div class="row">
        <div class="col-md-7">
            <div class="row">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="<?=Url::base()?>images/image-1.jpg" alt="...">
                            <div class="carousel-caption">
                                ...
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?=Url::base()?>images/image-2.jpg" alt="...">
                            <div class="carousel-caption">
                                ...
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?=Url::base()?>images/image-3.jpg" alt="...">
                            <div class="carousel-caption">
                                ...
                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <?php if(Yii::$app->user->isGuest) {?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'home-login-form',
                        'action' => '/site/login',
                        'fieldConfig' => [
                            'template' => "<div>{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ],
                    ]); ?>
                    
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email']) ?>
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>
                    <div>
                        <?= Html::submitButton('Login', ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-twitter"></i> Twitter @budayasaya</h3>
                </div>
                <div class="panel-body">
                    <a class="twitter-timeline" data-height="600" href="https://twitter.com/budayasaya">Tweet oleh budayasaya</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
            </div>
        </div>
    </div>
</div>
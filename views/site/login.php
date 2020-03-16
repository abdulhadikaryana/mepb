<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "<div>{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ],
                    ]); ?>
                    <form>
                        <h1><?= Html::encode($this->title) ?></h1>
                        <?= $form->field($model, 'email')->input('email', ['autofocus' => true, 'placeholder' => 'Email']) ?>
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>
                        <div>
                            <?= Html::submitButton('Login', ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
                        </div>

                        <div class="clearfix"></div>

                        <!-- <div class="separator">
                            <p class="change_link">New to site?
                                <a href="#signup" class="to_register"> Create Account </a>
                            </p>
                            <div class="clearfix"></div>
                            <br />                
                        </div> -->
                    </form>
                    <?php ActiveForm::end(); ?>
                </section>
            </div>

            <!-- <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <form>
                        <h1>Create Account</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <a class="btn btn-default submit" href="index.html">Submit</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Already a member ?
                                <a href="#signin" class="to_register"> Log in </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div> -->
</div>

<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\component\AuthHandler;

class OauthController extends Controller
{
    // http://localhost:8083/oauth/index?authclient=dapobud
    // Contoh user: penggiat@gmail.com, password: password

    // public function actions()
    // {
    //     return [
    //         'auth' => [
    //             'class' => 'yii\authclient\AuthAction',
    //             'successCallback' => [$this, 'onAuthSuccess'],
    //         ],
    //     ];
    // }

    // public function onAuthSuccess($client)
    // {
    //     (new AuthHandler($client))->handle();
    // }

    public function actionIndex()
    {
        return $this->goHome();
    }
}
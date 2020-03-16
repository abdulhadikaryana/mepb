<?php

namespace app\modules\api\v1\controllers;

use Yii;
use yii\db\Expression;
use app\models\User;

class WebsvcAuthController extends \yii\rest\Controller
{
    protected function verbs()
    {

        return [
            'login' => ['POST','OPTIONS'],
        ];

    }

    protected function generateAuthKey()
    {
        return Yii::$app->security->generateRandomString() . time();
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        $response = [];
        if(empty($username) || empty($password)) {
            $response = [
                'status' => 'error',
                'message' => 'username/email dan password tidak boleh kosong!',
                'data' => ''
            ];
        } else {
            // $model = User::findByUsername($username);
            // $model = User::findByEmail($username);
            $model = User::findPenggiatByEmail($username);
            if(!empty($model)) {
                if($model->validatePassword($password)) {
                    $model->generateAuthKey();
                    $model->token_expired = strtotime('+'.Yii::$app->params['token_expired'].' days', date('U'));
                    if($model->save(false)) {
                        $response = [
                            'status' => 'success',
                            'message' => 'login berhasil',
                            'data' => [
                                "id" => $model->id,
                                "username" => $model->username,               
                                "email" => $model->email,                      
                                "token_string" => $model->auth_key,              
                                "token_expired" => Yii::$app->formatter->asDate($model->token_expired, 'php:Y-m-d H:i:s'),
                            ]
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'Ada masalah di sistem',
                            'data' => ''
                        ];
                    }
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'password salah!',
                        'data' => ''
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'username/email tidak ditemukan dalam sistem!',
                    'data' => ''
                ];
            }
        }

        return $response;
    }
}
<?php

namespace app\modules\api\v1\controllers;

use Yii;
// use app\models\User;
use app\models\Profile;
use app\modules\api\v1\models\UserExt;
use app\component\RecordHelpers;

class UserController extends \yii\rest\Controller
{
    protected function verbs()
    {

        return [
            'profile' => ['GET', 'HEAD'],
            'create-profile' => ['POST', 'HEAD'],
            'update-profile' => ['PATCH'],
            'user-photo' => ['GET', 'HEAD'],
            'update-user-photo' => ['PATCH'],
            'change-password' => ['PATCH']
        ];

    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \app\component\CustomAuth::className(),
            'tokenParam' => 'X-Auth-Token',
            'except' => ['options']
        ];
        
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'PATCH'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
            ]
        ];

        return $behaviors;
    }

    public function actionProfile()
    {
        $profile = UserExt::ambilProfile();

        if(isset($profile)) {
            $response = [
                'status' => 'ok',
                'message' => 'profile berhasil diambil',
                'data' => $profile
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'profile belum ada',
                'data' => ''
            ];
        }
        return $response;
    }

    public function actionCreateProfile()
    {
        $model = new Profile;
        $request = Yii::$app->request;
        
        if($already_exists = RecordHelpers::userHas('profile')) {
            $model = $this->findModelProfile(Yii::$app->user->identity->id);

            // $response = [
            //     'status' => 'ok',
            //     'message' => 'data profile sudah ada',
            //     'data' => [
            //         'fullname' => $model->fullname,
            //         'phone' => $model->phone,
            //         'birthdate' => $model->birthdate,
            //         'gender' => $model->gender == 'M' ? 'Laki-laki' : 'Perempuan',
            //         'gender_code' => $model->gender,
            //         'address' => $model->address,
            //         'kecamatan_id' => $model->kecamatan_id,
            //         'kecamatan' => $model->kecamatan->nama_kecamatan,
            //         'kabkota_id' => $model->kabkota_id,
            //         'kabupatenkota' => $model->kabkota->nama_kabkota,
            //         'provinsi_id' => $model->provinsi_id,
            //         'provinsi' => $model->provinsi->nama_provinsi,
            //         'twitter' => $model->twitter
            //     ]
            // ];


            if(isset($request)) {
                $model->fullname = $request->post('fullname');
                $model->phone = $request->post('phone');
                $model->birthdate = date('Y-m-d', strtotime($request->post('birthdate')));
                $model->gender = $request->post('gender');
                $model->address = $request->post('address');
                $model->kecamatan_id = $request->post('kecamatan_id');
                $model->kabkota_id = $request->post('kabkota_id');
                $model->provinsi_id = $request->post('provinsi_id');
                $model->twitter = $request->post('twitter');
                if($model->save(false)) {
                    $response = [
                        'status' => 'ok',
                        'message' => 'data berhasil disimpan',
                        'data' => [
                            'fullname' => $model->fullname,
                            'phone' => $model->phone,
                            'birthdate' => $model->birthdate,
                            'gender' => $model->gender == 'M' ? 'Laki-laki' : 'Perempuan',
                            'gender_code' => $model->gender,
                            'address' => $model->address,
                            'kecamatan_id' => $model->kecamatan_id,
                            'kecamatan' => $model->kecamatan->nama_kecamatan,
                            'kabkota_id' => $model->kabkota_id,
                            'kabupatenkota' => $model->kabkota->nama_kabkota,
                            'provinsi_id' => $model->provinsi_id,
                            'provinsi' => $model->provinsi->nama_provinsi,
                            'twitter' => $model->twitter
                        ]
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'ada kesalahan ketika menyimpan data',
                        'data' => ''
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'form harus diisi',
                    'data' => ''
                ];
            }
        } else {
            if (isset($request)) {
                $model->fullname = $request->post('fullname');
                $model->phone = $request->post('phone');
                $model->birthdate = date('Y-m-d', strtotime($request->post('birthdate')));
                $model->gender = $request->post('gender');
                $model->address = $request->post('address');
                $model->kecamatan_id = $request->post('kecamatan_id');
                $model->kabkota_id = $request->post('kabkota_id');
                $model->provinsi_id = $request->post('provinsi_id');
                $model->twitter = $request->post('twitter');
                $model->user_id = Yii::$app->user->identity->id;

                if($model->save()){
                    $response = [
                        'status' => 'ok',
                        'message' => 'data berhasil disimpan',
                        'data' => [
                            'fullname' => $model->fullname,
                            'phone' => $model->phone,
                            'birthdate' => $model->birthdate,
                            'gender' => $model->gender == 'F' ? 'Perempuan' : 'Laki-laki',
                            'gender_code' => $model->gender,
                            'address' => $model->address,
                            'kecamatan_id' => $model->kecamatan_id,
                            'kecamatan' => $model->kecamatan->nama_kecamatan,
                            'kabkota_id' => $model->kabkota_id,
                            'kabupatenkota' => $model->kabkota->nama_kabkota,
                            'provinsi_id' => $model->provinsi_id,
                            'provinsi' => $model->provinsi->nama_provinsi,
                            'twitter' => $model->twitter
                        ]
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'ada kesalahan ketika menyimpan data',
                        'data' => ''
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'form harus diisi',
                    'data' => ''
                ];
            }
        }
        
        return $response;
    }

    public function actionUpdateProfile()
    {
        $model = $this->findModelProfile(Yii::$app->user->identity->id);
        $request = Yii::$app->request;

        if(isset($request)) {
            $model->fullname = $request->post('fullname');
            $model->phone = $request->post('phone');
            $model->birthdate = date('Y-m-d', strtotime($request->post('birthdate')));
            $model->gender = $request->post('gender');
            $model->address = $request->post('address');
            $model->kecamatan_id = $request->post('kecamatan_id');
            $model->kabkota_id = $request->post('kabkota_id');
            $model->provinsi_id = $request->post('provinsi_id');
            $model->twitter = $request->post('twitter');
            if($model->save(false)) {
                $response = [
                    'status' => 'ok',
                    'message' => 'data berhasil disimpan',
                    'data' => [
                        'fullname' => $model->fullname,
                        'phone' => $model->phone,
                        'birthdate' => $model->birthdate,
                        'gender' => $model->gender == 'M' ? 'Laki-laki' : 'Perempuan',
                        'gender_code' => $model->gender,
                        'address' => $model->address,
                        'kecamatan_id' => $model->kecamatan_id,
                        'kecamatan' => $model->kecamatan->nama_kecamatan,
                        'kabkota_id' => $model->kabkota_id,
                        'kabupatenkota' => $model->kabkota->nama_kabkota,
                        'provinsi_id' => $model->provinsi_id,
                        'provinsi' => $model->provinsi->nama_provinsi,
                        'twitter' => $model->twitter
                    ]
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'ada kesalahan ketika menyimpan data',
                    'data' => ''
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'form harus diisi',
                'data' => ''
            ];
        }
        return $response;
    }

    public function actionUserPhoto()
    {
        $profile = UserExt::ambilProfile();
        
        $response = [       
            'status' => 'ok',
            'message' => 'data return',
            'data' => [
                'photo' => $profile["photo"]
            ]
        ];
        return $response;
    }

    public function actionUpdateUserPhoto()
    {
        $model = $this->findModelProfile(Yii::$app->user->identity->id);

        $request = Yii::$app->request;
        
        $model->photo = $request->post('photo');

        if($model->save(false)) {
            $response = [       
                'status' => 'ok',
                'message' => 'update photo berhasil',
                'data' => [
                    'photo' => $model->photo
                ]
            ];
        } else {
            $response = [       
                'status' => 'error',
                'message' => 'update photo gagal',
                'data' => ''
            ];
        }

        return $response;
    }

    // public function actionChangePassword()
    // {
    //     $model = $this->findModel(Yii::$app->user->identity->id);

    //     $request = Yii::$app->request;
    //     if($model->validatePassword($request->post('old_password'))){
    //         $model->setPassword($request->post('new_password'));
    //         if($model->save(false)){
    //             $response = [       
    //                 'status' => 'ok',
    //                 'message' => 'password berhasil diganti',
    //                 'data' => ''
    //             ];
    //         } else {
    //             $response = [       
    //                 'status' => 'error',
    //                 'message' => 'password gagal diganti',
    //                 'data' => ''
    //             ];
    //         }
    //     } else {
    //         $response = [       
    //             'status' => 'error',
    //             'message' => 'password tidak match',
    //             'data' => ''
    //         ];
    //     }
        
    //     return $response;
    // }

    protected function findModel($id)
    {
        if (($model = UserExt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelProfile($id)
    {
        if (($model = Profile::findOne(['user_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
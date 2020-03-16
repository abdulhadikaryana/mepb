<?php

namespace app\modules\api\v1\models;

use Yii;
use \app\models\User;
use \app\models\Profile;
use \app\component\RecordHelpers;

class UserExt extends \app\models\User
{
    public static function ambilProfile()
    {
        if($already_exists = RecordHelpers::userHas('profile')) {
            $model = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
            return [
                'fullname' => $model->fullname,
                'phone' => $model->phone,
                'birthdate' => $model->birthdate,
                'gender' => $model->gender == 'F' ? 'Perempuan' : 'Laki-laki',
                'gender_code' => $model->gender,
                'photo' => $model->photo,
                'address' => $model->address,
                'kecamatan_id' => $model->kecamatan_id,
                'kecamatan' => $model->kecamatan->nama_kecamatan,
                'kabkota_id' => $model->kabkota_id,
                'kabupatenkota' => $model->kabkota->nama_kabkota,
                'provinsi_id' => $model->provinsi_id,
                'provinsi' => $model->provinsi->nama_provinsi,
                'twitter' => $model->twitter
            ];
        } else {
            return null;
        }
    }
}
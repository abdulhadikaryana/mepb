<?php
namespace app\models\forms;

use Yii;
use app\models\User;
use app\models\Profile;
use yii\base\Model;
use yii\widgets\ActiveForm;

class UserAdminForm extends Model
{
    private $_user;
    private $_profile;

    public function rules()
    {
        return [
            [['User'], 'required'],
            [['Profile'], 'safe'],
        ];
    }

    // public function beforeValidate()
    // {
    //     if($this->profile->birthdate != null) {
    //         $new_date_format = date('Y-m-d', strtotime($this->profile->birthdate));
    //         $this->profile->birthdate = $new_date_format;
    //     }

    //     return parent::beforeValidate();
    // }

    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         $provinsi = \app\models\Provinsi::findOne($this->proprovinsi);
    //         $kabupatenkota = \app\models\Kabupatenkota::findOne($this->kabupatenkota);
    //         $kecamatan = \app\models\Kecamatan::findOne($this->kecamatan);
    //         $tema = \app\models\Tema::findOne($this->tema);
    //         $topik = \app\models\Topik::findOne($this->topik);

    //         $this->provinsi = $provinsi->nama_provinsi;
    //         $this->kabupatenkota = $kabupatenkota->nama_kabkota;
    //         $this->kecamatan = $kecamatan->nama_kecamatan;
    //         $this->tema = $tema->nama_tema;
    //         $this->topik = $topik->nama_topik;

    //         return parent::beforeSave($insert);
            
    //     } else {
    //         return false;
    //     }
    // }

    // public function beforeSave()
    // {
    //     if (parent::beforeSave($insert)) {
    //         $this->user->setPassword($this->user->newPassword);
    //         return parent::beforeSave($insert);
    //     } else {
    //         if (!empty($this->user->newPassword)) {
    //             $this->user->setPassword($this->user->newPassword);
    //         }
    //     }
    // }

    public function afterValidate()
    {
        $error = false;
        if(!$this->user->validate()) {
            $error = true;
        }
        if(!$this->profile->validate()) {
            $error = true;
        }
        if($error) {
            $this->addError(null); // add an empty error to prevent saving
        }
        parent::afterValidate();
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $this->user->status = $this->user->status == 1 ? 10 : 0;
        // $this->user->group = 10;
        if (!empty($this->user->newPassword)) {
            $this->user->setPassword($this->user->newPassword);
        }
        $this->user->generateAuthKey();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!$this->user->save()) {
                $transaction->rollBack();
                return false;
            }
            $this->profile->user_id = $this->user->id;
            if (!$this->profile->save(false)) {
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        // return true;
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function setUser($user)
    {
        if($user instanceof User) {
            $this->_user = $user;
        } elseif (is_array($user)) {
            $this->_user->setAttributes($user);
        }
    }

    public function getProfile()
    {
        if($this->_profile === null) {
            if ($this->user->isNewRecord) {
                $this->_profile = new Profile();
                $this->_profile->loadDefaultValues();
            } else {
                $this->_profile = $this->user->profile;
            }
        }
        return $this->_profile;
    }

    public function setProfile($profile)
    {
        if(is_array($profile)) {
            $this->profile->setAttributes($profile);
        } elseif($profile instanceof Profile) {
            $this->_profile = $profile;
        }
    }

    public function errorSummary($form)
    {
        $errorLists = [];
        foreach($this->getAllModels() as $id => $model) {
            $errorList = $form->errorSummary($model, [
                'header' => '<p>Please fix the following errors for <b>' . $id . '</b></p>',
            ]);
            $errorList = str_replace('<li></li>', '', $errorList);
            $errorLists[] = $errorList;
        }

        return implode('', $errorLists);
    }

    private function getAllModels()
    {
        return [
            'User' => $this->user,
            'Profile' => $this->profile,
        ];
    }
}
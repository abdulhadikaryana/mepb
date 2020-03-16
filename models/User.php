<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\helpers\ArrayHelper;
use app\component\RecordHelpers;
use dektrium\user\models\User as BaseUser;
use app\models\ViewMaster;

class User extends ActiveRecord implements \yii\web\IdentityInterface
// class User extends BaseUser
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    // public $newPassword, $newPasswordConfirm, $editPassword, $editPasswordConfirm, $file;
    public $password, $newPasswordConfirm;
    public $start_date, $end_date, $date_range;

    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
    }

    public function rules()
    {
        return[
            [['created_at', 'updated_at'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['username', 'email'], 'required'],
            [['username'], 'unique', 'targetAttribute' => 'username'],
            ['username', 'string', 'min' => 5, 'max' => '100'],
            [['email'], 'unique', 'targetAttribute' => 'email'],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 100],
            [['wilayah_kerja'], 'string', 'max' => 500],
            [['provinsi_id', 'kabkota_id'], 'integer'],
            [['auth_key', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['created_at', 'updated_at', 'status', 'token_expired', 'parent_id', 'group'], 'integer'],
            // [['editPassword', 'editPasswordConfirm', 'newPassword', 'newPasswordConfirm'], 'string', 'min' => 6, 'max' => 100],
            // [['editPassword', 'editPasswordConfirm', 'newPassword', 'newPasswordConfirm'], 'filter', 'filter' => 'trim'],
            [['password'], 'required', 'on' => ['create']],
            [['password', 'newPasswordConfirm'], 'required', 'when' => function ($model) {
				return (!empty($model->newPassword));
			}, 'whenClient' => "function (attribute, value) {
                return ($('#user-password').val().length>0);
            }"],
            [['newPasswordConfirm'], 'compare', 'compareAttribute' => 'password', 'message' => 'Password tidak sama'],
            // [['editPasswordConfirm'], 'compare', 'compareAttribute' => 'editPassword', 'message' => 'Password tidak sama'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'newPasswordConfirm' => 'Ulangi Password',
            // 'editPassword' => 'Password Baru',
            // 'editPasswordConfirm' => 'Ulangi Password',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'email' => 'Email',
            'password_reset_token' => 'Password Reset Token',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'token_expired' => 'Token Expired',
            'parent_id' => 'Parent',
            'group' => 'Group',
            'wilayah_kerja' => 'Wilayah Kerja'
        ];
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' =>self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
        return static::find()
                ->where(['auth_key' => $token, 'status' => self::STATUS_ACTIVE])
                ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email on api
     * Khusus penggiat saja yang bisa login
     *
     * @param string $email
     * @return static|null
     */
    public static function findPenggiatByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE, 'group' => 40]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        // http://www.yiiframework.com/doc-2.0/yii-web-identityinterface.html
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    static function staticIcon($status)
    {
        switch ($status) {
            case 20:
                $response = '<small class="label bg-yellow"><i class="fa fa-exclamation"></i></small>';
                break;
            case 0:
                $response = '<small class="label bg-red"><i class="fa fa-remove"></i></small>';
                break;
            default:
                $response = '<small class="label bg-green"><i class="fa fa-check"></i></small>';
                break;
        }
        

        return $response;
    }

    public function getFullname()
    {
        if(RecordHelpers::userHasProfile($this->id)) {
            return $this->profiles->fullname;
        } else {
            return $this->username;
        }
    }

    public function getGroupName()
    {
        if($this->group == 10) {
            return 'Super Admin';
        } elseif($this->group == 20) {
            return 'UPT';
        } elseif($this->group == 30) {
            return 'Dinas';
        } else {
            return 'Penggiat';
        }
    }

    public function getStatusIcon()
    {
        return static::staticIcon($this->status);
    }

    public function getParent()
    {
        return $this->hasOne(User::className(), ['id' => 'parent_id']);
    }

    public function getChild()
    {
        return $this->hasMany(User::className(), ['parent_id' => 'id']);
    }
    
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getDinas()
    {
        if($this->parent === null) {
           $profileDinas = null; 
        } else {
            $profileDinas = Profile::findOne(['user_id' => $this->parent->id]);
        }
        return $profileDinas;
    }

    public function getUpt()
    {
        if($this->parent === null) {
            $profileUpt = null;
        } else {
            $upt = User::findOne([$this->parent->id]);
            $profileUpt = Profile::findOne(['user_id' => $upt->parent_id]);
        }

        return $profileUpt;
    }

    public function getPenyebarluasan()
    {
        return $this->hasMany(Penyebarluasan::className(), ['created_by' => 'id']);
    }

    public function getKonsolidasi()
    {
        return $this->hasMany(Konsolidasi::className(), ['created_by' => 'id']);
    }

    public function getPendataan()
    {
        return $this->hasMany(Pendataan::className(), ['created_by' => 'id']);
    }

    public function getProvinsi()
    {
        return $this->hasOne(Provinsi::className(), ['id' => 'provinsi_id']);
    }

    public function getKabkota()
    {
        return $this->hasOne(Kabupatenkota::className(), ['id' => 'kabkota_id']);
    }

    public function getListProvinsi()
    {
        $data = \app\models\Provinsi::find()->asArray()->all();

        return yii\helpers\ArrayHelper::map($data, 'id', 'nama_provinsi');
    }

    public function getAllKabupatenKota()
    {
        $data = \app\models\Kabupatenkota::find()->where(['provinsi_id' => $this->provinsi_id])->asArray()->all();
        return yii\helpers\ArrayHelper::map($data, 'id', 'nama_kabkota');
    }

    /**
     * @inheritdoc
     * @return HelperBranchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public function getWilayahKerja()
    {
        $wilayah = explode(',', $this->wilayah_kerja);

        $datas = \app\models\Kecamatan::find()->where(['in', 'id', $wilayah])->all();

        foreach($datas as $key => $value) {
            $kecamatan[] = $value->nama_kecamatan;
        }
        
        if(!empty($datas)) {
            return implode(',', $kecamatan);
        } else {
            return null;
        }
        
    }

    public function getListWilayahKerja()
    {
        $datas = \app\models\Kabupatenkota::find()->all();

        foreach($datas as $key => $value) {
            $kecamatan = yii\helpers\ArrayHelper::map(
                \app\models\Kecamatan::find()->where(['kabkota_id' => $value->id])->asArray()->all(),
                'id', 'nama_kecamatan'
            );

            $wilayah[$value->nama_kabkota] = $kecamatan;
        }

        return $wilayah;
    }

    public function getWilayahKerjaDinas()
    {
        $wilayah = explode(',', $this->wilayah_kerja);

        $datas = \app\models\Kabupatenkota::find()->where(['in', 'id', $wilayah])->all();

        foreach($datas as $key => $value) {
            $kabupatenkota[] = $value->nama_kabkota;
        }
        
        if(!empty($datas)) {
            return implode(',', $kabupatenkota);
        } else {
            return null;
        }
        
    }

    public function getListWilayahKerjaDinas()
    {
        $datas = \app\models\Provinsi::find()->all();

        foreach($datas as $key => $value) {
            $kabkota = yii\helpers\ArrayHelper::map(
                \app\models\Kabupatenkota::find()->where(['provinsi_id' => $value->id])->asArray()->all(),
                'id', 'nama_kabkota'
            );

            $wilayah[$value->nama_provinsi] = $kabkota;
        }

        return $wilayah;
    }

    public function getWilayahKerjaUpt()
    {
        $wilayah = explode(',', $this->wilayah_kerja);

        $datas = \app\models\Kabupatenkota::find()->where(['in', 'id', $wilayah])->all();

        foreach($datas as $key => $value) {
            $kabupatenkota[] = $value->nama_kabkota;
        }
        
        if(!empty($datas)) {
            return implode(',', $kabupatenkota);
        } else {
            return null;
        }
        
    }

    public function getListWilayahKerjaUpt()
    {
        $datas = \app\models\Provinsi::find()->all();

        foreach($datas as $key => $value) {
            $kabkota = yii\helpers\ArrayHelper::map(
                \app\models\Kabupatenkota::find()->where(['provinsi_id' => $value->id])->asArray()->all(),
                'id', 'nama_kabkota'
            );

            $wilayah[$value->nama_provinsi] = $kabkota;
        }

        return $wilayah;
    }

    public function getViewMaster()
    {
        return $this->hasMany(ViewMaster::className(), ['created_by' => 'id']);
    }

    public function getPenyebarluasanCount()
    {
        return $this->getViewMaster()->where([
            'kegiatan' => 'penyebarluasan'
        ])->count();
        // $query = $this->getViewMaster()->where(['kegiatan' => 'penyebarluasan']);
        // $query->andWhere(['between', 'view_master.tanggal_entri', date('Y-m-d', strtotime($this->start_date)), date('Y-m-d', strtotime($this->end_date))]);

        // return $query->count();
    }

    public function getKonsolidasiCount()
    {
        return $this->getViewMaster()->where([
            'kegiatan' => 'konsolidasi'
        ])->count();
    }

    public function getPendataanCount()
    {
        return $this->getViewMaster()->where([
            'kegiatan' => 'pendataan'
        ])->count();
    }

    public function getListDinas()
    {
        
    }

    public function getListUpt()
    {
        
    }
}

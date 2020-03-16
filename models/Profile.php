<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\web\UploadedFile;

use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property string $phone
 * @property string $fullname
 * @property string $birthdate
 * @property string $gender
 * @property string $photo
 * @property string $address
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthdate', 'photo'], 'safe'],
            [['gender', 'address', 'fullname', 'twitter', 'jabatan'], 'string'],
            [['gender', 'birthdate', 'address', 'phone', 'fullname', 'kecamatan_id', 'kabkota_id', 'provinsi_id'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'kecamatan_id', 'kabkota_id', 'provinsi_id'], 'integer'],
            [['phone'], 'string', 'max' => 255],
            [['photo'], 'file', 'extensions' => 'jpg, jpeg, gif, png', 'maxSize' => 1024*1024, 'skipOnEmpty' => true],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function beforeValidate()
    {
        if($this->birthdate != null) {
            $new_date_format = date('Y-m-d', strtotime($this->birthdate));
            $this->birthdate = $new_date_format;
        }

        return parent::beforeValidate();
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Telepon',
            'fullname' => 'Nama Lengkap',
            'birthdate' => 'Tanggal Lahir',
            'gender' => 'Jenis Kelamin',
            'photo' => 'Foto',
            'address' => 'Alamat',
            'kecamatan_id' => 'Kecamatan',
            'kabkota_id' => 'Kabupaten/Kota',
            'provinsi_id' => 'Provinsi',
            'user_id' => 'User ID',
            'twitter' => 'Twitter',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'jabatan' => 'Jabatan'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinsi()
    {
        return $this->hasOne(Provinsi::className(), ['id' => 'provinsi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKabkota()
    {
        return $this->hasOne(Kabupatenkota::className(), ['id' => 'kabkota_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKecamatan()
    {
        return $this->hasOne(Kecamatan::className(), ['id' => 'kecamatan_id']);
    }

    /**
     * @inheritdoc
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
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

    public function getAllKecamatan()
    {
        $data = \app\models\Kecamatan::find()->where(['kabkota_id' => $this->kabkota_id])->asArray()->all();
        return yii\helpers\ArrayHelper::map($data, 'id', 'nama_kecamatan');
    }

    public function getListUser()
    {
        $data = \app\models\User::find()->asArray()->all();

        return yii\helpers\ArrayHelper::map($data, 'id', 'email');
    }
}

<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "kabupatenkota".
 *
 * @property integer $id
 * @property string $nama_kabkota
 * @property string $tipe
 * @property integer $provinsi_id
 *
 * @property Provinsi $provinsi
 * @property Kecamatan[] $kecamatans
 */
class Kabupatenkota extends \yii\db\ActiveRecord
{
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kabupatenkota';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_kabkota', 'provinsi_id', 'kode_kabkota'], 'required'],
            [['tipe'], 'string'],
            [['provinsi_id'], 'integer'],
            [['nama_kabkota', 'kode_kabkota'], 'string', 'max' => 255],
            [['provinsi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinsi::className(), 'targetAttribute' => ['provinsi_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_kabkota' => 'Kabupaten/Kota',
            'kode_kabkota' => 'Kode',
            'tipe' => 'Tipe',
            'provinsi_id' => 'Provinsi',
        ];
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
    public function getKecamatans()
    {
        return $this->hasMany(Kecamatan::className(), ['kabkota_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['kabkota_id' => 'id']);
    }

    public function getListProvinsi()
    {
        $data = \app\models\Provinsi::find()->asArray()->all();

        return yii\helpers\ArrayHelper::map($data, 'id', 'nama_provinsi');
    }
}

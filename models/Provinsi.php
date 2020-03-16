<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provinsi".
 *
 * @property integer $id
 * @property string $nama_provinsi
 *
 * @property Kabupatenkota[] $kabupatenkotas
 */
class Provinsi extends \yii\db\ActiveRecord
{
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provinsi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_provinsi', 'kode_provinsi'], 'required'],
            [['nama_provinsi', 'kode_provinsi'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_provinsi' => 'Nama Provinsi',
            'kode_provinsi' => 'Kode'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKabupatenkotas()
    {
        return $this->hasMany(Kabupatenkota::className(), ['provinsi_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['provinsi_id' => 'id']);
    }
}

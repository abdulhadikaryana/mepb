<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kecamatan".
 *
 * @property integer $id
 * @property string $nama_kecamatan
 * @property integer $kabkota_id
 *
 * @property Kabupatenkota $kabkota
 */
class Kecamatan extends \yii\db\ActiveRecord
{
    public $provinsi_id, $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kecamatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_kecamatan', 'kode_kecamatan'], 'required'],
            [['kabkota_id'], 'integer'],
            [['nama_kecamatan', 'kode_kecamatan'], 'string', 'max' => 255],
            [['kabkota_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kabupatenkota::className(), 'targetAttribute' => ['kabkota_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_kecamatan' => 'Kecamatan',
            'kabkota_id' => 'Kabupaten/Kota',
            'provinsi_id' => 'Provinsi',
            'kode_kecamatan' => 'Kode'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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
}

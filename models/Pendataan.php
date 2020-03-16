<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\component\RecordHelpers;

/**
 * This is the model class for table "pendataan".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $tanggal_entri
 * @property string $lokasi
 * @property string $desakel
 * @property string $kecamatan
 * @property string $kabupatenkota
 * @property string $provinsi
 * @property string $dataid
 * @property string $obyek
 * @property integer $jumlah_data
 * @property string $foto1
 * @property string $foto2
 * @property string $foto3
 * @property integer $setuju_status
 * @property integer $setuju_tanggal
 * @property integer $setuju_oleh
 * @property integer $version
 * @property integer $is_rev
 * @property integer $rev_tanggal
 * @property string $rev_komentar
 * @property integer $rev_oleh
 * @property integer $rev_no
 * @property string $name
 */
class Pendataan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pendataan';
    }

    // public function behaviors()
    // {
    //     return [
    //         TimestampBehavior::className(),
    //         BlameableBehavior::className()
    //     ];
    // }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'jumlah_data', 'setuju_status', 'setuju_tanggal', 'setuju_oleh', 'version', 'is_rev', 'rev_tanggal', 'rev_oleh', 'rev_no'], 'integer'],
            [['tanggal_entri', 'lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'obyek'], 'required'],
            [['tanggal_entri'], 'safe'],
            [['foto1', 'foto2', 'foto3', 'rev_komentar', 'name'], 'string'],
            [['lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'dataid', 'obyek'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Oleh',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'tanggal_entri' => 'Tanggal Entri',
            'lokasi' => 'Lokasi',
            'desakel' => 'Desa/Kel',
            'kecamatan' => 'Kecamatan',
            'kabupatenkota' => 'Kabupatenkota',
            'provinsi' => 'Provinsi',
            'dataid' => 'Dataid',
            'obyek' => 'Obyek',
            'jumlah_data' => 'Jumlah Data',
            'foto1' => 'Foto1',
            'foto2' => 'Foto2',
            'foto3' => 'Foto3',
            'setuju_status' => 'Setuju Status',
            'setuju_tanggal' => 'Setuju Tanggal',
            'setuju_oleh' => 'Setuju Oleh',
            'version' => 'Version',
            'is_rev' => 'Is Rev',
            'rev_tanggal' => 'Rev Tanggal',
            'rev_komentar' => 'Rev Komentar',
            'rev_oleh' => 'Rev Oleh',
            'rev_no' => 'Rev No',
            'name' => 'Nama Obyek'
        ];
    }

    /**
     * @inheritdoc
     * @return PendataanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendataanQuery(get_called_class());
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getFullname()
    {
        if(RecordHelpers::userHasProfile($this->created_by)) {
            return $this->createdBy->profiles->fullname;
        } else {
            return $this->createdBy->username;
        }
    }
}

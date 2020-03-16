<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konsolidasi_history".
 *
 * @property integer $id
 * @property integer $konsolidasi_id
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
 * @property string $metode
 * @property string $sub_metode
 * @property string $deskripsi
 * @property string $solusi
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
 * @property string $uuid
 *
 * @property Konsolidasi $konsolidasi
 */
class KonsolidasiHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'konsolidasi_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['konsolidasi_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'setuju_status', 'setuju_tanggal', 'setuju_oleh', 'version', 'is_rev', 'rev_tanggal', 'rev_oleh', 'rev_no'], 'integer'],
            [['tanggal_entri', 'lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'metode', 'deskripsi'], 'required'],
            [['tanggal_entri'], 'safe'],
            [['deskripsi', 'foto1', 'foto2', 'foto3', 'rev_komentar', 'uuid'], 'string'],
            [['lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'metode', 'sub_metode', 'solusi'], 'string', 'max' => 255],
            [['konsolidasi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Konsolidasi::className(), 'targetAttribute' => ['konsolidasi_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'konsolidasi_id' => 'Konsolidasi ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'tanggal_entri' => 'Tanggal Entri',
            'lokasi' => 'Lokasi',
            'desakel' => 'Desakel',
            'kecamatan' => 'Kecamatan',
            'kabupatenkota' => 'Kabupatenkota',
            'provinsi' => 'Provinsi',
            'metode' => 'Metode',
            'sub_metode' => 'Sub Metode',
            'deskripsi' => 'Deskripsi',
            'solusi' => 'Solusi',
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
            'uuid' => 'Uuid'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKonsolidasi()
    {
        return $this->hasOne(Konsolidasi::className(), ['id' => 'konsolidasi_id']);
    }

    /**
     * @inheritdoc
     * @return KonsolidasiHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KonsolidasiHistoryQuery(get_called_class());
    }
}

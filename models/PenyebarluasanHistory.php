<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penyebarluasan_history".
 *
 * @property integer $id
 * @property integer $penyebarluasan_id
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
 * @property string $tema
 * @property string $topik
 * @property integer $audiens
 * @property string $deskripsi
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
 * @property Penyebarluasan $penyebarluasan
 */
class PenyebarluasanHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'penyebarluasan_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['penyebarluasan_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'audiens', 'setuju_status', 'setuju_tanggal', 'setuju_oleh', 'version', 'is_rev', 'rev_tanggal', 'rev_oleh', 'rev_no'], 'integer'],
            [['tanggal_entri', 'lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'tema', 'topik'], 'required'],
            [['tanggal_entri'], 'safe'],
            [['metode', 'deskripsi', 'foto1', 'foto2', 'foto3', 'rev_komentar', 'uuid'], 'string'],
            [['lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'tema', 'topik'], 'string', 'max' => 255],
            [['penyebarluasan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Penyebarluasan::className(), 'targetAttribute' => ['penyebarluasan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penyebarluasan_id' => 'Penyebarluasan ID',
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
            'tema' => 'Tema',
            'topik' => 'Topik',
            'audiens' => 'Audiens',
            'deskripsi' => 'Deskripsi',
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
    public function getPenyebarluasan()
    {
        return $this->hasOne(Penyebarluasan::className(), ['id' => 'penyebarluasan_id']);
    }

    /**
     * @inheritdoc
     * @return PenyebarluasanHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PenyebarluasanHistoryQuery(get_called_class());
    }
}

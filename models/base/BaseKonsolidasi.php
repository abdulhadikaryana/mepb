<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "konsolidasi".
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
 * @property integer $setuju_status_upt
 * @property integer $setuju_tanggal_upt
 * @property integer $setuju_oleh_upt
 * @property integer $version
 * @property integer $is_rev
 * @property integer $rev_tanggal
 * @property string $rev_komentar
 * @property integer $rev_oleh
 * @property integer $rev_no
 * @property string $uuid
 *
 * @property KonsolidasiHistory[] $konsolidasiHistories
 */
class BaseKonsolidasi extends \yii\db\ActiveRecord
{
    public $provinsi_id, $kabkota_id, $tema_id, $photo;

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'konsolidasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'setuju_status', 'setuju_tanggal', 'setuju_oleh', 'setuju_status_upt', 'setuju_tanggal_upt', 'setuju_oleh_upt', 'version', 'is_rev', 'rev_tanggal', 'rev_oleh', 'rev_no'], 'integer'],
            [['tanggal_entri', 'lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'metode', 'deskripsi'], 'required'],
            [['tanggal_entri'], 'safe'],
            [['deskripsi', 'foto1', 'foto2', 'foto3', 'rev_komentar', 'uuid'], 'string'],
            [['lokasi', 'desakel', 'kecamatan', 'kabupatenkota', 'provinsi', 'metode', 'sub_metode', 'solusi'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Penggiat',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'tanggal_entri' => 'Tanggal Entri',
            'lokasi' => 'Lokasi',
            'desakel' => 'Desa/Kel',
            'kecamatan' => 'Kecamatan',
            'kabupatenkota' => 'Kabupaten/Kota',
            'provinsi' => 'Provinsi',
            'metode' => 'Metode',
            'sub_metode' => 'Sub Metode',
            'deskripsi' => 'Deskripsi',
            'solusi' => 'Solusi',
            'foto1' => 'Foto1',
            'foto2' => 'Foto2',
            'foto3' => 'Foto3',
            'setuju_status' => 'Status',
            'setuju_tanggal' => 'Setuju Tanggal',
            'setuju_oleh' => 'Setuju Oleh',
            'version' => 'Version',
            'is_rev' => 'Is Rev',
            'rev_tanggal' => 'Rev. Tanggal',
            'rev_komentar' => 'Komentar',
            'rev_oleh' => 'Rev. Oleh',
            'rev_no' => 'Rev. No',
            'uuid' => 'Uuid',
            'photo' => 'Foto'
        ];
    }

    public function generateUniqueRandomString($attribute, $length = 32) 
    {	
        $randomString = Yii::$app->getSecurity()->generateRandomString($length);
                
        if(!$this->findOne([$attribute => $randomString]))
            return $randomString;
        else
            return $this->generateUniqueRandomString($attribute, $length);
                
    }

    public function getListPenggiat()
    {
        $data = \app\models\User::find()->where(['group' => 40])->asArray()->all();

        return yii\helpers\ArrayHelper::map($data, 'id', 'email');
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

    public function getListTema()
    {
        $data = \app\models\Tema::find()->where(['flag' => 2])->asArray()->all();
        return yii\helpers\ArrayHelper::map($data, 'id', 'nama_tema');
    }

    public function getListTopik()
    {
        $data = \app\models\Topik::find()->where(['tema_id' => $this->tema_id])->asArray()->all();
        return yii\helpers\ArrayHelper::map($data, 'id', 'nama_topik');
    }
}

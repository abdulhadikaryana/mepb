<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\component\RecordHelpers;
use app\models\base\BaseKonsolidasi;

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
class Konsolidasi extends BaseKonsolidasi
{
    public $provinsi_id, $kabkota_id, $tema_id;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
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

    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         $provinsi = \app\models\Provinsi::findOne($this->provinsi);
    //         $kabupatenkota = \app\models\Kabupatenkota::findOne($this->kabupatenkota);
    //         $kecamatan = \app\models\Kecamatan::findOne($this->kecamatan);
    //         $tema = \app\models\Tema::findOne($this->metode);
    //         $topik = \app\models\Topik::findOne($this->sub_metode);

    //         $this->provinsi = $provinsi->nama_provinsi;
    //         $this->kabupatenkota = $kabupatenkota->nama_kabkota;
    //         $this->kecamatan = $kecamatan->nama_kecamatan;
    //         $this->metode = $tema->nama_tema;
    //         $this->sub_metode = $topik->nama_topik;

    //         return parent::beforeSave($insert);
            
    //     } else {
    //         return false;
    //     }
    // }

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
            'uuid' => 'Uuid'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getRevBy()
    {
        return $this->hasOne(User::className(), ['id' => 'rev_oleh']);
    }

    public function getFullname()
    {
        if(RecordHelpers::userHasProfile($this->created_by)) {
            return $this->createdBy->profiles->fullname;
        } else {
            return $this->createdBy->username;
        }
    }

    public function getFullnameDinas()
    {
        if(RecordHelpers::userHasProfile($this->rev_oleh)) {
            return $this->revBy->profiles->fullname;
        } else {
            return $this->revBy->username;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKonsolidasiHistories()
    {
        return $this->hasMany(KonsolidasiHistory::className(), ['konsolidasi_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return KonsolidasiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KonsolidasiQuery(get_called_class());
    }

    public function getStatusIcon()
    {
        if($this->setuju_status == null) {
            $response = '<span class="label label-warning"><i class="fa fa-exclamation-circle"></i></span>';
        } elseif($this->setuju_status == 0) {
            $response = '<span class="label label-danger"><i class="fa fa-close"></i></span>';
        } else {
            $response = '<span class="label label-success"><i class="fa fa-check-circle"></i></span>';
        }
        return $response;
    }

    public function getStatusDinasIcon()
    {
        if($this->setuju_status ===  1) {
            $response = '<span class="label label-success" data-hover="tooltip" data-placement="top" data-original-title="Setuju"><i class="fa fa-check"></i></span>';
        } elseif($this->setuju_status === 0) {
            $response = '<span class="label label-danger" data-hover="tooltip" data-placement="top" data-original-title="Ditolak"><i class="fa fa-close"></i></span>';
        } else {
            $response = '<span class="label label-warning" data-hover="tooltip" data-placement="top" data-original-title="Pending"><i class="fa fa-exclamation-circle"></i></span>';
        }
        return $response;
    }

    public function getStatusUptIcon()
    {
        if($this->setuju_status_upt ===  1) {
            $response = '<span class="label label-success" data-hover="tooltip" data-placement="top" data-original-title="Setuju"><i class="fa fa-check"></i></span>';
        } elseif($this->setuju_status_upt === 0) {
            $response = '<span class="label label-danger" data-hover="tooltip" data-placement="top" data-original-title="Ditolak"><i class="fa fa-close"></i></span>';
        } else {
            $response = '<span class="label label-warning" data-hover="tooltip" data-placement="top" data-original-title="Pending"><i class="fa fa-exclamation-circle"></i></span>';
        }
        return $response;
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

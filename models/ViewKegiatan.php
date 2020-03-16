<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_kegiatan".
 *
 * @property string $kegiatan
 * @property integer $id
 * @property string $tanggal_entri
 * @property string $lokasi
 */
class ViewKegiatan extends \yii\db\ActiveRecord
{
    public $penyebarluasan, $konsolidasi, $pendataan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_kegiatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['kegiatan'], 'string', 'max' => 14],
            [['tanggal_entri'], 'string', 'max' => 10],
            [['lokasi'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kegiatan' => 'Kegiatan',
            'id' => 'ID',
            'tanggal_entri' => 'Tanggal Entri',
            'lokasi' => 'Lokasi',
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getData()
    {
        
    }
}

<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tema".
 *
 * @property integer $id
 * @property string $nama_tema
 * @property integer $status
 *
 * @property Topik[] $topiks
 */
class Tema extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tema';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_tema', 'flag'], 'required'],
            [['status', 'flag'], 'integer'],
            [['nama_tema'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_tema' => 'Tema',
            'status' => 'Status',
            'flag' => 'Opsi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopiks()
    {
        return $this->hasMany(Topik::className(), ['tema_id' => 'id']);
    }

    static function staticIcon($status)
    {
        switch ($status) {
            case 20:
                $response = '<small class="label bg-yellow"><i class="fa fa-exclamation"></i></small>';
                break;
            case 0:
                $response = '<small class="label bg-red"><i class="fa fa-remove"></i></small>';
                break;
            default:
                $response = '<small class="label bg-green"><i class="fa fa-check"></i></small>';
                break;
        }
        

        return $response;
    }

    public function getStatusIcon()
    {
        return static::staticIcon($this->status);
    }

    /**
     * @inheritdoc
     * @return TemaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TemaQuery(get_called_class());
    }
}

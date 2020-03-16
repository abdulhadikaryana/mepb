<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "topik".
 *
 * @property integer $id
 * @property string $nama_topik
 * @property integer $status
 * @property integer $tema_id
 *
 * @property Tema $tema
 */
class Topik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_topik', 'tema_id'], 'required'],
            [['status', 'tema_id'], 'integer'],
            [['nama_topik'], 'string', 'max' => 255],
            [['tema_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tema::className(), 'targetAttribute' => ['tema_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_topik' => 'Nama Topik',
            'status' => 'Status',
            'tema_id' => 'Tema',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTema()
    {
        return $this->hasOne(Tema::className(), ['id' => 'tema_id']);
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

    public function getListTema()
    {
        $data = \app\models\Tema::find()->where(['status' => 10])->asArray()->all();

        return ArrayHelper::map($data, 'id', 'nama_tema');
    }

    /**
     * @inheritdoc
     * @return TopikQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TopikQuery(get_called_class());
    }
}

<?php

namespace app\models;

use app\component\Helpers;

/**
 * This is the ActiveQuery class for [[Pendataan]].
 *
 * @see Pendataan
 */
class PendataanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Pendataan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Pendataan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function createByUser()
    {
        return $this->andWhere(['created_by' => \Yii::$app->user->identity->id]);
    }

    public function allWithChild()
    {
        $parent_id = \Yii::$app->user->identity->id;
        $childs = Helpers::getIdChild($parent_id);

        return $this->andWhere(['in', 'pendataan.created_by', $childs]);
    }
}

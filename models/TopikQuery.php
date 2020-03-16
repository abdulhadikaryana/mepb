<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Topik]].
 *
 * @see Topik
 */
class TopikQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Topik[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Topik|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

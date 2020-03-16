<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[KonsolidasiHistory]].
 *
 * @see KonsolidasiHistory
 */
class KonsolidasiHistoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return KonsolidasiHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return KonsolidasiHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

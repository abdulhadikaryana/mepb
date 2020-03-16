<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PenyebarluasanHistory]].
 *
 * @see PenyebarluasanHistory
 */
class PenyebarluasanHistoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PenyebarluasanHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PenyebarluasanHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Crm]].
 *
 * @see Crm
 */
class CrmQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Crm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Crm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

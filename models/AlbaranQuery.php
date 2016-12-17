<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Albaran]].
 *
 * @see Albaran
 */
class AlbaranQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Albaran[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Albaran|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
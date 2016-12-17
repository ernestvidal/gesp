<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Albaranitem]].
 *
 * @see Albaranitem
 */
class AlbaranitemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Albaranitem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Albaranitem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Facturaitem]].
 *
 * @see Facturaitem
 */
class ProformaitemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Facturaitem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Facturaitem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
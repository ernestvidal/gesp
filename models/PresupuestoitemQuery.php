<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Presupuestoitem]].
 *
 * @see Presupuestoitem
 */
class PresupuestoitemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Presupuestoitem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Presupuestoitem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
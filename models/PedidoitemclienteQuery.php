<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Pedidoitemcliente]].
 *
 * @see Pedidoitemcliente
 */
class PedidoitemclienteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Pedidoitemcliente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Pedidoitemcliente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

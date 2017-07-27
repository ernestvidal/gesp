<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedidoitemcliente".
 *
 * @property string $pedido_id
 * @property string $pedido_num
 * @property string $item_cantidad
 * @property string $item_precio
 * @property string $item_descripcion
 *
 * @property Pedidocliente $pedidoNum
 */
class Pedidoitemcliente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedidoitemcliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pedido_num', 'item_cantidad', 'item_precio', 'item_descripcion'], 'required'],
            [['item_cantidad', 'item_precio'], 'number'],
            [['pedido_num'], 'string', 'max' => 20],
            [['item_descripcion'], 'string', 'max' => 250],
            [['item_referencia'], 'string', 'max' => 302],
            [['pedido_num'], 'exist', 'skipOnError' => true, 'targetClass' => Pedidocliente::className(), 'targetAttribute' => ['pedido_num' => 'pedido_num']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pedido_id' => 'Pedido ID',
            'pedido_num' => 'Pedido Num',
            'item_cantidad' => 'Item Cantidad',
            'item_precio' => 'Item Precio',
            'item_descripcion' => 'Item Descripcion',
            'item_referencia' => 'Referencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoNum()
    {
        return $this->hasOne(Pedidocliente::className(), ['pedido_num' => 'pedido_num']);
    }

    /**
     * @inheritdoc
     * @return PedidoitemclienteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PedidoitemclienteQuery(get_called_class());
    }
}

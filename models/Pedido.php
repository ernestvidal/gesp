<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property string $pedido_id
 * @property string $pedido_num
 * @property string $facturador_id
 * @property string $cliente_id
 * @property string $pedido_fecha
 * @property string $pedido_rate_descuento
 * @property string $pedido_rate_iva
 * @property string $pedido_rate_irpf
 * @property string $forma_pago
 *
 * @property Identidad $cliente
 * @property Identidad $facturador
 * @property Pedidoitem[] $pedidoitems
 * @property date $pedido_fecha_envio fecha en la que se envía el pedido al proveedor
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pedido_num', 'facturador_id', 'cliente_id', 'pedido_fecha', 'pedido_rate_descuento', 'pedido_rate_iva', 'pedido_rate_irpf'], 'required'],
            [['facturador_id', 'cliente_id'], 'integer'],
            [['pedido_fecha', 'pedido_img', 'pedido_fecha_envio'], 'safe'],
            [['pedido_rate_descuento', 'pedido_rate_iva', 'pedido_rate_irpf'], 'number'],
            [['pedido_num'], 'string', 'max' => 20],
            [['forma_pago', 'pedido_validez', 'pedido_plazo_entrega', 'pedido_free_one', 'pedido_free_two'], 'string', 'max' => 50],
            [['pedido_num'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pedido_id' => '#id',
            'pedido_num' => 'Núm.',
            'facturador_id' => 'Pedidodor ID',
            'cliente_id' => 'Cliente',
            'pedido_fecha' => 'Fecha',
            'pedido_rate_descuento' => 'Pedido Rate Descuento',
            'pedido_rate_iva' => 'Pedido Rate Iva',
            'pedido_rate_irpf' => 'Pedido Rate Irpf',
            'forma_pago' => 'Pedido forma de pago',
            'pedido_validez' => 'pedido_validez',
            'pedido_plazo_entrega' => 'Pedido_plazo_entrega',
            'pedido_free_one' => 'pedido_free_one', 
            'pedido_free_two' => 'Pedido fre two',
            'pedido_fecha_envio'=> 'Fecha mail'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Identidad::className(), ['identidad_id' => 'cliente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturador()
    {
        return $this->hasOne(Identidad::className(), ['identidad_id' => 'facturador_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoitems()
    {
        return $this->hasMany(Pedidoitem::className(), ['pedido_num' => 'pedido_num']);
    }

    /**
     * @inheritdoc
     * @return PedidoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PedidoQuery(get_called_class());
    }
}

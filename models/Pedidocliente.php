<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedidocliente".
 *
 * @property string $pedido_id
 * @property string $pedido_num
 * @property string $pedido_cliente_num
 * @property string $facturador_id
 * @property string $cliente_id
 * @property string $pedido_fecha
 * @property string $pedido_fecha_entrega
 * @property string $pedido_rate_descuento
 * @property string $pedido_rate_iva
 * @property string $pedido_rate_irpf
 * @property string $forma_pago
 * @property string $pedido_plazo_entrega
 * @property string $pedido_validez
 * @property string $pedido_free_one
 * @property string $pedido_free_two
 * @property string $pedido_albaran_num
 * @property string $pedido_img
 *
 * @property Identidad $cliente
 * @property Identidad $facturador
 * @property Pedidoitemcliente[] $pedidoitemclientes
 */
class Pedidocliente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedidocliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pedido_num', 'facturador_id', 'cliente_id', 'pedido_fecha', 'pedido_rate_descuento', 'pedido_rate_iva', 'pedido_rate_irpf'], 'required'],
            [['facturador_id', 'cliente_id'], 'integer'],
            [['pedido_fecha', 'pedido_fecha_entrega'], 'safe'],
            [['pedido_rate_descuento', 'pedido_rate_iva', 'pedido_rate_irpf'], 'number'],
            [['pedido_num', 'pedido_cliente_num'], 'string', 'max' => 20],
            [['forma_pago', 'pedido_plazo_entrega', 'pedido_validez', 'pedido_free_one', 'pedido_free_two', 'pedido_albaran_num'], 'string', 'max' => 50],
            [['pedido_img'], 'string', 'max' => 100],
            [['pedido_num'], 'unique'],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Identidad::className(), 'targetAttribute' => ['cliente_id' => 'identidad_id']],
            [['facturador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Identidad::className(), 'targetAttribute' => ['facturador_id' => 'identidad_id']],
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
            'pedido_cliente_num' => 'Num. pedido cliente',
            'facturador_id' => 'Facturador ID',
            'cliente_id' => 'Cliente ID',
            'pedido_fecha' => 'Fecha',
            'pedido_rate_descuento' => 'Pedido Rate Descuento',
            'pedido_rate_iva' => 'Pedido Rate Iva',
            'pedido_rate_irpf' => 'Pedido Rate Irpf',
            'forma_pago' => 'Forma Pago',
            'pedido_plazo_entrega' => 'Pedido Plazo Entrega',
            'pedido_validez' => 'Pedido Validez',
            'pedido_free_one' => 'Pedido Free One',
            'pedido_free_two' => 'Pedido Free Two',
            'pedido_albaran_num' => 'Num. albaran',
            'pedido_img' => 'Pedido Img',
            'pedido_fecha_entrega' => 'Fecha entrega'
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
    public function getPedidoitemclientes()
    {
        return $this->hasMany(Pedidoitemcliente::className(), ['pedido_num' => 'pedido_num']);
    }

    /**
     * @inheritdoc
     * @return PedidoclienteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PedidoclienteQuery(get_called_class());
    }
}

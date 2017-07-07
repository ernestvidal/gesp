<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "albaran".
 *
 * @property string $albaran_id
 * @property string $albaran_num
 * @property string $facturador_id
 * @property string $cliente_id
 * @property string $albaran_fecha
 * @property string $albaran_rate_descuento
 * @property string $albaran_rate_iva
 * @property string $albaran_rate_irpf
 * @property string $forma_pago
 * @property string $albaran_factura_num
 *
 * @property Identidad $cliente
 * @property Identidad $facturador
 * @property Albaranitem[] $albaranitems
 */
class Albaran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'albaran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['albaran_num', 'facturador_id', 'cliente_id', 'albaran_fecha', 'albaran_rate_descuento', 'albaran_rate_iva', 'albaran_rate_irpf'], 'required'],
            [['facturador_id', 'cliente_id'], 'integer'],
            [['albaran_fecha'], 'safe'],
            [['albaran_rate_descuento', 'albaran_rate_iva', 'albaran_rate_irpf'], 'number'],
            [['albaran_num','albaran_factura_num','albaran_pedido_cliente_num'], 'string', 'max' => 20],
            [['forma_pago', 'albaran_validez', 'albaran_plazo_entrega', 'albaran_free_one', 'albaran_free_two'], 'string', 'max' => 50],
            [['albaran_free_one', 'albaran_free_two'], 'string', 'max' => 100],
            [['albaran_num'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'albaran_id' => 'Albaran ID',
            'albaran_num' => 'Núm.',
            'facturador_id' => 'Albarandor ID',
            'cliente_id' => 'Cliente',
            'albaran_fecha' => 'Fecha',
            'albaran_rate_descuento' => 'Albaran Rate Descuento',
            'albaran_rate_iva' => 'Albaran Rate Iva',
            'albaran_rate_irpf' => 'Albaran Rate Irpf',
            'albaran_validez' => 'albaran_validez',
            'albaran_plazo_entrega' => 'Albaran_plazo_entrega',
            'albaran_free_one' => 'albaran_free_one', 
            'albaran_free_two' => 'Albaran fre two'
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
    public function getAlbaranitems()
    {
        return $this->hasMany(Albaranitem::className(), ['albaran_num' => 'albaran_num']);
    }

    /**
     * @inheritdoc
     * @return AlbaranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlbaranQuery(get_called_class());
    }
}

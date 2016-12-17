<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "factura".
 *
 * @property string $factura_id
 * @property string $factura_num
 * @property string $facturador_id
 * @property string $cliente_id
 * @property string $factura_fecha
 * @property string $factura_rate_descuento
 * @property string $factura_rate_iva
 * @property string $factura_rate_irpf
 *
 * @property Identidad $cliente
 * @property Identidad $facturador
 * @property FacturaItem[] $facturaItems
 */
class Factura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'factura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['factura_num', 'facturador_id', 'cliente_id', 'factura_fecha', 'factura_rate_descuento', 'factura_rate_iva', 'factura_rate_irpf'], 'required'],
            [['factura_id', 'facturador_id', 'cliente_id'], 'integer'],
            [['factura_rate_descuento', 'factura_rate_iva', 'factura_rate_irpf'], 'number'],
            [['factura_fecha', 'factura_id'], 'safe'],
            [['factura_num'], 'string', 'max' => 20],
            [['factura_num'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'factura_id' => 'Factura ID',
            'factura_num' => 'Num. factura',
            'facturador_id' => 'Facturador',
            'cliente_id' => 'Cliente',
            'factura_fecha' => 'Fecha',
            'factura_rate_descuento' => 'factura Descuento Rate',
            'factura_rate_iva' => 'factura Iva Rate',
            'factura_rate_irpf' => 'factura Irpf Rate',
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
    public function getFacturaItems()
    {
        return $this->hasMany(FacturaItem::className(), ['factura_num' => 'factura_num']);
    }

    /**
     * @inheritdoc
     * @return FacturaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FacturaQuery(get_called_class());
    }
}

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
 * @property string $forma_pago
 * @property date $factura_vto
 *
 * @property Identidad $cliente
 * @property Identidad $facturador
 * @property Facturaitem[] $facturaitems
 */
class Proforma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proforma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['factura_num', 'facturador_id', 'cliente_id', 'factura_fecha', 'factura_rate_descuento', 'factura_rate_iva', 'factura_rate_irpf'], 'required'],
            [['facturador_id', 'cliente_id'], 'integer'],
            [['factura_fecha', 'factura_vto', 'factura_vto_dos'], 'safe'],
            [['factura_rate_descuento', 'factura_rate_iva', 'factura_rate_irpf', 'factura_vto_importe', 'factura_vto_dos_importe'], 'number'],
            [['factura_num'], 'string', 'max' => 20],
            [['forma_pago'], 'string', 'max' => 50],
            [['factura_cta'], 'string', 'max' => 100],
            [['factura_num'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'factura_id' => '#id',
            'factura_num' => 'Núm.',
            'facturador_id' => 'Factura de',
            'cliente_id' => 'Cliente',
            'factura_fecha' => 'Fecha',
            'factura_rate_descuento' => 'Factura Rate Descuento',
            'factura_rate_iva' => 'Factura Rate Iva',
            'factura_rate_irpf' => 'Factura Rate Irpf',
            'factura_vto' => 'Vto. factura',
            'factura_cta' => 'Núm. cta.'
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
    public function getProformaitems()
    {
        return $this->hasMany(Proformaitem::className(), ['factura_num' => 'factura_num']);
    }

    /**
     * @inheritdoc
     * @return FacturaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProformaQuery(get_called_class());
    }
}

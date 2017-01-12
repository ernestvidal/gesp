<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proforma".
 *
 * @property string $proforma_id
 * @property string $proforma_num
 * @property string $facturador_id
 * @property string $cliente_id
 * @property string $proforma_fecha
 * @property string $proforma_rate_descuento
 * @property string $proforma_rate_iva
 * @property string $proforma_rate_irpf
 * @property string $proforma_forma_pago
 * @property date $proforma_vto
 *
 * @property Identidad $cliente
 * @property Identidad $facturador
 * @property Facturaitem[] $proformaitems
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
            [['proforma_num', 'facturador_id', 'cliente_id', 'proforma_fecha', 'proforma_rate_descuento', 'proforma_rate_iva', 'proforma_rate_irpf'], 'required'],
            [['facturador_id', 'cliente_id'], 'integer'],
            [['proforma_fecha', 'proforma_vto', 'proforma_vto_dos'], 'safe'],
            [['proforma_rate_descuento', 'proforma_rate_iva', 'proforma_rate_irpf', 'proforma_vto_importe', 'proforma_vto_dos_importe'], 'number'],
            [['proforma_num'], 'string', 'max' => 20],
            [['proforma_forma_pago','proforma_plazo_entrega','proforma_validez'], 'string', 'max' => 50],
            [['proforma_cta'], 'string', 'max' => 100],
            [['proforma_num'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'proforma_id' => '#id',
            'proforma_num' => 'Núm.',
            'facturador_id' => 'Factura de',
            'cliente_id' => 'Cliente',
            'proforma_fecha' => 'Fecha',
            'proforma_rate_descuento' => 'Factura Rate Descuento',
            'proforma_rate_iva' => 'Factura Rate Iva',
            'proforma_rate_irpf' => 'Factura Rate Irpf',
            'proforma_vto' => 'Vto. proforma',
            'proforma_cta' => 'Núm. cta.',
            'proforma_plazo_entrega'=>'Plazo de entrega',
            'proforma_validez'=>'Validez'
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
        return $this->hasMany(Proformaitem::className(), ['proforma_num' => 'proforma_num']);
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

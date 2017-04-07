<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "presupuesto".
 *
 * @property string $presupuesto_id
 * @property string $presupuesto_num
 * @property string $facturador_id
 * @property string $cliente_id
 * @property string $presupuesto_fecha
 * @property string $presupuesto_rate_descuento
 * @property string $presupuesto_rate_iva
 * @property string $presupuesto_rate_irpf
 * @property string $forma_pago
 *
 * @property Identidad $cliente
 * @property Identidad $facturador
 * @property Presupuestoitem[] $presupuestoitems
 */
class Presupuesto extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'presupuesto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['presupuesto_num', 'facturador_id', 'cliente_id', 'presupuesto_fecha', 'presupuesto_rate_descuento', 'presupuesto_rate_iva', 'presupuesto_rate_irpf'], 'required'],
            [['facturador_id', 'cliente_id'], 'integer'],
            [['presupuesto_fecha'], 'safe'],
            [['presupuesto_rate_descuento', 'presupuesto_rate_iva', 'presupuesto_rate_irpf'], 'number'],
            [['presupuesto_num'], 'string', 'max' => 20],
            [['presupuesto_img'], 'safe'],
            [['forma_pago', 'presupuesto_validez', 'presupuesto_plazo_entrega'], 'string', 'max' => 50],
            [['presupuesto_free_one'], 'string', 'max' => 100],
            [['presupuesto_free_two'], 'string'],
            [['presupuesto_num'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'presupuesto_id' => 'Presupuesto ID',
            'presupuesto_num' => 'Num.',
            'facturador_id' => 'Presupuesto de',
            'cliente_id' => 'Cliente',
            'presupuesto_fecha' => 'Fecha',
            'presupuesto_rate_descuento' => 'Presupuesto Rate Descuento',
            'presupuesto_rate_iva' => 'Presupuesto Rate Iva',
            'presupuesto_rate_irpf' => 'Presupuesto Rate Irpf',
            'presupuesto_validez' => 'presupuesto_validez',
            'presupuesto_plazo_entrega' => 'Presupuesto_plazo_entrega',
            'presupuesto_free_one' => 'presupuesto_free_one', 
            'presupuesto_free_two' => 'Presupuesto fre two'
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
    public function getPresupuestoitems()
    {
        return $this->hasMany(Presupuestoitem::className(), ['presupuesto_num' => 'presupuesto_num']);
    }

    /**
     * @inheritdoc
     * @return PresupuestoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PresupuestoQuery(get_called_class());
    }
}

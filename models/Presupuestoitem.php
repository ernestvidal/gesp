<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "presupuestoitem".
 *
 * @property string $presupuesto_id
 * @property string $presupuesto_num
 * @property string $item_cantidad
 * @property string $item_precio
 * @property string $item_descripcion
 *
 * @property Presupuesto $presupuestoNum
 */
class Presupuestoitem extends \yii\db\ActiveRecord
{
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'presupuestoitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['presupuesto_num', 'item_cantidad', 'item_precio', 'item_descripcion'], 'required', 'message'=> 'Introducir un valor para este campo'],
            [['item_cantidad', 'item_precio'], 'number'],
            [['presupuesto_num'], 'string', 'max' => 20],
            [['item_descripcion'], 'string', 'max' => 250],
            ['item_descripcion', 'default', 'value'=>'No has introducido ninguna descripción']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'presupuesto_id' => 'ID',
            'presupuesto_num' => 'Num',
            'item_cantidad' => 'Cantidad',
            'item_precio' => 'Precio',
            'item_descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresupuestoNum()
    {
        return $this->hasOne(Presupuesto::className(), ['presupuesto_num' => 'presupuesto_num']);
    }

    /**
     * @inheritdoc
     * @return PresupuestoitemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PresupuestoitemQuery(get_called_class());
    }
}

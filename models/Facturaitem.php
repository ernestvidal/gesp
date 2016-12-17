<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturaitem".
 *
 * @property string $factura_id
 * @property string $factura_num
 * @property string $item_cantidad
 * @property string $item_precio
 * @property string $item_descripcion
 *
 * @property Factura $facturaNum
 */
class Facturaitem extends \yii\db\ActiveRecord
{
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturaitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['factura_num', 'item_cantidad', 'item_precio', 'item_descripcion'], 'required'],
            [['item_cantidad', 'item_precio'], 'number'],
            [['factura_num'], 'string', 'max' => 20],
            [['item_descripcion'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'factura_id' => 'Factura ID',
            'factura_num' => 'Factura Num',
            'item_cantidad' => 'Item Cantidad',
            'item_precio' => 'Item Precio',
            'item_descripcion' => 'Item Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaNum()
    {
        return $this->hasOne(Factura::className(), ['factura_num' => 'factura_num']);
    }

    /**
     * @inheritdoc
     * @return FacturaitemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FacturaitemQuery(get_called_class());
    }
}

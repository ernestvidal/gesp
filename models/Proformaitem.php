<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proformaitem".
 *
 * @property string $proforma_id
 * @property string $proforma_num
 * @property string $item_cantidad
 * @property string $item_precio
 * @property string $item_descripcion
 *
 * @property Factura $proformaNum
 */
class Proformaitem extends \yii\db\ActiveRecord
{
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proformaitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proforma_num', 'item_cantidad', 'item_precio', 'item_descripcion'], 'required'],
            [['item_cantidad', 'item_precio'], 'number'],
            [['proforma_num'], 'string', 'max' => 20],
            [['item_descripcion'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'proforma_id' => '#ID',
            'proforma_num' => 'Factura Num',
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
        return $this->hasOne(Proforma::className(), ['proforma_num' => 'proforma_num']);
    }

    /**
     * @inheritdoc
     * @return FacturaitemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProformaitemQuery(get_called_class());
    }
}

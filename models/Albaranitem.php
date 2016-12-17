<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "albaranitem".
 *
 * @property string $albaran_id
 * @property string $albaran_num
 * @property string $item_cantidad
 * @property string $item_precio
 * @property string $item_descripcion
 *
 * @property Albaran $albaranNum
 */
class Albaranitem extends \yii\db\ActiveRecord
{
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'albaranitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['albaran_num', 'item_cantidad', 'item_descripcion'], 'required'],
            [['item_cantidad', 'item_precio'], 'number'],
            [['albaran_num'], 'string', 'max' => 20],
            [['item_descripcion'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'albaran_id' => 'Albaran ID',
            'albaran_num' => 'Albaran Num',
            'item_cantidad' => 'Item Cantidad',
            'item_precio' => 'Item Precio',
            'item_descripcion' => 'Item Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbaranNum()
    {
        return $this->hasOne(Albaran::className(), ['albaran_num' => 'albaran_num']);
    }

    /**
     * @inheritdoc
     * @return AlbaranitemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlbaranitemQuery(get_called_class());
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property string $item_id
 * @property string $item_descripcion
 * @property string $item_referencia
 * @property string $item_long_descripcion
 * @property string $modelo
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_descripcion', 'item_long_descripcion'], 'string', 'max' => 100],
            [['item_referencia'], 'string', 'max' => 30],
            [['modelo'], 'string', 'max' => 50],
            [['item_referencia'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'item_descripcion' => 'Item Descripcion',
            'item_referencia' => 'Item Referencia',
            'item_long_descripcion' => 'Item Long Descripcion',
            'modelo' => 'Modelo',
        ];
    }

    /**
     * @inheritdoc
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }
}

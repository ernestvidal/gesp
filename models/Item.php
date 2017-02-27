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
 * @property string $item_modelo
 * @property string $item_size
 * @property string $item_identidad_id
 *
 * @property Identidad $itemIdentidad
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
            [['item_descripcion', 'item_referencia', 'item_long_descripcion', 'item_modelo', 'item_size', 'item_identidad_id'], 'required'],
            [['item_identidad_id'], 'integer'],
            [['item_descripcion', 'item_long_descripcion'], 'string', 'max' => 100],
            [['item_referencia'], 'string', 'max' => 30],
            [['item_modelo'], 'string', 'max' => 50],
            [['item_size'], 'string', 'max' => 25],
            [['item_referencia'], 'unique'],
            [['item_identidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Identidad::className(), 'targetAttribute' => ['item_identidad_id' => 'identidad_id']],
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
            'item_modelo' => 'Item Modelo',
            'item_size' => 'Item Tamaño',
            'item_identidad_id' => 'Item Identidad ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemIdentidad()
    {
        return $this->hasOne(Identidad::className(), ['identidad_id' => 'item_identidad_id']);
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

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property string $item_id
 * @property string $item_descripcion
 * @property string $item_long_descripcion
 * @property string $item_referencia
 * @property string $item_modelo
 * @property string $item_referencia_cliente
 * @property string $item_size
 * @property string $item_material
 * @property string $item_acabado
 * @property string $item_identidad_id
 * @property string $item_url_imagen
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
            [['item_descripcion', 'item_identidad_id'], 'required'],
            [['item_identidad_id'], 'integer'],
            [['item_descripcion', 'item_long_descripcion', 'item_material', 'item_acabado'], 'string', 'max' => 250],
            [['item_referencia'], 'string', 'max' => 30],
            [['item_modelo', 'item_referencia_cliente', 'item_url_imagen'], 'string', 'max' => 50],
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
            'item_id' => '#ID',
            'item_descripcion' => 'Descripcion',
            'item_long_descripcion' => 'Item Long Descripcion',
            'item_referencia' => 'Referencia',
            'item_modelo' => 'Modelo',
            'item_referencia_cliente' => 'Referencia Cliente',
            'item_size' => 'Tamaño',
            'item_material' => 'Material',
            'item_acabado' => 'Acabado',
            'item_identidad_id' => 'Identidad ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemIdentidad()
    {
        return $this->hasOne(Identidad::className(), ['identidad_id' => 'item_identidad_id']);
    }
}

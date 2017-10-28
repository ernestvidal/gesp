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
 * @property string $item_material
 * @property string $item_acabado
 * @property string $item_identidad_id
 * @property string $item_url_imagen
 * @property Identidad $itemIdentidad
 * @property string  $item_sistema_impresion 
 * @property integer $item_ancho 
 * @property integer $item_largo 
 * @property string $item_numero_pantalla
 * @property date $item_fecha 
 * @property string $item_precio_venta
 * @property string $item_precio_compra
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
            [['item_identidad_id','item_ancho','item_largo'], 'integer'],
            [['item_descripcion', 'item_long_descripcion', 'item_material', 'item_acabado'], 'string', 'max' => 250],
            [['item_referencia'], 'string', 'max' => 30],
            [['item_numero_pantalla'], 'string', 'max' => 10],
            [['item_sistema_impresion'], 'string', 'max' => 25],        
            [['item_precio_compra'], 'string', 'max' => 15],
            [['item_modelo', 'item_referencia_cliente','item_precio_venta'], 'string', 'max' => 50],
            [['item_url_imagen'], 'string', 'max' => 150],
            [['item_sistema_impresion'], 'string', 'max' => 25],
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
            'item_sistema_impresion' => 'Sistema impresión',
            'item_ancho' =>'Ancho mm',
            'item_largo' =>'Largo mm',
            'item_numero_pantalla'=>'Núm. Pantalla',
            'item_precio_venta' => 'Precio de venta',
            'item_precio_compra'=>'Precio de compra'
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

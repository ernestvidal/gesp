<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "identidad".
 *
 * @property string $identidad_id
 * @property string $identidad_nombre
 * @property string $identidad_direccion
 * @property string $identidad_poblacion
 * @property string $identidad_nif
 * @property string $identidad_mail
 * @property string $identidad_provincia
 * @property integer $identidad_cp
 *
 * 
 */
class Identidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'identidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identidad_nombre', 'identidad_direccion', 'identidad_poblacion', 'identidad_mail', 'identidad_forma_pago','identidad_provincia'], 'string', 'max' => 50],
            [['identidad_nif'], 'string', 'max' => 9],
            [['identidad_cp'], 'string', 'max' => 5],
            [['identidad_phone'], 'string', 'max' => 11],
            [['identidad_cta'], 'string', 'max'=>50],
            [['identidad_forma_pago','identidad_web'], 'string', 'max'=>100],
            [['identidad_role'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'identidad_id' => '#Id',
            'identidad_nombre' => 'Nombre',
            'identidad_direccion' => 'Direccion',
            'identidad_poblacion' => 'Poblacion',
            'identidad_nif' => 'Nif',
            'identidad_mail' => 'Mail',
            'identidad_forma_pago' => 'Forma de pago',
            'identidad_cp' => 'C.Postal',
            'identidad_provincia' => 'Provincia',
            'identidad_phone' => 'Teléfono',
            'identidad_role' => 'Role',
            'identidad_cta' => 'Cta.núm.',
            'identidad_web' => 'Web'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturas()
    {
        return $this->hasMany(Factura::className(), ['cliente_id' => 'identidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturas0()
    {
        return $this->hasMany(Factura::className(), ['facturador_id' => 'identidad_id']);
    }

    /**
     * @inheritdoc
     * @return IdentidadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IdentidadQuery(get_called_class());
    }
}

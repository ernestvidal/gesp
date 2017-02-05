<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cargo".
 *
 * @property integer $cargo_id
 * @property integer $cargo_identidad_id
 * @property string $cargo_nombre
 * @property string $cargo_phone
 * @property string $cargo_cargo
 * @property string $cargo_mail
 *
 * @property Identidad $cargoIdentidad
 */
class Cargo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cargo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cargo_identidad_id'], 'integer'],
            [['cargo_nombre', 'cargo_cargo', 'cargo_mail'], 'string', 'max' => 50],
            [['cargo_phone'], 'string', 'max' => 9],
            [['cargo_identidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Identidad::className(), 'targetAttribute' => ['cargo_identidad_id' => 'identidad_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cargo_id' => '#Id',
            'cargo_identidad_id' => 'Identidad #id',
            'cargo_nombre' => 'Nombre',
            'cargo_phone' => 'Phone',
            'cargo_cargo' => 'Cargo',
            'cargo_mail' => 'Mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargoIdentidad()
    {
        return $this->hasOne(Identidad::className(), ['identidad_id' => 'cargo_identidad_id']);
    }

    /**
     * @inheritdoc
     * @return CargoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CargoQuery(get_called_class());
    }
}

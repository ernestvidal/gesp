<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "crm".
 *
 * @property string $id
 * @property string $fecha
 * @property string $identidad_id
 * @property string $asunto
 * @property resource $conclusion
 *
 * @property Identidad $identidad
 */
class Crm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['identidad_id', 'asunto', 'conclusion'], 'required'],
            [['identidad_id'], 'integer'],
            [['conclusion'], 'string'],
            [['asunto'], 'string', 'max' => 50],
            [['identidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Identidad::className(), 'targetAttribute' => ['identidad_id' => 'identidad_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'identidad_id' => 'Identidad ID',
            'asunto' => 'Asunto',
            'conclusion' => 'Conclusion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentidad()
    {
        return $this->hasOne(Identidad::className(), ['identidad_id' => 'identidad_id']);
    }

    /**
     * @inheritdoc
     * @return CrmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrmQuery(get_called_class());
    }
}

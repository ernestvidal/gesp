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
class Identidad extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'identidad';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['identidad_nombre', 'identidad_poblacion', 'identidad_mail', 'identidad_forma_pago',
            'identidad_provincia',
            'identidad_cta',
            'identidad_persona_contacto',
            'identidad_actividad',
            'identidad_razon_social'], 'string', 'max' => 50],
            ['identidad_nombre', 'required'],
            ['identidad_direccion', 'string', 'max' => '75'],
            //[['identidad_nif'], 'string', 'max' => 9],
            ['identidad_nif', 'validarNif'],
            ['identidad_nif', 'unique'],
            ['identidad_cp', 'string', 'max' => 5],
            [['identidad_phone', 'identidad_mobile_phone'], 'string', 'max' => 11],
            ['identidad_phone', 'unique'],
            [['identidad_forma_pago', 'identidad_web'], 'string', 'max' => 100],
            [['identidad_role'], 'string']
        ];
    }

    public function validarNif($attribute, $params)
    {
        $cif = strtoupper($this->$attribute);

        for ($i = 0; $i < 9; $i ++) {
            $num[$i] = substr($cif, $i, 1);
        }
        
        //si no tiene un formato valido devuelve error
        if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif)) {
             $this->addError($attribute, 'Nif incorrecto 1');

           // return 0;
        }
        
        //comprobacion de NIFs estandar
        if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif)) {
            if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1)) {
                return 1;
            } else {
                return -1;
            }
        }
        //algoritmo para comprobacion de codigos tipo CIF
        $suma = $num[2] + $num[4] + $num[6];
        for ($i = 1; $i < 8; $i += 2) {
            $suma += substr((2 * $num[$i]), 0, 1) + substr((2 * $num[$i]), 1, 1);
        }
        $n = 10 - substr($suma, strlen($suma) - 1, 1);
        //comprobacion de NIFs especiales (se calculan como CIFs)
        if (preg_match('/^[KLM]{1}/', $cif)) {
            if ($num[8] == chr(64 + $n)) {
                return 1;
            } else {
                return -1;
            }
        }
        //comprobacion de CIFs
        if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif)) {
            if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1)) {
                return 2;
            } else {
                return -2;
            }
        }
        //comprobacion de NIEs
        //T
        if (preg_match('/^[T]{1}/', $cif)) {
            if ($num[8] == preg_match('/^[T]{1}[A-Z0-9]{8}$/', $cif)) {
                return 3;
            } else {
                return -3;
            }
        }
        //XYZ
        if (preg_match('/^[XYZ]{1}/', $cif)) {
            if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X', 'Y', 'Z'), array('0', '1', '2'), $cif), 0, 8) % 23, 1)) {
                return 3;
            } else {
                return -3;
            }
        }
        //si todavia no se ha verificado devuelve error
        
         $this->addError($attribute, 'Nif incorrecto');
         //return 0;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'identidad_id' => '#Id',
            'identidad_nombre' => 'Nombre',
            'identidad_direccion' => 'Direccion',
            'identidad_poblacion' => 'Poblacion',
            'identidad_nif' => 'Nif',
            'identidad_mail' => 'Mail',
            'identidad_persona_contacto' => 'Contacto',
            'identidad_forma_pago' => 'Forma de pago',
            'identidad_cp' => 'C.Postal',
            'identidad_provincia' => 'Provincia',
            'identidad_phone' => 'Teléfono',
            'identidad_mobile_phone' => 'Móvil',
            'identidad_role' => 'Role',
            'identidad_cta' => 'Cta.núm.',
            'identidad_web' => 'Web',
            'identidad_actividad' => 'Actividad',
            'identidad_razon_social' => 'Razón social'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturas() {
        return $this->hasMany(Factura::className(), ['cliente_id' => 'identidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturas0() {
        return $this->hasMany(Factura::className(), ['facturador_id' => 'identidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargos() {
        return $this->hasMany(Cargo::className(), ['cargo_identidad_id' => 'identidad_id']);
    }

    /**
     * @inheritdoc
     * @return IdentidadQuery the active query used by this AR class.
     */
    public static function find() {
        return new IdentidadQuery(get_called_class());
    }

}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Identidad;

/**
 * IdentidadSearch represents the model behind the search form about `app\models\Identidad`.
 */
class IdentidadSearch extends Identidad {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['identidad_id'], 'integer'],
            [['identidad_nombre','identidad_poblacion', 'identidad_direccion', 'identidad_provincia', 'identidad_actividad', 'identidad_web', 'identidad_mail', 'identidad_phone', 'identidad_role', 'identidad_persona_contacto'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Identidad::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'identidad_id' => $this->identidad_id,
            'identidad_poblacion' => $this->identidad_poblacion,
        ]);

        $query->andFilterWhere(['like', 'identidad_nombre', $this->identidad_nombre])
                ->andFilterWhere(['like', 'identidad_direccion', $this->identidad_direccion])
                ->andFilterWhere(['like', 'identidad_nif', $this->identidad_nif])
                ->andFilterWhere(['like', 'identidad_role', $this->identidad_role])
                ->andFilterWhere(['like', 'identidad_persona_contacto', $this->identidad_persona_contacto])
                ->andFilterWhere(['like', 'identidad_phone', $this->identidad_phone])
                
        ;

        return $dataProvider;
    }

}

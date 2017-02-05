<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cargo;

/**
 * SearchCargo represents the model behind the search form about `app\models\Cargo`.
 */
class SearchCargo extends Cargo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cargo_id', 'cargo_identidad_id'], 'integer'],
            [['cargo_nombre', 'cargo_phone', 'cargo_cargo', 'cargo_mail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Cargo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'cargo_id' => $this->cargo_id,
            'cargo_identidad_id' => $this->cargo_identidad_id,
        ]);

        $query->andFilterWhere(['like', 'cargo_nombre', $this->cargo_nombre])
            ->andFilterWhere(['like', 'cargo_phone', $this->cargo_phone])
            ->andFilterWhere(['like', 'cargo_cargo', $this->cargo_cargo])
            ->andFilterWhere(['like', 'cargo_mail', $this->cargo_mail]);

        return $dataProvider;
    }
}

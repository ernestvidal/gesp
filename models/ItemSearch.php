<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Item;

/**
 * SearchItem represents the model behind the search form about `app\models\Item`.
 */
class ItemSearch extends Item
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'item_identidad_id'], 'integer'],
            [['item_descripcion', 'item_referencia', 'item_long_descripcion', 'item_modelo', 'item_size'], 'safe'],
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
        $query = Item::find();

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
            'item_id' => $this->item_id,
            'item_identidad_id' => $this->item_identidad_id,
        ]);

        $query->andFilterWhere(['like', 'item_descripcion', $this->item_descripcion])
            ->andFilterWhere(['like', 'item_referencia', $this->item_referencia])
            ->andFilterWhere(['like', 'item_long_descripcion', $this->item_long_descripcion])
            ->andFilterWhere(['like', 'item_modelo', $this->item_modelo])
            ->andFilterWhere(['like', 'item_size', $this->item_size]);

        return $dataProvider;
    }
}

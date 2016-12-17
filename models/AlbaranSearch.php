<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\albaran;

/**
 * albaranSearch represents the model behind the search form about `app\models\albaran`.
 */
class albaranSearch extends albaran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['albaran_id', 'facturador_id', 'cliente_id'], 'integer'],
            [['albaran_num', 'albaran_fecha'], 'safe'],
            [['albaran_rate_descuento', 'albaran_rate_iva', 'albaran_rate_irpf'], 'number'],
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
        $query = albaran::find()->with('albaranitems');

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
            'albaran_id' => $this->albaran_id,
            'facturador_id' => $this->facturador_id,
            'cliente_id' => $this->cliente_id,
            'albaran_fecha' => $this->albaran_fecha,
            'albaran_rate_descuento' => $this->albaran_rate_descuento,
            'albaran_rate_iva' => $this->albaran_rate_iva,
            'albaran_rate_irpf' => $this->albaran_rate_irpf,
        ]);

        $query->andFilterWhere(['like', 'albaran_num', $this->albaran_num]);

        return $dataProvider;
    }
}

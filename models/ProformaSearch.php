<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proforma;

/**
 * proformaSearch represents the model behind the search form about `app\models\proforma`.
 */
class proformaSearch extends proforma
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proforma_id', 'facturador_id', 'cliente_id'], 'integer'],
            [['proforma_num', 'proforma_fecha'], 'safe'],
            [['proforma_rate_descuento', 'proforma_rate_iva', 'proforma_rate_irpf'], 'number'],
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
        $query = proforma::find()->with('proformaitems');

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
            'proforma_id' => $this->proforma_id,
            'facturador_id' => $this->facturador_id,
            'cliente_id' => $this->cliente_id,
            'proforma_fecha' => $this->proforma_fecha,
            'proforma_rate_descuento' => $this->proforma_rate_descuento,
            'proforma_rate_iva' => $this->proforma_rate_iva,
            'proforma_rate_irpf' => $this->proforma_rate_irpf,
        ]);

        $query->andFilterWhere(['like', 'proforma_num', $this->proforma_num]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pedido;

/**
 * pedidoSearch represents the model behind the search form about `app\models\pedido`.
 */
class pedidoSearch extends pedido
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pedido_id', 'facturador_id', 'cliente_id'], 'integer'],
            [['pedido_num', 'pedido_fecha'], 'safe'],
            [['pedido_rate_descuento', 'pedido_rate_iva', 'pedido_rate_irpf'], 'number'],
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
        $query = pedido::find()->with('pedidoitems');

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
            'pedido_id' => $this->pedido_id,
            'facturador_id' => $this->facturador_id,
            'cliente_id' => $this->cliente_id,
            'pedido_fecha' => $this->pedido_fecha,
            'pedido_rate_descuento' => $this->pedido_rate_descuento,
            'pedido_rate_iva' => $this->pedido_rate_iva,
            'pedido_rate_irpf' => $this->pedido_rate_irpf,
        ]);

        $query->andFilterWhere(['like', 'pedido_num', $this->pedido_num]);

        return $dataProvider;
    }
}

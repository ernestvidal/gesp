<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pedidocliente;

/**
 * PedidoclienteSearch represents the model behind the search form about `app\models\Pedidocliente`.
 */
class PedidoclienteSearch extends Pedidocliente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pedido_id', 'facturador_id', 'cliente_id'], 'integer'],
            [['pedido_num', 'pedido_fecha', 'forma_pago', 'pedido_plazo_entrega', 'pedido_validez', 'pedido_free_one', 'pedido_free_two', 'pedido_factura_num', 'pedido_img'], 'safe'],
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
        $query = Pedidocliente::find();

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
            'pedido_id' => $this->pedido_id,
            'facturador_id' => $this->facturador_id,
            'cliente_id' => $this->cliente_id,
            'pedido_fecha' => $this->pedido_fecha,
            'pedido_rate_descuento' => $this->pedido_rate_descuento,
            'pedido_rate_iva' => $this->pedido_rate_iva,
            'pedido_rate_irpf' => $this->pedido_rate_irpf,
        ]);

        $query->andFilterWhere(['like', 'pedido_num', $this->pedido_num])
            ->andFilterWhere(['like', 'forma_pago', $this->forma_pago])
            ->andFilterWhere(['like', 'pedido_plazo_entrega', $this->pedido_plazo_entrega])
            ->andFilterWhere(['like', 'pedido_validez', $this->pedido_validez])
            ->andFilterWhere(['like', 'pedido_free_one', $this->pedido_free_one])
            ->andFilterWhere(['like', 'pedido_free_two', $this->pedido_free_two])
            ->andFilterWhere(['like', 'pedido_factura_num', $this->pedido_factura_num])
            ->andFilterWhere(['like', 'pedido_img', $this->pedido_img]);

        return $dataProvider;
    }
}

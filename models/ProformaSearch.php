<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proforma;

/**
 * facturaSearch represents the model behind the search form about `app\models\factura`.
 */
class proformaSearch extends proforma
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['factura_id', 'facturador_id', 'cliente_id'], 'integer'],
            [['factura_num', 'factura_fecha'], 'safe'],
            [['factura_rate_descuento', 'factura_rate_iva', 'factura_rate_irpf'], 'number'],
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
        $query = proforma::find()->with('facturaitems');

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
            'factura_id' => $this->factura_id,
            'facturador_id' => $this->facturador_id,
            'cliente_id' => $this->cliente_id,
            'factura_fecha' => $this->factura_fecha,
            'factura_rate_descuento' => $this->factura_rate_descuento,
            'factura_rate_iva' => $this->factura_rate_iva,
            'factura_rate_irpf' => $this->factura_rate_irpf,
        ]);

        $query->andFilterWhere(['like', 'factura_num', $this->factura_num]);

        return $dataProvider;
    }
}

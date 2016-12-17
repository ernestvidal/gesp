<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\presupuesto;

/**
 * presupuestoSearch represents the model behind the search form about `app\models\presupuesto`.
 */
class presupuestoSearch extends presupuesto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['presupuesto_id', 'facturador_id', 'cliente_id'], 'integer'],
            [['presupuesto_num', 'presupuesto_fecha'], 'safe'],
            [['presupuesto_rate_descuento', 'presupuesto_rate_iva', 'presupuesto_rate_irpf'], 'number'],
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
        $query = presupuesto::find()->with('presupuestoitems');

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
            'presupuesto_id' => $this->presupuesto_id,
            'facturador_id' => $this->facturador_id,
            'cliente_id' => $this->cliente_id,
            'presupuesto_fecha' => $this->presupuesto_fecha,
            'presupuesto_rate_descuento' => $this->presupuesto_rate_descuento,
            'presupuesto_rate_iva' => $this->presupuesto_rate_iva,
            'presupuesto_rate_irpf' => $this->presupuesto_rate_irpf,
        ]);

        $query->andFilterWhere(['like', 'presupuesto_num', $this->presupuesto_num]);

        return $dataProvider;
    }
}
